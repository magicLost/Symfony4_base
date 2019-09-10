<?php
/**
 * Created by PhpStorm.
 * User: Nikki
 * Date: 03.04.2018
 * Time: 14:39
 */

namespace App\Controller\Admin;


use App\Entity\Admin\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
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
     * @Route("/admin/delete/{id}/user", name="admin_delete_user", requirements={"id"="\d+"})
     */
    public function delete_user(Request $request, User $user)
    {

        if($request->isMethod('POST'))
        {
            $confirm = $request->request->get('confirm');

            if($confirm !== "Yes")
                return $this->redirectToRoute("admin_show");

            //delete user
            $this->entityManager->remove($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'User successfully deleted... You are amazing.');

            return $this->redirectToRoute("admin_show");
        }

        return $this->render('admin/delete_user.html.twig', [
            'title' => 'Delete user',
            'user' => $user,
        ]);
    }
}