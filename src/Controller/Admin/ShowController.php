<?php

namespace App\Controller\Admin;


use App\Entity\Admin\Car;
use App\Entity\Admin\User;
use App\Entity\Admin\UserCar;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ShowController extends Controller
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
     * @Route("/admin/show", name="admin_show")
     */
    public function show()
    {

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $cars = $this->entityManager->getRepository(Car::class)->findAll();

        $users_cars = $this->entityManager->getRepository(UserCar::class)->findAll();

        return $this->render('admin/show.html.twig', [
            'title' => 'Show all admin tables',
            'users' => $users,
            'cars' => $cars,
            'users_cars' => $users_cars
        ]);
    }

    /**
     * @Route("/admin/show/{id}/user", name="admin_show_user", requirements={"id"="\d+"})
     */
    public function show_user(int $id){

        $user = $this->entityManager->getRepository(User::class)->findOneByIdWithAllCars($id);

        return $this->render('admin/show_user.html.twig', [
            'title' => 'User...',
            'user' => $user
        ]);

    }

    /**
     * @Route("/admin/show/{id}/car", name="admin_show_car", requirements={"id"="\d+"})
     */
    public function show_car(int $id){

        $car = $this->entityManager->getRepository(Car::class)->findOneByIdWithAllUsers($id);

        return $this->render('admin/show_car.html.twig', [
            'title' => 'Car...',
            'car' => $car
        ]);
    }
}
