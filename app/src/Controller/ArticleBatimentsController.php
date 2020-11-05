<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleBatimentsController extends AbstractController
{
    /**
     * @Route("/article/batiments", name="article_batiments")
     */
    public function index(): Response
    {
        return $this->render('article_batiments/index.html.twig', [
            'controller_name' => 'ArticleBatimentsController',
        ]);
    }
}
