<?php

class HomePageTest extends TestCase
{

    /**
     * Check the core home page and login routes
     */
	public function testAvailability()
	{
        // home page
		$response = $this->call('GET', '/');
		$this->assertEquals(200, $response->getStatusCode());

        // 404 page
		$response = $this->call('GET', 'this is an unknown route');
		$this->assertEquals(404, $response->getStatusCode());
	}

    /**
     * Check the core home page and login routes
     */
    public function testNewUser()
    {
        // home page
        $response = $this->call('POST', 'register-new-user');
        $this->assertEquals(200, $response->getStatusCode());
        var_dump($response->getContent());

        // 404 page
        $response = $this->call('GET', 'list-users');
        $this->assertEquals(200, $response->getStatusCode());
        var_dump($response->getContent());
    }
}
