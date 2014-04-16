<?php

namespace ZfcTwig\Service\Loader;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Loader\TemplatePathStack;

class TemplatePathStackFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];

        /** @var $templateStack \Zend\View\Resolver\TemplatePathStack */
        $zfTemplateStack = $serviceLocator->get('ViewTemplatePathStack');

        $templateStack = new TemplatePathStack($zfTemplateStack->getPaths()->toArray());
        $templateStack->setDefaultSuffix($config['suffix']);

        return $templateStack;
    }
}
