<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class ThemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'help' => 'Shown to customers under the style preview in the mobile app.',
            ])
            ->add('sampleImageFiles', FileType::class, [
                'label' => 'Style sample photos',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'help' => 'Up to 8 photos (JPG, PNG, WebP, GIF — max 5 MB each). Customers see these after picking this theme when booking.',
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/webp,image/gif',
                    'multiple' => 'multiple',
                ],
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File(
                                maxSize: '5M',
                                mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
                                mimeTypesMessage: 'Please upload JPG, PNG, WebP, or GIF images only.',
                            ),
                        ],
                    ]),
                ],
            ])
        ;

        if ($options['is_edit']) {
            $builder->add('removeSampleImages', CheckboxType::class, [
                'label' => 'Remove all current sample photos',
                'mapped' => false,
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Theme::class,
            'is_edit' => false,
        ]);
        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
