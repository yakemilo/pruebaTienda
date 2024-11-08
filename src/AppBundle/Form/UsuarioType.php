<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario')
            ->add('password', 'password')
            ->add('email', 'email')
            ->add('role', 'choice', array('choices' =>array('ROLE_ADMIN'=>'Administrador', 'ROLE_USER'=>'Usuario', 'ROLE_CLIENT'=> 'Cliente'), 'placeholder'=> 'Seleccione un rol'))
            ->add('activo', 'checkbox')
            ->add('save', 'submit', array('label' => 'Guardar Usuario'))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'usuario';//'appbundle_usuario';
    }


}
