<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\Diactoros\Response\JsonResponse;
use Zend\View\Model\JsonModel;
use Zend\Http\Headers;
use Zend\Db\Adapter\Adapter;


class IndexController extends AbstractRestfulController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function get($id)
    {
	$adapter = new Adapter($this->getEvent()->getApplication()->getConfig()['db']);
        $stmt = $adapter->query('SELECT customers.*,grades.grade FROM customers LEFT JOIN grades ON grades.user_id = customers.id WHERE customers.id=?');
	$results = $stmt->execute([$id]);
	$row = $results->current();
	$this->response->setContent(\json_encode($row));
        //return new JsonModel($row);
	return $this->response;
    }

    public function getList(){
	$cnf = $this->getEvent()->getApplication()->getConfig();
	$adapter = new Adapter($cnf['db']);

	$sql = "SELECT customers.*,grades.grade, ".
		"(SELECT GROUP_CONCAT(cities.id) FROM cities LEFT JOIN customer_city ON customer_city.city_id = cities.id WHERE customer_city.customer_id = customers.id) AS city_id,".
		"(SELECT GROUP_CONCAT(cities.city) FROM cities LEFT JOIN customer_city ON customer_city.city_id = cities.id WHERE customer_city.customer_id = customers.id) AS city ".
		"FROM customers LEFT JOIN grades ON grades.user_id = customers.id";
	//$stmt = $adapter->query("SELECT customers.*,grades.grade,(SELECT REPLACE(GROUP_CONCAT(JSON_ARRAY(city)),'],[',',') AS 'json1' FROM cities WHERE id IN (SELECT `city_id` FROM `customer_city` WHERE `customer_id`= customers.id) ) AS 'city' FROM customers LEFT JOIN grades ON grades.user_id = customers.id ");
	$stmt = $adapter->query($sql);
	$results = $stmt->execute([]);

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

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
	// $data - ассоциативный массив с данными клиента
	$cnf = $this->getEvent()->getApplication()->getConfig();
        $adapter = new Adapter($cnf['db']);

	if($data['city_id']){	// создать запрос и дернуть его для каждого элемента (а если он там был?)
	    $stmt = $adapter->query("DELETE FROM customer_city WHERE customer_id = ?");
	    $stmt->execute([$id]);
	    $stmt = $adapter->query("INSERT INTO customer_city (customer_id, city_id) VALUES (?,?)");
	    for($i=0; $i < count($data['city_id']); $i++){
		$stmt->execute([intval($id),$data['city_id'][$i]]);
	    }
	    $stmt = $adapter->query("SELECT GROUP_CONCAT(cities.city) AS 'city'  FROM cities LEFT JOIN customer_city ON customer_city.city_id = cities.id WHERE customer_city.customer_id = ?");
	    $rez = $stmt->execute([intval($id)]);
	    $row = $rez->current();
	    $data['city'] = $row['city'];
	}
	if($data['grade']){
            $statement = $adapter->query("INSERT INTO grades SET user_id = ?, grade = ? ON DUPLICATE KEY UPDATE grade = ?");
	    try{
                $results = $statement->execute([$id, $data['grade'], $data['grade']]);
            }
            catch(\Exception $e){
	        $this->response->setStatusCode(409);
	    }
	}
	if($data['name']){
	    $statement = $adapter->query("UPDATE customers SET name = ? WHERE id = ?");
            try{
                $results = $statement->execute([$data['name'], $id]);
            }
            catch(\Exception $e){
                $this->response->setStatusCode(409);
            }
	}
	$this->response->setContent(\json_encode($data));
	return $this->response;
    }
}

