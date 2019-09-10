<?php

namespace App\Controller\Security;


use App\Form\Security\LoginFormType;
use App\Service\WorkWithTargetPath;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    private $workWithTargetPath;


    public function __construct( WorkWithTargetPath $workWithTargetPath)
    {
        $this->workWithTargetPath = $workWithTargetPath;
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginFormType::class, [
            '_username' => $lastUsername
        ]);


        $referer = ($_SERVER['HTTP_REFERER']) ?? '';
        $this->workWithTargetPath->saveReferer($referer, $request);

        //dump($request->getSession());

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            //'referer' => $referer,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        throw new \Exception('this should not be reached');
    }

}