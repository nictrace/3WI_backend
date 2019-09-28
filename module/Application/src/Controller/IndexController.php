<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Interop\Container\ContainerInterface;
use Application\Service\TestService;
use Zend\Diactoros\Response\JsonResponse;
use Zend\View\Model\JsonModel;
use Zend\Http\Headers;
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;

class IndexController extends AbstractActionController
{
    private $container;
    private $mydb;

        private $em;
        private $repo;

        public function __construct(ContainerInterface $object){
            $this->container = $object;
            $this->em = $this->container->get('doctrine.entitymanager.orm_default');
            $this->repo = $this->em->getRepository(\Application\Entity\User::class);
            $this->mydb = new Adapter($this->container->get('Config')['db']);
        }

  //  public function __construct(ContainerInterface $object) {
///	    $this->container = $object;
   //         $this->mydb = new Adapter($this->container->get('Config')['db']);
    //}

    public function indexAction()
    {
	//var_dump($GLOBALS);
        return new ViewModel();
    }

    public function savepointAction(){
        $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));
        $request  = $this->getRequest();

	$rawdata = $request->getContent();
        try {
            $params = Json::decode($rawdata, \Zend\Json\Json::TYPE_ARRAY);
        }
        catch(\Exception $e){
   	   $this->response->setContent(\json_encode(['status'=>'bad params']));
           return $this->response;
        }
        if($params['currentPlacemark']['id'] == null){
            // insert new item
            $sql = "INSERT INTO dumps ('lat','len','violationType','level',) VALUES (?,?,?,?)";
                $statement = $this->mydb->query($sql);
		$cust = [$params['currentPlacemark']['coordinates'][0], $params['currentPlacemark']['coordinates'][1], 
			$params['currentPlacemark']['violationType'], $params['currentPlacemark']['level']];
                try{
                    $results = $statement->execute([$cust]);
		}
		catch(Exception $e){
		    $this->response->setContent(\json_encode(['status'=>'error']));
		}
        }
        $this->response->setContent(\json_encode(['status'=>'ok']));
        return $this->response;
    }

    public function mapAction()
    {
	$am = $this->container->get('Config');
        $db = new Adapter($am['db']);
        $sql = "SELECT dumps.* FROM dumps";
        $statement = $db->query($sql);
        $results = $statement->execute();
        $row = $results->current();
	$row['id'] = intval($row['id']);
        $row['coordinates'] = [floatval($row['lat']), floatval($row['lon'])];
        unset($row['lat']);
        unset($row['lon']);
        $full[] = $row;

        $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));

        while($results->key() < $results->count()){
            $row = $results->next();
	    if($row === false) break;
	    $row['coordinates'] = [floatval($row['lat']),floatval($row['lon'])];
	    $row['id'] = intval($row['id']);
	    unset($row['lat']);
            unset($row['lon']);

            if($row !== false) $full[] = $row;
        }

        $out['payload'] = $full;
        $this->response->setContent(\json_encode($out));
        return $this->response;

	    //$service = new TestService();
	    //$this->container->setService(TestService::class, $service);
	    //print_r($am['db'])echo($service->test());
	    //return new ViewModel(array('city'=>'yaroslavl'));

        $out['payload'] = $full;
        $this->response->setContent(\json_encode($out));
        return $this->response;
    }

    public function uploadAction()
    {
	// only for POST
	if ($this->getRequest()->isPost()) {
	    $files = $this->params()->fromFiles();
	    // получаем array по которому нужно пройтись
	    $x = 1;
	    $id = $this->params()->fromPost('id', 0);
	    foreach($files as $one){
		if($one['error']==0){
		    if($one['type'] == 'image/jpeg'){
			$dz = __DIR__.'/../../../../upload/'.$id;
			if(!is_dir($dz)){
			   mkdir($dz);
			}
			move_uploaded_file($one['tmp_name'], $dz.'/'.$x.'.jpg');
			$x++;
		    }
		}
	    }
	    print_r($this->params()->fromPost('id', 0));
	}
	else {
		echo "GET?";
	}
        $this->response->setContent(\json_encode([]));
        return $this->response;
    }
    public function getfotoAction(){
	$this->response->setContent(\json_encode(['action'=>'getfoto']));
	return $this->response;
    }
    public function savefotoAction(){
        $this->response->setContent(\json_encode(['action'=>'savefoto']));
        return $this->response;
    }
    public function loginAction(){
	if ($this->getRequest()->isPost()) {
	    $phone = $this->params()->fromPost('phone', '0');
	    $pass = $this->params()->fromPost('pass', '');
	    $user = $this->repo->findOneBy(['phone'=>$phone]);
	    print_r($user);
	}
    }
}
