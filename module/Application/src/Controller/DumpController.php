<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\Diactoros\Response\JsonResponse;
use Zend\View\Model\JsonModel;
use Zend\Http\Headers;
use Zend\Db\Adapter\Adapter;
use Zend\Json\Json;
use Interop\Container\ContainerInterface;

/**
 *      Контроллер возвращает полный список городов либо города, связанные с клиентом по ?cust=N
 */
class DumpController extends AbstractRestfulController
{
        private $db;
	private $container;

        public function __construct(ContainerInterface $object){
            $this->container = $object;
            $this->db = new Adapter($this->container->get('Config')['db']);
        }

	public function options(){
	    $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*',
		'Access-Control-Allow-Methods'=>'OPTIONS, GET, HEAD, POST, DELETE, PUT',
		'Access-Control-Allow-Headers'=>'X-PINGOTHER, Content-Type'));
	    $this->response->setStatusCode(204);
	    return $this->getResponse();
	}

	public function getList(){

            $out = array();
            $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*'));
            $out['payload'] = array();
            $this->response->setContent(\json_encode($out));
            return $this->response;
	}

	public function get($id)
        {
	    $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-type'=>'application/json'));
	    $row = array($id);
            $this->response->setContent(\json_encode($row));
            return $this->response;
        }

	/* Создание новой точки */
	public function create($data){
            $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*'));
	    $rawdata = $this->getRequest()->getContent();
	    try {
	        $params = Json::decode($rawdata, \Zend\Json\Json::TYPE_ARRAY);
	    }
	    catch(\Exception $e){
		$this->response->setContent(\json_encode(array('status'=>'error','value'=>$e->getMessage())));
		return $this->response;
	    }

	    $sql = "INSERT INTO dumps (";
	    $values = " (";
	    $dd = [];
	    foreach($params['currentPlacemark'] as $key => $par){
		if($key == 'coordinates'){
		    $sql .= 'lat,lon,';
		    $values .= "?,?,";
		    $dd[] = $par[0]; $dd[] = $par[1];
		    continue;
		}
		if($key == 'isDisplayed') continue;
		if(!empty($par)){
		    $sql .= $key.',';
		    $values .= '?,';
	            $dd[] = $par;
		}
            }
	    $sql = substr($sql, 0, -1).') VALUES '.substr($values,0,-1).')';
	    $statement = $this->db->query($sql);
	    try {
		$results = $statement->execute($dd);		// запись в базу может приводить к ошибке
                $id = $this->db->getDriver()->getLastGeneratedValue();
	    }
	    catch(\Exception $e){
		$this->response->setContent(\json_encode(array('status'=>'error','value'=>$e->getMessage())));
                return $this->response;
	    }
            $this->response->setContent(json_encode(array('status'=>'ok','new_id'=>$id)));
            return $this->response;
	}
}
