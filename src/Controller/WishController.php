<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $wishes = $repo->findBy(["isPublished"=>true],["dateCtreated"=>"DESC"]);
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
    public function ajouter(Request $request,EntityManagerInterface $entityManager):Response{
        $wish = new Wish();

        $wishForm = $this->createForm(WishType::class,$wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setDateCtreated(new \DateTime("now"));
            $wish->setIsPublished(true);
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success','Wish Ajouté');
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/ajouter.html.twig',[
            "wishForm"=> $wishForm->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifier(Request $request,EntityManagerInterface $entityManager,int $id):Response{
       $wish = $entityManager->getRepository(Wish::class)->find($id);
        $wishForm = $this->createForm(WishType::class,$wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){

            $entityManager->flush();

            $this->addFlash('success','Wish Modifié');
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/modifier.html.twig',[
            "wishForm"=>$wishForm->createView()
            ]);
    }

    /**
     * @Route("/supprimer/{id}",name="supprimer")
     */
    public function supprimer(EntityManagerInterface $em,int $id):Response{
        $wish = $em->getRepository(Wish::class)->find($id);
        $em->remove($wish);
        $em->flush();
        $this->addFlash('success','Wish Supprimé');
        return $this->redirectToRoute('wish_list');
    }

}
