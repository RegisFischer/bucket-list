<?php

namespace App\Controller;

use App\Entity\Wish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish",name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('wish/index.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }

    /**
     * @Route("/list",name="list")
     */
    public function list(): Response{
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Wish::class);
        $wishes = $repo->findAll();
        dump($wishes);
        return $this->render('wish/list.html.twig',[
            'wishes'=>$wishes
        ]);
    }

    /**
     * @Route("/detail/{id}",name="detail")
     */
    public function detail($id): Response{
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Wish::class);
        $wish = $repo->find($id);

        return $this->render('wish/detail.html.twig',[
            'wish'=>$wish
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(){
        $em = $this->getDoctrine()->getManager();
        $wish = new Wish();
        $wish->setTitle("Deuxieme Idee");
        $wish->setDescription("Encore une idée qui passait par la");
        $wish->setAuthor("Jean-luc DeLaRue");
        $wish->setIsPublished(true);
        $em->persist($wish);
        $em->flush();
        return $this->render('wish/list.html.twig');
    }


}
