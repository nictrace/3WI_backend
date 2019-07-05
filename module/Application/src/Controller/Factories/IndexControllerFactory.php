<?php
namespace Application\Controller\Factories;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;

// Factory class
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Get the instance of CurrencyConverter service from the service manager.
        //$currencyConverter = $container->get(CurrencyConverter::class);

        // Create an instance of the controller and pass the dependency
        // to controller's constructor.
        return new IndexController($container);
    }
}
