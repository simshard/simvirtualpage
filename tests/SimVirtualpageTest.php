<?php

declare(strict_types=1);

namespace SimVirtualpage\tests;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;
use Brain\Monkey\Actions;
use SimVirtualpage\SimVirtualpage;

/**
 * Class SimVirtualpageTest
 * @package SimVirtualpage
 */

class SimVirtualpageTest extends Testcase
{
    use MockeryPHPUnitIntegration;

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
    public function testPhpunitIsSetup()
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
    public function testThePluginClassIsObject()
    {
        $instance = new SimVirtualpage();
        $this->assertIsObject($instance);
    }

    /**
     * @test
     * use Brain Monkey to test  added hooks
     * fails asserting false is true
     */

//    public function testClassActuallyAddsHooks1()
//    {
//        $instance = new \SimVirtualpage\SimVirtualpage();
//        $instance->__construct();
//        self::assertTrue(has_action('init', '\SimVirtualpage\SimVirtualpage->__construct()'));
//    }

    /**
     * @test
     * use Brain Monkey  to test  added hooks
     * fails asserting false is true
     */
    //   public function testClassActuallyAddsHooks2()
    //   {
    //     (new SimVirtualpage() )->__construct();
    //     self::assertTrue(has_action('init', [ '\SimVirtualpage\SimVirtualpage', 'ivpActivate' ]));
    //   }

    /**
     * @test
     *  test added hooks
     *  using Brain Monkey /Mockery
     * success when I added use MockeryPHPUnitIntegration in the class as well as before the class
     */
    public function testClassActuallyAddsHooks3()
    {
        Actions\expectAdded('init');
        Actions\expectAdded('wp_enqueue_scripts');
        Actions\expectAdded('template_include');

        (new SimVirtualpage() )->__construct();
    }
}
