<?php

declare(strict_types=1);

namespace Upskaling\SlugifyBundle\DependencyInjection;

use Upskaling\SlugifyBundle\Form\Type\SlugType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class UpskalingSlugifyExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['FrameworkBundle'])) {
            return;
        }

        $container->prependExtensionConfig('twig', [
            'form_themes' => [
                '@UpskalingSlugify/slug_types.html.twig',
            ],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->setDefinition(SlugType::class, new Definition(SlugType::class))
            ->addTag('form.type')
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(false)
        ;
    }
}
