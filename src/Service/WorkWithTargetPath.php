<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class WorkWithTargetPath
{
    use TargetPathTrait;

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    private $ourTargetPath_key = "OurTargetPath";


    public function saveReferer(string $referer, Request $request) : void
    {
        //$referer = ($_SERVER['HTTP_REFERER']) ?? '';
        //if($referer != '' && $referer != $this->router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL))
        if($this->isGoodReferer($referer))
        {
            $request->getSession()->set(
                $this->ourTargetPath_key, $referer
            );

        }
    }

    private function isGoodReferer(string $referer) : bool
    {

        if($referer == ''){

            return false;

        }else if($referer == $this->router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL)){

            return false;

        }else if($referer == $this->router->generate('security_register', [], UrlGeneratorInterface::ABSOLUTE_URL)){

            return false;

        }

        return true;

    }

    public function getRedirectUri(Request $request) : string
    {
        //dump("Referer == ".$this->referer);

        //dump("Login path == ".$this->router->generate('security_login', [], UrlGeneratorInterface::ABSOLUTE_URL));

        $url = $this->getTargetPath($request->getSession(), 'main');

        if($url)
            return $url;


        $referer = $request->getSession()->get($this->ourTargetPath_key);

        if(!$referer){

            throw new \RuntimeException("Hello");

        }

        return $referer;
    }

}