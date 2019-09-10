<?php

namespace App\Tests\Service;

use App\Service\WorkWithTargetPath;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class WorkWithTargetPath_Test extends TestCase
{
    private $count = 0;

    /**
     * @dataProvider isGoodReferer_Args
     */
    public function testIsGoodReferer(bool $expected, string $url)
    {
        $this->count++;

        $router = $this->prophesize(RouterInterface::class);

        $router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL)->willReturn("http://public.local/login");
        $router->generate('security_register', [], UrlGeneratorInterface::ABSOLUTE_URL)->willReturn("http://public.local/register");

        $workWithTargetPath = new WorkWithTargetPath($router->reveal());

        if($this->count < 3){

        }

        $this->assertEquals(
            $expected,
            $this->invokePrivateMethod($workWithTargetPath, "isGoodReferer", [$url])
        );
    }

    /*public function testSaveReferer()
    {
        $url = "http://public.local/show";

        $router = $this->prophesize(RouterInterface::class);
        $workWithTargetPath = new WorkWithTargetPath($router->reveal());

        $request = $this->prophesize(Request::class);
        $session = $this->prophesize(Session::class);

        $request->getSession()->shouldBeCalledTimes(1)->willReturn($session->reveal());
        $session->set("Referer", $url)->shouldBeCalledTimes(1);

        $workWithTargetPath->saveReferer($url, $request->reveal());
    }*/

    /*public function testGetRedirectUri()
    {
        $request = $this->prophesize(Request::class);
        $session = $this->prophesize(Session::class);

    }*/



    public function isGoodReferer_Args()
    {
        return [
            [ false, "http://public.local/login" ],
            [ false, "http://public.local/register" ],
            [ true, "http://public.local/show" ],
            [ false, "" ]
        ];
    }


    public function invokePrivateMethod(&$object, $methodName, array $parameters = []){

        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);

    }

}