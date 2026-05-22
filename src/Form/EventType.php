<?php

namespace App\Form;

use App\Entity\Event;
use App\Repository\ThemeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EventType extends AbstractType
{
    public function __construct(private readonly ThemeRepository $themeRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $updateThemeChoices = function ($form, ?string $eventTypeValue): void {
            $choices = [];
            if ($eventTypeValue) {
                $themes = $this->themeRepository->findBy(['eventType' => $eventTypeValue], ['name' => 'ASC']);
                foreach ($themes as $theme) {
                    $choices[$theme->getName()] = $theme->getName();
                }
            }

            $form->add('theme', ChoiceType::class, [
                'required' => false,
                'placeholder' => $eventTypeValue ? 'Select a theme' : 'Select event type first',
                'choices' => $choices,
                'empty_data' => '',
            ]);
        };

        $builder
            ->add('customerName', null, [
                'required' => true,
                'empty_data' => '',
            ])
            ->add('eventType', ChoiceType::class, [
                'required' => true,
                'placeholder' => 'Select event type',
                'choices' => [
                    'Wedding' => 'Wedding',
                    'Birthday' => 'Birthday',
                ],
            ])
            ->add('eventDate', null, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => true,
                'attr' => [
                    'required' => 'required',
                ],
            ])
            ->add('venue', null, [
                'required' => false,
                'empty_data' => '',
            ])
            ->add('guestCount', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'inputmode' => 'numeric',
                    'data-numeric-only' => 'integer',
                    'placeholder' => 'Number of guests',
                ],
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'scale' => 2,
                'html5' => true,
                'empty_data' => '0',
                'attr' => [
                    'min' => 0,
                    'step' => '0.01',
                    'inputmode' => 'decimal',
                    'data-numeric-only' => 'decimal',
                    'placeholder' => '0.00',
                ],
            ])
        ;

        // Initialize theme choices based on initial eventType (for edit form)
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($updateThemeChoices) {
            $data = $event->getData();
            $eventTypeValue = $data?->getEventType();
            $updateThemeChoices($event->getForm(), $eventTypeValue);
        });

        // Update theme choices on submit when eventType changes
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($updateThemeChoices) {
            $data = $event->getData();
            $eventTypeValue = $data['eventType'] ?? null;
            $updateThemeChoices($event->getForm(), $eventTypeValue);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}


