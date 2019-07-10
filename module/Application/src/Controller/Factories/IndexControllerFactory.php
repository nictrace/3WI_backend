<?php
namespace Application\Controller\Factories;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;
use Application\Controller\DumpController;

// Factory class
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$currencyConverter = $container->get(CurrencyConverter::class);
	//	Application\Controller\IndexController]
	if($requestedName == 'Application\Controller\DumpController') return new DumpController($container);
        else  return new IndexController($container);
    }
}
