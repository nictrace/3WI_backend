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
use Application\Entity\Dumps;

/**
 *      Контроллер возвращает полный список городов либо города, связанные с клиентом по ?cust=N
 */
class DumpController extends AbstractRestfulController
{
        private $db;
	private $container;
	private $em;
	private $repo;

        public function __construct(ContainerInterface $object){
            $this->container = $object;
	    $this->em = $this->container->get('doctrine.entitymanager.orm_default');
	    $this->repo = $this->em->getRepository(Dumps::class);
            $this->db = new Adapter($this->container->get('Config')['db']);
        }

	public function options(){
	    $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*',
		'Access-Control-Allow-Methods'=>'PUT, GET, POST, OPTIONS, HEAD, DELETE',
		'Access-Control-Allow-Headers'=>'Origin, X-Requested-With, Content-Type, Accept'));
	    $this->response->setStatusCode(204);
	    return $this->getResponse();
	}

	/**
	 * Чтение всех данных работает
	 */
	public function getList(){

	    $minx = floatval($this->params()->fromQuery('minx', -90.0));
	    $maxx = floatval($this->params()->fromQuery('maxx', 90.0));
	    $miny = floatval($this->params()->fromQuery('miny', -180.0));
	    $maxy = floatval($this->params()->fromQuery('maxy', 180.0));

	    if($minx == -90.0 && $miny == 90.0 && $maxx == -180.0 && $maxy == 180.0)
		$data = $this->repo->findAll();
	    else {
		$data = $this->repo->findBetween($minx,$maxx,$miny,$maxy);
	    }
	    foreach($data as $dump)
	        $out[] = $dump->toArray();

	    $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));
            $this->response->setContent(\json_encode($out));
            return $this->response;
	}

	/**
	 * Выборка по id работает
	 */
	public function get($id)
        {
	    $this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-type'=>'application/json'));
	    $entityManager = $this->container->get('doctrine.entitymanager.orm_default');
            $dumpsRepo = $entityManager->getRepository(Dumps::class);
	    $data = $dumpsRepo->findOneBy(array('id'=>$id));
 	    $row = $data->toArray();
            $this->response->setContent(\json_encode($row));
            return $this->response;
        }

	/* Создание новой точки - пока что не через Doctrine */
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

    /**
     * Удаление работает
     */
    public function delete($id)
    {
	$el = $this->repo->findOneBy(array('id'=>$id));

	if(is_null($el)){
	    $this->response->setContent(json_encode(array('status'=>'ok','info'=>'item not found')));
	}
	else{
	    $this->em->remove($el);
	    $this->em->flush();
	    $this->response->setContent(json_encode(array('status'=>'ok','info'=>'removed')));
	}
	return $this->response;
    }

    /**
     * Правка имеющегося элемента (PUT)
     */
    public function update($id){
	$el = $this->repo->findOneBy(array('id'=>$id));
	if(is_null($el)){
	    $this->response->setStatusCode(404);
	    $this->response->setContent(\json_encode(array('status'=>'error','value'=>'record not found')));
	    return $this->response;
	}

	$rawdata = $this->getRequest()->getContent();
        try {
            $params = Json::decode($rawdata, \Zend\Json\Json::TYPE_ARRAY);
        }
        catch(\Exception $e){
            $this->response->setContent(\json_encode(array('status'=>'errorZ','value'=>$e->getMessage())));
            return $this->response;
        }
	$out = [];
	foreach($params['currentPlacemark'] as $key => $val){
	    $out[] = $key;
	    $out[] = $val;
	    if($key == 'address') $el->setAddress($val);
	    elseif($key == 'violationType') $el->setViolationType($val);
	    elseif($key == 'plastic') $el->setPlastic($val);
	    elseif($key == 'metal') $el->setMetal($val);
	    elseif($key == 'glass') $el->setGlass($val);
	    elseif($key == 'coordinates') $el->setCoordinates($val);
	}
	$this->em->flush();
	$this->response->setContent(\json_encode(array('status'=>'ok', 'out'=>$out)));
	//$this->response->getHeaders()->addHeaders(array('Access-Control-Allow-Origin' => '*', 'Content-Type'=>'application/json'));
	return $this->response;
    }
}
