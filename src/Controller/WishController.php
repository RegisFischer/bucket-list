<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish",name="wish")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/", name="wish_index")
     */
    public function index(): Response
    {
        return $this->render('wish/index.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }

    /**
     * @Route("/list",name="wish_list")
     */
    public function list(): Response{
        return $this->render('wish/list.html.twig');
    }

    /**
     * @Route("/detail/{id}",name="wish_detail")
     */
    public function detail($id): Response{
        return $this->render('wish/detail.html.twig',[
            'id'=>$id
        ]);
    }
}
