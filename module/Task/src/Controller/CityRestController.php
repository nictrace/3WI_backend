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

	    $this->db = new Adapter($this->getEvent()->getApplication()->getConfig()['db']);

	    $cust = intval($this->params()->fromQuery('cust', 0));
	    $start = intval($this->params()->fromQuery('start', 0));
	    $limit = intval($this->params()->fromQuery('limit', 0));

	    $sql = "SELECT cities.* FROM cities";
	    if($cust){
		$sql .= " WHERE id IN (SELECT `city_id` FROM `customer_city` WHERE `customer_id`=?)";
//		if($limit) $sql .= " LIMIT $start, $limit";	// что-то с чем-то не дружит при пажинации...
		$statement = $this->db->query($sql);
		$results = $statement->execute([$cust]);
	    } else {
//		if($limit) $sql .= " LIMIT $start, $limit";
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
	    $this->response->setContent(\json_encode($full));
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
	$cnf = $this->getEvent()->getApplication()->getConfig();
        $adapter = new Adapter($cnf['db']);
        $statement = $adapter->query("INSERT INTO cities SET city = ?");
        try{
            $results = $statement->execute([$data['city']]);
	    $this->response->setStatusCode(201);
        }
        catch(\Exception $e){
            $this->response->setStatusCode(409);
        }

        $this->response->setContent(\json_encode($id));
	// use getLastGeneratedValue();
        return $this->response;
    }
}

