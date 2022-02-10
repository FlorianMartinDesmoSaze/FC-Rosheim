<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(NewsRepository $newsRepository): Response
    {

        $news = $newsRepository->findLastThreeNews();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'news' => $news,
        ]);
    }
}
