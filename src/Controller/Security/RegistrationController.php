<?php

namespace App\Controller\Security;


use App\Entity\Security\User;
use App\Form\Security\RegisterFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\WorkWithTargetPath;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

use Symfony\Component\Form\Form;

class RegistrationController extends Controller
{
    private $entityManager;
    private $authenticatorHandler;
    /**
     * @var LoginFormAuthenticator
     */
    private $authenticator;
    /**
     * @var WorkWithTargetPath
     */
    private $workWithTargetPath;

    public function __construct(
        EntityManagerInterface $entityManager,
        GuardAuthenticatorHandler $authenticatorHandler,
        LoginFormAuthenticator $authenticator,
        WorkWithTargetPath $workWithTargetPath
    )
    {
        $this->entityManager = $entityManager;
        $this->authenticatorHandler = $authenticatorHandler;
        $this->authenticator = $authenticator;
        $this->workWithTargetPath = $workWithTargetPath;
    }


    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(RegisterFormType::class);

        $form->handleRequest($request);
        dump($form->getConfig());

        if($form->isSubmitted() && $form->isValid())
        {

            /** @var User $user */
            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Welcome '.$user->getUsername());

            return $this->authenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->authenticator,
                'main'
                );
        }

        //save referer to session, to go after success registration
        $referer = ($_SERVER['HTTP_REFERER']) ?? '';
        $this->workWithTargetPath->saveReferer($referer, $request);

        return $this->render('security/register.html.twig',[
            'register_form' => $form->createView(),
            //'referer' => $referer
        ]);
    }
}