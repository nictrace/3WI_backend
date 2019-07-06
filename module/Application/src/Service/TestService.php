<?php

namespace Application\Service;

class TestService
{
    public function getPoints()
    {
	    return json_encode(array('map'=>'Yaroslavl', 'zoom'=> 5));
    }
}
