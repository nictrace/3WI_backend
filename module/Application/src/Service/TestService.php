<?php

namespace Application\Service;

class TestService
{
    public function test()
    {
	return json_encode(array('map'=>'Yaroslavl', 'zoom'=> 5));
    }
}
