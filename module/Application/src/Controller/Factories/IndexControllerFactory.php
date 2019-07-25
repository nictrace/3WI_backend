<?php
namespace Application\Controller\Factories;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Controller\IndexController;
use Application\Controller\DumpController;
use Application\Controller\PrivilegesController;
use Application\Controller\LevelController;

// Factory class
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //$currencyConverter = $container->get(CurrencyConverter::class);
	//	Application\Controller\IndexController]
	if($requestedName == 'Application\Controller\DumpController') return new DumpController($container);
        elseif($requestedName == 'Application\Controller\IndexController') return new IndexController($container);
	elseif($requestedName == 'Application\Controller\LevelController') return new LevelController($container);
	else return new PrivilegesController($container);
    }
}
