<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Player;
use App\Entity\Staff;
use App\Entity\Stats;
use App\Entity\Team;
use App\Entity\User;
use App\Form\EventType;
use App\Form\NewsType;
use App\Form\PlayerType;
use App\Form\TeamType;
use App\Form\UserType;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\PlayerRepository;
use App\Repository\StaffRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/users/delete/{id}", name="admin_users_delete")
     */
    public function deleteUser(User $user, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('admin_users');
    }
    /**
     * @Route("/users/{id}", name="admin_users_edit")
     */
    public function edit_users(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/users_edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/staff", name="admin_staff")
     */
    public function staff(StaffRepository $staffRepository): Response
    {
        return $this->render('admin/staff.html.twig', [
            'staffRepository' => $staffRepository->findAll(),
        ]);
    }
    /**
     * @Route("/staff/{id}", name="admin_staff_edit")
     */
    public function edit_staff(Request $request, Staff $staff, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/staff_edit.html.twig', [
            'staff' => $staff,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/news", name="admin_news")
     */
    public function news(NewsRepository $newsRepository): Response
    {
        return $this->render('admin/news.html.twig', [
            'newsRepository' => $newsRepository->findAll(),
        ]);
    }
    /**
     * @Route("/news/{id}", name="admin_news_edit")
     */
    public function edit_news(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_news', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news_edit.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/news/delete/{id}", name="admin_news_delete")
     */
    public function deleteNews(News $news, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $news->getId(), $request->get('_token'))) {
            $em->remove($news);
            $em->flush();
        }
        return $this->redirectToRoute('admin_news');
    }

    /**
     * @Route("/players", name="admin_players")
     */
    public function players(PlayerRepository $playerRepository): Response
    {
        return $this->render('admin/players.html.twig', [
            'playerRepository' => $playerRepository->findAll(),
        ]);
    }
    /**
     * @Route("/players/{id}", name="admin_players_edit")
     */
    public function edit_player(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_players', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/players_edit.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/stats/{id}", name="admin_stats_edit")
     */
    public function edit_stats(Request $request, Stats $stats, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatsType::class, $stats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_players', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/stats_edit.html.twig', [
            'stats' => $stats,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/players/delete/{id}", name="admin_players_delete")
     */
    public function deletePlayer(Player $player, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $player->getId(), $request->get('_token'))) {
            $em->remove($player);
            $em->flush();
        }
        return $this->redirectToRoute('admin_players');
    }

    /**
     * @Route("/teams", name="admin_teams")
     */
    public function teams(TeamRepository $teamRepository): Response
    {
        return $this->render('admin/teams.html.twig', [
            'teamRepository' => $teamRepository->findAll(),
        ]);
    }
    /**
     * @Route("/teams/{id}", name="admin_teams_edit")
     */
    public function edit_team(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_teams', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/teams_edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/teams/delete/{id}", name="admin_teams_delete")
     */
    public function deleteTeam(Team $team, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->get('_token'))) {
            $em->remove($team);
            $em->flush();
        }
        return $this->redirectToRoute('admin_teams');
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
    public function events(EventRepository $eventRepository): Response
    {
        return $this->render('admin/events.html.twig', [
            'eventRepository' => $eventRepository->findAll(),
        ]);
    }
    /**
     * @Route("/events/{id}", name="admin_events_edit")
     */
    public function edit_event(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_events', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/events_edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/events/delete/{id}", name="admin_events_delete")
     */
    public function deleteEvent(Event $event, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->get('_token'))) {
            $em->remove($event);
            $em->flush();
        }
        return $this->redirectToRoute('admin_events');
    }
}
