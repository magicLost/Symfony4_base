<?php

namespace App\Controller\Admin;


use App\Form\Admin\CarFormType;
use App\Form\Admin\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AddController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/user/add", name="admin_user_add")
     */
    public function user_add(Request $request)
    {
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);

        //dump($form->all()['name']->getConfig()->getAttributes()["data_collector/passed_options"]['attr']);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                sprintf('User successfully added - you (%s) are amazing...'), $this->getUser()->getUserName());

            return $this->redirectToRoute('admin_show');
        }

        return $this->render('admin/add_user.html.twig', [
            'title' => 'Add new user',
            'user_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/car/add", name="admin_car_add")
     */
    public function car_add(Request $request)
    {
        $form = $this->createForm(CarFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $car = $form->getData();

            $this->entityManager->persist($car);
            $this->entityManager->flush();

            $this->addFlash('success', 'Car successfully added - you are amazing...');

            return $this->redirectToRoute('admin_show');
        }

        return $this->render('admin/add_car.html.twig', [
            'title' => 'Add new car model',
            'car_form' => $form->createView()
        ]);
    }
}