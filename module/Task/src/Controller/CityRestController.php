<?php

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\Diactoros\Response\JsonResponse;
use Zend\View\Model\JsonModel;
use Zend\Http\Headers;
use Zend\Db\Adapter\Adapter;

/**
 *	Контроллер возвращает полный список городов либо города, связанные с клиентом по ?cust=N
 */
class CityRestController extends AbstractRestfulController
{
	private $db;
	public function __construct(){
//		$this->db = new Adapter($this->getEvent()->getApplication()->getConfig()['db']);
	}

	public function getList(){

	    $out = array();
	    $this->db = new Adapter($this->getEvent()->getApplication()->getConfig()['db']);

	    $cust = intval($this->params()->fromQuery('cust', 0));
	    $start = intval($this->params()->fromQuery('start', 0));
	    $limit = intval($this->params()->fromQuery('limit', 0));

	    $out['success'] = true;
	    if($limit){
		$sql = "SELECT COUNT(id) AS 'total' FROM cities";
		$stmt = $this->db->query($sql);
		$rz = $stmt->execute();
		$row = $rz->current();
		$out['total'] = $row['total'];
	    }

	    $sql = "SELECT cities.* FROM cities";
	    if($cust){
		$sql .= " WHERE id IN (SELECT `city_id` FROM `customer_city` WHERE `customer_id`=?)";
		if($limit) $sql .= " LIMIT $start, $limit";	// что-то с чем-то не дружит при пажинации...
		$statement = $this->db->query($sql);
		$results = $statement->execute([$cust]);
	    } else {
		if($limit) $sql .= " LIMIT $start, $limit";
		$statement = $this->db->query($sql);
		$results = $statement->execute([]);
	    }

            $row = $results->current();
            $full[] = $row;
            $name = $row['name'];
            while($results->key() != $results->count()){
		$row = $results->next();
		if($row !== false) $full[] = $row;
	    }
//Access-Control-Allow-Origin: *
 	    $this->response->getHeaders()->addHeaders(array(
                'Access-Control-Allow-Origin:' => '*'
	    ));
 	    $out['payload'] = $full;
	    $this->response->setContent(\json_encode($out));
	    return $this->response;
	}

	public function get($id)
	{
            $adapter = new Adapter($this->getEvent()->getApplication()->getConfig()['db']);
            $stmt = $adapter->query('SELECT * FROM cities WHERE id=?');
            $results = $stmt->execute([$id]);
            $row = $results->current();
            $this->response->setContent(\json_encode($row));
            return $this->response;
	}

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $cnf = $this->getEvent()->getApplication()->getConfig();
        $adapter = new Adapter($cnf['db']);
        $statement = $adapter->query("UPDATE cities SET city = ? WHERE id = ?");
        try{
            $results = $statement->execute([$data['city'], $id]);
        }
        catch(\Exception $e){
            $this->response->setStatusCode(409);
        }

        $this->response->setContent(\json_encode($id));
        return $this->response;
    }

    public function create($data){
	$out = array('success'=>true);
	$cnf = $this->getEvent()->getApplication()->getConfig();
        $adapter = new Adapter($cnf['db']);
        $statement = $adapter->query("INSERT INTO cities SET city = ?");

        try{
            $results = $statement->execute([$data['city']]);
	    //$this->response->setStatusCode(201);
	    //$out['id']= $adapter->getDriver()->getLastGeneratedValue();
	    $out['data'] = ['id'=>$adapter->getDriver()->getLastGeneratedValue(),'city'=>$data['city']];
        }
        catch(\Exception $e){
            $this->response->setStatusCode(200);	// не обслуживает баги
	    $out['success']=false;
	    $out['message']= $e->getMessage();
        }

        $this->response->setContent(\json_encode($out));
	// use getLastGeneratedValue();
        return $this->response;
    }
}

