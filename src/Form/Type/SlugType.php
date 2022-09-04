<?php

declare(strict_types=1);

namespace Upskaling\SlugifyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;

class SlugType extends AbstractType
{
    public function __construct(
        private SluggerInterface $slugger
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(
                FormEvents::SUBMIT,
                function (FormEvent $event) {
                    /** @var string|null */
                    $data = $event->getData();
                    if ($data) {
                        $event->setData($this->slugger->slug($data)->lower());
                    }
                }
            );
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr']['data-slug-type-target-field-target'] = $options['set_target_field_name'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'set_target_field_name' => null,
            'attr' => [
                'class' => 'slug_type',
                'data-upskaling--slugify-target' => 'slug_input',
            ],
        ]);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
