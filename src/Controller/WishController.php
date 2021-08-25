<?php

namespace App\Controller;

use App\Entity\Wish;
use Doctrine\ORM\EntityManagerInterface;
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
        dump(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Wish::class);
        $wishes = $repo->findAll();
        return $this->render('wish/list.html.twig',[
            'wishes'=>$wishes
        ]);
    }

    /**
     * @Route("/detail/{id}",name="detail")
     */
    public function detail($id,EntityManagerInterface $entityManager): Response{

        $repo = $entityManager->getRepository(Wish::class);
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
        $wish->setTitle("troisiemeIdee");
        $wish->setDescription("J'aime les idees surtout avec de la vanille");
        $wish->setAuthor("Jean-Luc Melenchon");
        $wish->setIsPublished(true);
        $wish->setDateCtreated(new \DateTime());
        $em->persist($wish);
        $em->flush();
        return $this->render('base.html.twig');
    }


}
