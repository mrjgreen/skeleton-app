<?php

class HomePageTest extends TestCase
{

	/**
	 * Check the core home page and login routes
	 */
	public function testAvailability()
	{
		// home page
		$response = $this->call('GET', '/health');
		$this->assertEquals(200, $response->getStatusCode());

		// 404 page
		$response = $this->call('GET', 'this is an unknown route');
		$this->assertEquals(404, $response->getStatusCode());
	}
}