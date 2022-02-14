<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/index", name="admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/users", name="admin_users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/news", name="admin_news")
     */
    public function news(): Response
    {
        return $this->render('admin/news.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/teams", name="admin_teams")
     */
    public function teams(): Response
    {
        return $this->render('admin/teams.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/results", name="admin_results")
     */
    public function results(): Response
    {
        return $this->render('admin/results.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/events", name="admin_events")
     */
    public function events(): Response
    {
        return $this->render('admin/events.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
