<?php

namespace App\Controller\LearnEncore;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class LearnencoreController extends Controller
{
    /**
     * @Route("/learn_encore", name="learn_encore_main_page")
     */
    public function main_page()
    {
        return $this->render('learnencore/mainpage.html.twig');
    }
}

