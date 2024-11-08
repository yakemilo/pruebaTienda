<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Usuario;
use AppBundle\Form\ProductoType;
use Doctrine\ORM\Query\AST\UpdateItem;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class productoController extends Controller
{
    
    //Listado de Productos

    public function listAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Producto')->findAll();

        // Obtener el paginador
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, // Query de Doctrine
            $request->query->getInt('page', 1), // Número de página (por defecto 1)
            5 // Cantidad de elementos por página
        );

        $deleteFormAjax = $this->createCustomForm(':PRODUCTO_ID', 'DELETE', 'app_producto_delete');

        return $this->render('producto/list.html.twig', [
            'pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView()
        ]);
    }

    //Adicionar un Producto

    public function addAction()
    {
        $producto = new Producto();
        $form = $this->createCreateForm($producto);

        return $this->render('producto/add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType, $entity, array(
            'action' => $this->generateUrl('app_producto_create'),
            'method' => 'POST'
        ));

        return $form;
    }

    public function createAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createCreateForm($producto);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto); 
            $em->flush();

            $this->addFlash('mensajeSuccess','El producto ha sido guardado satisfactoriamente');

            return $this->redirectToRoute('app_producto_list');
            
        }

        return $this->render('producto/add.html.twig', array('form' => $form->createView()));
    }

    //Editar un Producto

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('AppBundle:Producto')->find($id);

        $form = $this->createEditForm($producto);
        
        return $this->render('producto/edit.html.twig', array('producto' => $producto, 'form' => $form->createView()));

    }

    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('app_producto_update', array('id'=> $entity->getId())),
            'method' => 'PUT'
        )); 

        return $form;
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('AppBundle:Producto')->find($id);

        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado');
        }

        $form = $this->createEditForm($producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->flush();

            $this->addFlash('mensajeSuccess','El producto ha sido actualizado satisfactoriamente');

            return $this->redirectToRoute('app_producto_edit', array('id'=>$producto->getId()));
        }

        return $this->render('producto/edit.html.twig', array('producto' => $producto, 'form' => $form->createView()));

    }

    //Ver datos de un Producto
    
    public function detailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('AppBundle:Producto')->find($id);
        
        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado');
        }

        $almacen = $producto->getAlmacen();
        $temperatura = $producto->getTemperatura();

        $deleteForm = $this->createCustomForm($producto->getId(), 'DELETE', 'app_producto_delete');

        //return $this->render('producto/details.html.twig', array('producto' => $producto, 'delete_form'=> $deleteForm->createView()));

        return $this->render('producto/details.html.twig', array('producto'=> $producto, 'almacen' => $almacen, 'temperatura'=> $temperatura, 'delete_form'=>$deleteForm->createView()));

    }

    //Eliminar un Producto

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('AppBundle:Producto')->find($id);

        if (!$producto) {
            throw $this->createNotFoundException('Producto no encontrado');
        }
        
        $form = $this->createCustomForm($producto->getId(), 'DELETE', 'app_producto_delete');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            if($request->isXmlHttpRequest()){
                $res = $this->deleteProducto($em, $producto);

                return new Response(
                    json_encode(array('removed'=>$res['removed'], 'message'=>$res['message'])),
                    200,
                    array('Content-type' => 'application/json')
                );
            }

            $res = $this->deleteProducto($em, $producto);

            $this->addFlash($res['alert'],$res['message']);
            return $this->redirectToRoute('app_producto_list');
        }

        return $this->redirectToRoute('app_producto_list');
    }

    private function createCustomForm($id, $method, $route){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id'=>$id)))
            ->setMethod($method)
            ->getForm();
    }

    private function deleteProducto($em, $producto){

        $em->remove($producto);
        $em->flush();

        $message = 'El producto ha sido eliminado satisfactoriamente';
        $removed = 1;
        $alert = 'mensajeSuccess';

        return array('removed'=>$removed, 'message'=>$message,'alert'=>$alert);
    }

    
}
