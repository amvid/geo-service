<?php

declare(strict_types=1);

namespace App\Application\DependencyInjection;

use App\Application\Form\Type\CrudAutocompleteType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class OverrideAutocompleteTypePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $serviceId = \EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType::class;

        if (!$container->hasDefinition($serviceId)) {
            return;
        }

        $definition = $container->getDefinition($serviceId);
        $definition->setClass(CrudAutocompleteType::class);
        $definition->setArguments([new Reference('twig')]);
    }
}
