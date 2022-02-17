<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUsersType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

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
    public function users(UserRepository $userRepository): Response
    {
        return $this->render('admin/users.html.twig', [
            'userRepository' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/users/{id}", name="admin_users_edit")
     */
    public function edit_users(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/usersedit.html.twig', [
            'user' => $user,
            'form' => $form,
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
