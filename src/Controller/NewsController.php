<?php

namespace App\Controller;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/', name: 'news')]
    public function index(NewsRepository $n): Response
    {

        $news = $n->findAll();
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
            'news'=>$news
        ]);
    }


}
