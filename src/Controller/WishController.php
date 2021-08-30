<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use App\Util\Censurator;
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
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $entityManager,WishRepository $repo){
        $this->em = $entityManager;
        $this->repo = $repo;
    }
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

        $wishes = $this->repo->findBy(["isPublished"=>true],["created_at"=>"DESC"]);
        dump($wishes);
        return $this->render('wish/list.html.twig',[
            'wishes'=>$wishes
        ]);
    }

    /**
     * @Route("/detail/{id}",name="detail")
     */
    public function detail(int $id): Response{

        $wish = $this->repo->findByIDJoinCat($id);
        dump($wish);
        return $this->render('wish/detail.html.twig',[
            'wish'=>$wish,
        ]);
    }

    /**
     * @Route("/data",name="data")
     */
    public function data(){
        return $this->render('wish/dataTable.html.twig');
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request,Censurator $censure):Response{
        $wish = new Wish();

        $wishForm = $this->createForm(WishType::class,$wish);
        $wishForm->handleRequest($request);


        if($wishForm->isSubmitted() && $wishForm->isValid()){

            $wish=$censure->purify($wish);
            $wish->setIsPublished(true);
            $this->em->persist($wish);
            $this->em->flush();
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
    public function modifier(Request $request,int $id,Censurator $censure):Response{
        $wish = $this->repo->find($id);

        $wishForm = $this->createForm(WishType::class,$wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish=$censure->purify($wish);
            $this->em->flush();
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
    public function supprimer(int $id):Response{
        $wish = $this->em->getRepository(Wish::class)->find($id);
        $this->em->remove($wish);
        $this->em>flush();
        $this->addFlash('success','Wish Supprimé');
        return $this->redirectToRoute('wish_list');
    }

    private function getCategorie(CategoryRepository $repocat,int $id):Category
    {
        return $repocat->find($id);
    }

}
