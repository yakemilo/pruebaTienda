<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Almacen;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Usuario;
use AppBundle\Form\AlmacenType;
use Doctrine\ORM\Query\AST\UpdateItem;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class almacenController extends Controller
{
    
    //Listado de Almacenes

    public function listAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Almacen')->findAll();

        // Obtener el paginador
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, // Query de Doctrine
            $request->query->getInt('page', 1), // Número de página (por defecto 1)
            5 // Cantidad de elementos por página
        );

        $deleteFormAjax = $this->createCustomForm(':ALMACEN_ID', 'DELETE', 'app_almacen_delete');

        return $this->render('almacen/list.html.twig', [
            'pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()
        ]);
    }

    //Adicionar un Almacen

    public function addAction()
    {
        $almacen = new Almacen();
        $form = $this->createCreateForm($almacen);

        return $this->render('almacen/add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm(Almacen $entity)
    {
        $form = $this->createForm(new AlmacenType, $entity, array(
            'action' => $this->generateUrl('app_almacen_create'),
            'method' => 'POST'
        ));

        return $form;
    }

    public function createAction(Request $request)
    {
        $almacen = new Almacen();
        $form = $this->createCreateForm($almacen);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($almacen); 
            $em->flush();

            $this->addFlash('mensajeSuccess','El almacén ha sido guardado satisfactoriamente');

            return $this->redirectToRoute('app_almacen_list');
            
        }

        return $this->render('almacen/add.html.twig', array('form' => $form->createView()));
    }

    //Editar un almacen

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $almacen = $em->getRepository('AppBundle:Almacen')->find($id);

        $form = $this->createEditForm($almacen);
        
        return $this->render('almacen/edit.html.twig', array('almacen' => $almacen, 'form' => $form->createView()));

    }

    private function createEditForm(Almacen $entity)
    {
        $form = $this->createForm(new AlmacenType(), $entity, array(
            'action' => $this->generateUrl('app_almacen_update', array('id'=> $entity->getId())),
            'method' => 'PUT'
        )); 

        return $form;
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $almacen = $em->getRepository('AppBundle:Almacen')->find($id);

        if (!$almacen) {
            throw $this->createNotFoundException('Almacen no encontrado');
        }

        $form = $this->createEditForm($almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->flush();

            $this->addFlash('mensajeSuccess','El almacen ha sido actualizado satisfactoriamente');

            return $this->redirectToRoute('app_almacen_edit', array('id'=>$almacen->getId()));
        }

        return $this->render('almacen/edit.html.twig', array('almacen' => $almacen, 'form' => $form->createView()));

    }

    //Ver datos de un almacen
    
    public function detailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $almacen = $em->getRepository('AppBundle:Almacen')->find($id);
        
        if (!$almacen) {
            throw $this->createNotFoundException('Almacen no encontrado');
        }

        $deleteForm = $this->createCustomForm($almacen->getId(), 'DELETE', 'app_almacen_delete');

        return $this->render('almacen/details.html.twig', array('almacen' => $almacen, 'delete_form'=> $deleteForm->createView()));

    }

    //Eliminar un Almacen

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $almacen = $em->getRepository('AppBundle:Almacen')->find($id);

        if (!$almacen) {
            throw $this->createNotFoundException('Almacen no encontrado');
        }
        
        $form = $this->createCustomForm($almacen->getId(), 'DELETE', 'app_almacen_delete');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            if($request->isXmlHttpRequest()){
                $res = $this->deleteAlmacen($almacen->getActivo(),$em, $almacen);

                return new Response(
                    json_encode(array('removed'=>$res['removed'], 'message'=>$res['message'])),
                    200,
                    array('Content-type' => 'application/json')
                );
            }

            $res = $this->deleteAlmacen($almacen->getActivo(),$em, $almacen);

            $this->addFlash($res['alert'],$res['message']);
            return $this->redirectToRoute('app_almacen_list');
        }

        return $this->redirectToRoute('app_almacen_list');
    }

    private function createCustomForm($id, $method, $route){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id'=>$id)))
            ->setMethod($method)
            ->getForm();
    }

    private function deleteAlmacen($activo, $em, $almacen){
        
        if ($activo == 1){
            $message = 'El almacen no puede ser eliminado si está Activo';
            $removed = 0;
            $alert = 'error';
        }
        else{
            $em->remove($almacen);
            $em->flush();

            $message = 'El almacen ha sido eliminado';
            $removed = 1;
            $alert = 'mensajeSuccess';
        }

        return array('removed'=>$removed, 'message'=>$message,'alert'=>$alert);
    }

    
}
