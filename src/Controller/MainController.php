<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/",name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/main", name="index")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home():Response{
        return $this->render('main/home.html.twig',[]);
    }

    /**
     * @Route("/AboutUs", name="about")
     */
    public function aboutUs():Response{
        return $this->render('main/about-us.html.twig');
    }

    /**
     * @Route("/legal-stuff",name="legalStuff")
     */
    public function legalStuff():Response{
        return $this->render('main/legal.html.twig');
    }
}
