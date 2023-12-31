<?php

namespace Djohnnyboy\Poweredblog\Tests;

//use Djohnnyboy\Poweredblog\BlogBaseServiceProvicer;

class TestCase extends \Orchestra\Testbench\TestCase {

	protected function setUp(): void {
		parent::setUp();
		$this->withFactories(__DIR__.'/../database/factories');
	}
	
	protected function getPackageProviders ($app){

		return [
			\Djohnnyboy\Poweredblog\BlogBaseServiceProvider::class,
		];
	}

	protected function getEnvironmentSetUp ($app){
		
		$app['config']->set('database.default', 'testdb');
		$app['config']->set('database.connections.testdb', [
			'driver' => 'sqlite',
			'database' => ':memory:'
		]);
	}
}

