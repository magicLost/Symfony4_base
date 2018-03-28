<?php

namespace App\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowController extends Controller
{
    /**
     * @Route("/admin/show", name="admin_show")
     */
    public function show()
    {
        $tables = [
            [
                'href' => 1,
                'name' => 2
                ]
        ];

        return $this->render('admin/show.htm.twig', [
            'title' => 'Show all admin tables',
            'tables' => $tables
        ]);
    }
}