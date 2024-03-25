<?php

declare(strict_types=1);

namespace App\Application\Service\Twig;

use EasyCorp\Bundle\EasyAdminBundle\Twig\EasyAdminTwigExtension;
use Twig\Environment as BaseEnvironment;
use Twig\Extension\GlobalsInterface;

class Environment extends BaseEnvironment
{
    private $extensionsToRefreshGlobals = [EasyAdminTwigExtension::class];

    public function mergeGlobals(array $context): array
    {
        foreach ($this->getExtensions() as $class => $extension) {
            if ($extension instanceof GlobalsInterface && in_array($class, $this->extensionsToRefreshGlobals)) {
                $this->refreshGlobals($extension->getGlobals());
            }
        }

        return parent::mergeGlobals($context);
    }

    private function refreshGlobals(array $freshGlobals): void
    {
        $ref = (new \ReflectionObject($this))->getParentClass();

        $globalsProperty = $ref->getProperty('globals');
        $globalsProperty->setAccessible(true);

        $resolvedGlobalsProperty  = $ref->getProperty('resolvedGlobals');
        $resolvedGlobalsProperty->setAccessible(true);

        $extensionSetProperty  = $ref->getProperty('extensionSet');
        $extensionSetProperty->setAccessible(true);
        $extensionSet = $extensionSetProperty->getValue($this);

        $refExtensionSet = (new \ReflectionObject($extensionSet));
        $extensionSetGlobalsProperty = $refExtensionSet->getProperty('globals');
        $extensionSetGlobalsProperty->setAccessible(true);

        $globals = $globalsProperty->getValue($this);
        $resolvedGlobals = $resolvedGlobalsProperty->getValue($this);
        $extensionSetGlobals = $extensionSetGlobalsProperty->getValue($extensionSet);

        $globals = array_merge($globals, $freshGlobals);
        if ($resolvedGlobals !== null) {
            $resolvedGlobals = array_merge($resolvedGlobals, $freshGlobals);
        }
        if ($extensionSetGlobals !== null) {
            $extensionSetGlobals = array_merge($extensionSetGlobals, $freshGlobals);
        }

        $globalsProperty->setValue($this, $globals);
        $resolvedGlobalsProperty->setValue($this, $resolvedGlobals);
        $extensionSetGlobalsProperty->setValue($this, $extensionSetGlobals);
    }
}
