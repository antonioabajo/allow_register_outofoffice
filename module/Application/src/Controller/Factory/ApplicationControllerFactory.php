<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class ApplicationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {  
        // Instantiate the controller and inject dependencies
        return new \Application\Controller\IndexController($container);
    }
}




