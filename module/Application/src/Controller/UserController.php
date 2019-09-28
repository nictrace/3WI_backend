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

class UserController extends AbstractRestfulController
{
        private $db;
        private $container;
        private $em;
        private $repo;

        public function __construct(ContainerInterface $object){
            $this->container = $object;
            $this->em = $this->container->get('doctrine.entitymanager.orm_default');
            $this->repo = $this->em->getRepository(\Application\Entity\User::class);
            $this->db = new Adapter($this->container->get('Config')['db']);
        }
        public function options(){
            $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=>'PUT, GET, POST, OPTIONS, HEAD, DELETE',
                'Access-Control-Allow-Headers'=>'Origin, X-Requested-With, Content-Type, Accept'));
            $this->response->setStatusCode(204);
            return $this->getResponse();
        }

    public function getList()
    {
	$data = $this->repo->findAll();
	$total = [];
	foreach($data as &$lev){
	    $one = [];
	    if(is_object($lev)){
		$one['id'] = $lev->getId();
		$one['name'] = $lev->getName();
		$one['phone'] = $lev->getPhone();
		//$one['created'] = $lev->getCreated();

		//$m = $lev->getPrivs()->slice(0);	// взять все данные
		//$u = [];
		//foreach($m as $priv){
		//    array_push($u, $priv->getName());
		//}
		//$one['privileges'] = $u;
		array_push($total,$one);
	    }
	}
        $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));
        $this->response->setContent(\json_encode($total));
	return $this->response;
    }
    public function get($id){
	$this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));
	$data = $this->repo->findOneById($id);
	if(!is_null($data)){
	    // checking for extra parameters
	    $stat = intval($this->params()->fromQuery('stat', 0));
	    if($stat > 0){
		// get stat and display it
		$stats = '100500 of plastic bottles';
	    }
            else $stats = '';

	    $userinfo = $data->toArray();
	    $userinfo['stat'] = $stats;
            $this->response->setContent(\json_encode($userinfo));
	}
        else{
	     $this->response->setContent(\json_encode(\json_encode(['success'=>false, 'message'=>'Пользователь с таким id не зарегистрирован'])));
        }
        return $this->response;
    }
}
