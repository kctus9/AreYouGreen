<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleBiodiversiteController extends AbstractController
{
    /**
     * @Route("/article/biodiversite", name="article_biodiversite")
     */
    public function index(): Response
    {
        return $this->render('article_biodiversite/index.html.twig', [
            'controller_name' => 'ArticleBiodiversiteController',
        ]);
    }
}
