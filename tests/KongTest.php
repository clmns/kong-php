<?php

namespace Tests;

use Ignittion\Kong\Exceptions\InvalidUrlException;
use Ignittion\Kong\Kong;

class KongTest extends AbstractTestCase
{

    public function testConsumer()
    {
    	$kong = new Kong('http://localhost');

    	$consumer = $kong->consumer()->upsert(array('username' => uniqid()));

    	$key = $kong->keyAuthPlugin()->create($consumer->data->id);

    	$apiId = $kong->api()->get()->data->data[0]->id;

    	var_dump($kong->rateLimitPlugin()->get($consumer->data->id));

    	$kong->rateLimitPlugin()->create($apiId, array('name' => 'rate-limiting',
            'config.month' => 100,
            'consumer_id' => $consumer->data->id,
            'config.policy' => 'redis',
            'config.redis_host' => 'localhost',
            'config.redis_port' => '6379'
            ));
    	
    	var_dump($kong->rateLimitPlugin()->get($consumer->data->id));
    } 
}
