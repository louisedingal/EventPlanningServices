<?php

namespace App\Form;

use App\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
                'required' => false,
            ])
            ->add('capacity', IntegerType::class, [
                'label' => 'Capacity',
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'inputmode' => 'numeric',
                    'data-numeric-only' => 'integer',
                    'placeholder' => 'e.g. 200',
                ],
            ])
            ->add('contactInfo', TextType::class, [
                'label' => 'Contact Info',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Venue::class,
        ]);
    }
}


