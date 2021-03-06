<?php 
class CurlTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetRequest()
    {
        $request = new \genxoft\curl\Request("http://localhost/libs/curl/tests/_support/test_get.php", [
            "test_param" => "test_value"
        ]);
        $this->assertInstanceOf(\genxoft\curl\Request::class, $request);

        $curl = new \genxoft\curl\Curl($request);
        $this->assertInstanceOf(\genxoft\curl\Curl::class, $curl);

        $response = $curl->get();
        if ($response === null) {
            $this->expectExceptionMessage($curl->getLastErrno());
        } else {
            $this->assertInstanceOf(\genxoft\curl\Response::class, $response);
        }

        $this->assertEquals($response->getBody(), "test_value");
    }

    public function testPostRequest()
    {
        $request = new \genxoft\curl\Request("http://localhost/libs/curl/tests/_support/test_post.php", [
            "test_param" => "test_value"
        ], 'post');
        $this->assertInstanceOf(\genxoft\curl\Request::class, $request);

        $curl = new \genxoft\curl\Curl($request);
        $this->assertInstanceOf(\genxoft\curl\Curl::class, $curl);

        $response = $curl->post();
        if ($response === null) {
            $this->expectExceptionMessage($curl->getLastErrno());
        } else {
            $this->assertInstanceOf(\genxoft\curl\Response::class, $response);
        }

        $this->assertEquals($response->getBody(), "test_value");
    }

    public function testJsonRequest()
    {
        $request = new \genxoft\curl\Request("http://localhost/libs/curl/tests/_support/test_json.php", [
            "test_param" => "test_value"
        ], 'json');
        $this->assertInstanceOf(\genxoft\curl\Request::class, $request);

        $curl = new \genxoft\curl\Curl($request);
        $this->assertInstanceOf(\genxoft\curl\Curl::class, $curl);

        $response = $curl->post();
        if ($response === null) {
            $this->expectExceptionMessage($curl->getLastErrno());
        } else {
            $this->assertInstanceOf(\genxoft\curl\Response::class, $response);
        }

        $this->assertEquals($response->getBody(), "test_value");
    }

    public function testQuickGetRequest()
    {
        $result = \genxoft\curl\Curl::quickGet("http://localhost/libs/curl/tests/_support/test_get.php", [
            "test_param" => "test_value"
        ]);
        $this->assertEquals($result, "test_value");
    }

    public function testQuickPostRequest()
    {
        $result = \genxoft\curl\Curl::quickPost("http://localhost/libs/curl/tests/_support/test_post.php", [
            "test_param" => "test_value"
        ]);
        $this->assertEquals($result, "test_value");
    }

    public function testQuickJsonRequest()
    {
        $result = \genxoft\curl\Curl::quickJson("http://localhost/libs/curl/tests/_support/test_json.php", [
            "test_param" => "test_value"
        ]);
        $this->assertEquals($result, "test_value");
    }

    public function testFileRequest()
    {
        $testFilePath = __DIR__.'/../_support/test.txt';

        $file = \genxoft\curl\File::loadFile($testFilePath, 'test.txt', 'text/plain');

        $this->assertInstanceOf(\genxoft\curl\File::class, $file);

        $request = new \genxoft\curl\Request("http://localhost/libs/curl/tests/_support/test_file.php", [
            "test_field" => "test",
            "test_file" => $file,
        ], 'post');
        $this->assertInstanceOf(\genxoft\curl\Request::class, $request);

        $curl = new \genxoft\curl\Curl($request);
        $this->assertInstanceOf(\genxoft\curl\Curl::class, $curl);

        $response = $curl->post();
        if ($response === null) {
            $this->expectExceptionMessage($curl->getLastErrno());
        } else {
            $this->assertInstanceOf(\genxoft\curl\Response::class, $response);
        }

        $this->assertEquals($response->getBody(), filesize($testFilePath));
    }

}