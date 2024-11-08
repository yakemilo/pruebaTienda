<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use AppBundle\Repository\UsuarioRepository;
use Doctrine\ORM\Query\AST\UpdateItem;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class usuarioController extends Controller
{
    
    public function indexAction()
    {
        /*// replace this example code with whatever you need
        $repositoryUsuario = $this->getDoctrine()->getRepository('AppBundle:Usuario');
        //$em = $this->getDoctrine()->getRepository('AppBundle\Entity\Usuario');

        $usuarios = $repositoryUsuario->findAll();

        /*$result = 'Lista de usuarios: <br/> ';

        foreach ($usuarios as $usuario) {
            $result .= 'Usuario: ' .$usuario->getUsuario() .' - Email: '.$usuario->getEmail(). '<br/>';
        }

        return new Response($result);*/

        return $this->render('home.html.twig');
    }

    public function listAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Usuario')->findAll();

        // Obtener el paginador
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, // Query de Doctrine
            $request->query->getInt('page', 1), // Número de página (por defecto 1)
            5 // Cantidad de elementos por página
        );

        $deleteFormAjax = $this->createCustomForm(':USUARIO_ID', 'DELETE', 'app_usuario_delete');

        return $this->render('usuario/list.html.twig', [
            'pagination' => $pagination, 'delete_form_ajax' => $deleteFormAjax->createView(),
        ]);

        /*$repositoryUsuario = $this->getDoctrine()->getRepository('AppBundle:Usuario');

        $usuarios = $repositoryUsuario->findAll();

        return $this->render('usuario/list.html.twig', array('usuarios' => $usuarios));*/
    }

    public function addAction()
    {
        $usuario = new Usuario();
        $form = $this->createCreateForm($usuario);

        return $this->render('usuario/add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('app_usuario_create'),
            'method' => 'POST'
        ));

        return $form;
    }

    public function createAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createCreateForm($usuario);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $password = $form->get('password')->getData();

            $passwordConstraint = new Assert\NotBlank();
            $errorList = $this->get('validator')->validate($password, $passwordConstraint);

            if (count($errorList) == 0) {
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($usuario, $password);

                $usuario->setPassword($encoded);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario); 
                $em->flush();

                $this->addFlash('mensajeSuccess','El usuario ha sido guardado satisfactoriamente');

                return $this->redirectToRoute('app_usuario_list');
            }
            else
            {
                $errorMessage = new FormError($errorList[0]->getMessage());
                $form->get('password')->addError($errorMessage);
            }
            
        }

        return $this->render('usuario/add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id)
    {
        $usuario = $this->buscarUsuarioAction($id);

        $form = $this->createEditForm($usuario);
        
        return $this->render('usuario/edit.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));

    }

    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('app_usuario_update', array('id'=> $entity->getId())),
            'method' => 'PUT'
        )); 

        return $form;
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $form = $this->createEditForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $password = $form->get('password')->getData();
            
            if (!empty($password)) {
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($usuario, $password);

                $usuario->setPassword($encoded);
            }
            else
            {
                $recoverPass = $this->recoverPass($id);

                $usuario->setPassword($recoverPass[0]['password']);
            }

            if ($form->get('role')->getData() == 'ROLE_ADMIN') {
                $usuario->setActivo(1);
            }

            $em->flush();

            $this->addFlash('mensajeSuccess','El usuario ha sido actualizado satisfactoriamente');

            return $this->redirectToRoute('app_usuario_edit', array('id'=>$usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));

    }

    private function recoverPass($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT u.password
            FROM AppBundle:Usuario u
            WHERE u.id = :id'
        )->setParameter('id', $id);

        $currentPass = $query->getResult();

        return $currentPass;        
    }
    
    public function detailsAction($id)
    {
        $usuario = $this->buscarUsuarioAction($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $deleteForm = $this->createCustomForm($usuario->getId(), 'DELETE', 'app_usuario_delete');

        return $this->render('usuario/details.html.twig', array('usuario' => $usuario, 'delete_form'=> $deleteForm->createView()));
    }

/*    private function createDeleteForm($usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_usuario_delete', array('id'=> $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }*/

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($id);


        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }
        
        //$form = $this->createDeleteForm($usuario);
        $form = $this->createCustomForm($usuario->getId(), 'DELETE', 'app_usuario_delete');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if($request->isXmlHttpRequest()){
                $res = $this->deleteUser($usuario->getRole(), $em, $usuario);

                return new Response(
                    json_encode(array('removed'=>$res['removed'], 'message'=>$res['message'])),
                    200,
                    array('Content-type' => 'application/json')
                );
            }

            $res = $this->deleteUser($usuario->getRole(), $em, $usuario);

            $this->addFlash($res['alert'],$res['message']);
            return $this->redirectToRoute('app_usuario_list');
        }

        return $this->redirectToRoute('app_usuario_list');
    }

    private function createCustomForm($id, $method, $route){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id'=>$id)))
            ->setMethod($method)
            ->getForm();
    }

    private function deleteUser($role, $em, $usuario){
        if ($role == 'ROLE_USER' || $role == 'ROLE_CLIENT'){
            $em->remove($usuario);
            $em->flush();

            $message = 'El usuario ha sido eliminado';
            $removed = 1;
            $alert = 'mensajeSuccess';
        }
        elseif($role == 'ROLE_ADMIN'){
            $message = 'El usuario no puede ser eliminado';
            $removed = 0;
            $alert = 'error';
        }

        return array('removed'=>$removed, 'message'=>$message,'alert'=>$alert);
    }
    
    public function buscarUsuarioAction($id)
    {        
        /*$em = $this->getDoctrine()->getRepository('AppBundle\Entity\Usuario');
        $result = 'El usuario solicitado es: '.$usuario->getUsuario() .' - Email: '.$usuario->getEmail(). '<br/>';
        foreach ($usuarios as $usuario) {
            $result .= 'Usuario: ' .$usuario->getUsuario() .' - Email: '.$usuario->getEmail(). '<br/>';
        }*/

        $repositoryUsuario = $this->getDoctrine()->getManager()->getRepository('AppBundle:Usuario');
        $usuario = $repositoryUsuario->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        return $usuario;
    }

    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        
        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('Security/login.html.twig', array('last_username' => $lastUsername, 'error' => $error));
    }
    
    public function loginCheckAction()
    {
        
    }
}
