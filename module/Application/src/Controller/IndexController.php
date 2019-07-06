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

class IndexController extends AbstractActionController
{
    private $container;

    public function __construct(ContainerInterface $object) {
	    $this->container = $object;
    }

    public function indexAction()
    {
	//var_dump($GLOBALS);
        return new ViewModel();
    }

    public function mapAction()
    {
	    $am = $this->container->get('Config');
        $db = new Adapter($am['db']);
        $sql = "SELECT dumps.* FROM dumps";
        $statement = $db->query($sql);
        $results = $statement->execute();
        $row = $results->current();
        $full[] = $row;
        $this->response->getHeaders()->addHeaders(array(
            'Access-Control-Allow-Origin:' => '*'
        ));

        $out['payload'] = $full;
        $this->response->setContent(\json_encode($out));
        return $this->response;

	    //$service = new TestService();
	    //$this->container->setService(TestService::class, $service);
	    //print_r($am['db'])echo($service->test());
//	    return new ViewModel(array('city'=>'yaroslavl'));

        $out['payload'] = $full;
        $this->response->setContent(\json_encode($out));
        return $this->response;
    }
}
