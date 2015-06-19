<?php

class ExampleTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $response = $this->route('POST', 'backend.login');

        $this->assertEquals( 302, $response->getStatusCode() );
    }

}
