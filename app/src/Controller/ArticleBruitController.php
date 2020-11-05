<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleBruitController extends AbstractController
{
    /**
     * @Route("/article/bruit", name="article_bruit")
     */
    public function index(): Response
    {
        return $this->render('article_bruit/index.html.twig', [
            'controller_name' => 'ArticleBruitController',
        ]);
    }
}
