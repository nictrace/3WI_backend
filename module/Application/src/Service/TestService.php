<?php

namespace Application\Service;

class TestService
{
    public function getPoints()
    {
	    return json_encode(array('map'=>'Yaroslavl', 'zoom'=> 5));
    }
    // all trash types
    public function getTypes(){
	return ["plastic", "metal", "glass", "paper", "cloth", "tetrapack", "house_tech", "lamps", "batteries"];
    }
}
