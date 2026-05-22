<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\Theme;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ServiceBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('preferredDate', DateType::class, [
                'label' => 'Preferred date',
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [new NotBlank(message: 'Please choose a date for your booking.')],
                'attr' => ['min' => (new \DateTime('today'))->format('Y-m-d')],
            ])
            ->add('preferredTime', TimeType::class, [
                'label' => 'Preferred time',
                'widget' => 'single_text',
                'required' => true,
                'input' => 'string',
                'constraints' => [new NotBlank(message: 'Please choose a time for your booking.')],
            ])
            ->add('estimatedGuestCount', IntegerType::class, [
                'label' => 'Number of guests',
                'required' => false,
                'attr' => ['min' => 1, 'placeholder' => 'e.g. 50'],
                'constraints' => [new GreaterThanOrEqual(1)],
            ])
            ->add('preferredVenue', TextType::class, [
                'label' => 'Venue or location',
                'required' => false,
                'attr' => ['placeholder' => 'Where should this take place?'],
            ])
            ->add('theme', ChoiceType::class, [
                'label' => 'Theme or mood',
                'required' => false,
                'placeholder' => 'Choose a theme created by our team',
                'choices' => $this->buildThemeChoices($options['themes']),
            ])
            ->add('contactPhone', TextType::class, [
                'label' => 'Contact phone',
                'required' => true,
                'constraints' => [new NotBlank(message: 'Please provide a phone number so we can reach you.')],
                'attr' => ['placeholder' => 'e.g. 09XX XXX XXXX', 'inputmode' => 'tel'],
            ])
            ->add('specialRequests', TextareaType::class, [
                'label' => 'Additional details',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Dietary needs, setup preferences, add-ons, or anything else we should know…',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'themes' => [],
        ]);
        $resolver->setAllowedTypes('themes', 'array');
    }

    /**
     * @param list<Theme> $themes
     *
     * @return array<string, string>
     */
    private function buildThemeChoices(array $themes): array
    {
        $choices = [];
        foreach ($themes as $theme) {
            $name = $theme->getName();
            if ($name !== null && $name !== '') {
                $label = $theme->getEventType()
                    ? sprintf('%s (%s)', $name, $theme->getEventType())
                    : $name;
                $choices[$label] = $name;
            }
        }

        return $choices;
    }
}
