<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller qui gere les exception releve par le navigateur et les envoie sur une vue specifique.
 *  Permet de personnaliser le template pour les message d'erreurs et de plus avoir les stackTrace
 */
class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function show(FlattenException $exception): Response
    {
        $message=$exception->getMessage();
        $status=$exception->getStatusCode();

        return $this->render('Exception/index.html.twig', [
            'message' => $message,
            'status'=>$status
        ]);
    }
}
