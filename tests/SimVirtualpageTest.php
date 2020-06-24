<?php

declare(strict_types=1);

namespace SimVirtualpage\tests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use SimVirtualpage\SimVirtualpage;

/**
 * Class SimVirtualpageTest
 * @package SimVirtualpage
 */

class SimVirtualpageTest extends Testcase
{
    /**
     * Setup
     * This method is called before a test is executed.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * teardown
     * This method is called after a test is executed.
     * @return void
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }
  
    /**
     * @test
     * Simply tests, if the testing setup is configured correctly
    */
    public function testHelloWorld()
    {
        $this->assertEquals('HelloWorld', 'Hello' . 'World');
    }
  

    /**
     * @test
     * another test just checks that i have phpunit setup correctly
     *
     * it is NOT actually a  test of the plugin class which cannot be found
     * just  a curl  api call
     *
     */
    public function testSomething()
    {
        $apiUrl = "https://jsonplaceholder.typicode.com/users"; // call api
        $client = curl_init($apiUrl);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($client);
        $result = json_decode($response, true);

        $httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
        $this->assertEquals(200, $httpCode);
        $this->assertTrue(count($result) > 0);
    }

    /** @test
     * find the class
     * and checkout the instance ,its properties and methods
     */
    public function findThePluginClass()
    {
        $instance = new SimVirtualpage();

        $this->assertIsObject($instance);
        $this->assertEquals($instance->apiUrl, "https://jsonplaceholder.typicode.com/users");
    }

    /**@test
     * failed to use Brain Monkey/Mockery to test  added hooks
     */

//    public function testClassActuallyAddsHooks()
//    {
//        $instance = new SimVirtualpage();
//        //$instance->__construct();
//
//        //self::assertTrue(has_action('init', [ SimVirtualpage::class, 'init' ]));
//        //self::assertTrue(has_action('init', [ SimVirtualpage::class, 'ivpActivate' ]));
//        //self::assertTrue(has_action('template_include', [ SimVirtualpage::class, 'changeTemplate' ]));
//        //self::assertTrue(has_action('wp_enqueue_scripts', [ SimVirtualpage::class, 'addIvpScripts' ]));
//
//        //self::assertTrue(has_filter('queryVars', 'ivpQueryVars'));
//        //self::assertTrue(has_filter('queryVars', 'queryVars'));
//
//        //Actions\expectAdded('init');
//        //Filters\expectAdded('queryVars');
//
//       // $this->assertTrue(Filters\applied('ivpQueryVars') > 0);
//    }
}
