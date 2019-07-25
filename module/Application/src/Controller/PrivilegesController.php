<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repos$
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Interop\Container\ContainerInterface;
use Application\Service\TestService;
use Zend\Diactoros\Response\JsonResponse;
use Zend\View\Model\JsonModel;
use Zend\Http\Headers;
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;

class PrivilegesController extends AbstractRestfulController
{
        private $db;
        private $container;
        private $em;
        private $repo;

        public function __construct(ContainerInterface $object){
            $this->container = $object;
            $this->em = $this->container->get('doctrine.entitymanager.orm_default');
            $this->repo = $this->em->getRepository(\Application\Entity\Privileges::class);
            $this->db = new Adapter($this->container->get('Config')['db']);
        }

    public function getList()
    {
	$data = $this->repo->findAll();
	var_dump($data);
	return $this->response;
    }
}
