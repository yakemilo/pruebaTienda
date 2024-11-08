<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProductoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('nombre')
            ->add('nombreTraduccion')
            ->add('peso')
            ->add('volumen')
            ->add('precio')
            ->add('marca')
            ->add('descripcion')
            ->add('almacen', 'entity', array(
                'class' => 'AppBundle:Almacen',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('a')
                            ->where('a.activo = :only')
                            ->setParameter('only','1');
                },
                'choice_label' => 'getNombre',
                'placeholder' => 'Seleccione un almacen'
            ))
            ->add('temperatura', 'entity', array(
                'class' => 'AppBundle:tcTemperatura',
                'choice_label' => 'getTemperatura',
                'placeholder' => 'Seleccione una temperatura'
            ))
            ->add('save', 'submit', array('label' => 'Guardar Producto'))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'producto';
    }


}
