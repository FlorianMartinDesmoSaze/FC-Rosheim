<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use Symfony\Config\WhiteOctoberBreadcrumbsConfig;
// WhiteOctoberBreadcrumbsConfig $breadcrumbs
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(NewsRepository $newsRepository, Breadcrumbs $breadcrumbs): Response
    {

        // $breadcrumbs = $this->get("white_october_breadcrumbs");
    
        // Simple example
        $breadcrumbs->addItem("Home", $this->generateUrl("home"));

        $news = $newsRepository->findLastThreeNews();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'news' => $news,
        ]);
    }
}
