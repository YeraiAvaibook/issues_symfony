<?php

namespace App\Form;

use App\Entity\Incidencia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título'
            ])
            ->add('descripcion', TextType::class, [
                'label' => 'Descripción',
                'required' => false
            ])
            ->add('fechaCreacion', DateTimeType::class, [
                'label' => 'Fecha de creación',
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('resuelta', ChoiceType::class, [
                'choices' => [
                    'No' => '0', 'Si' => '1'
                ],
                'expanded' => false
            ])
            ->add('fechaResolucion', DateTimeType::class, [
                'label' => 'Fecha de resolución',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('categoria')
            ->add('tag')
            ->add('imagenes', FileType::class, [
                'required' => false,
                'data_class' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Incidencia::class,
        ]);
    }
}