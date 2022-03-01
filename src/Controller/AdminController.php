<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\News;
use App\Entity\Player;
use App\Entity\Staff;
use App\Entity\Team;
use App\Entity\User;
use App\Form\EventType;
use App\Form\NewEventType;
use App\Form\NewsType;
use App\Form\PlayerType;
use App\Form\StaffType;
use App\Form\StatsType;
use App\Form\TeamType;
use App\Form\UserType;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\PlayerRepository;
use App\Repository\StaffRepository;
use App\Repository\StatsRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
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

                            ///////////////////
                            //     USERS     //
                            ///////////////////
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
     * @Route("/users/delete/{id}", name="admin_users_delete", methods={"DELETE"})
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
     * @Route("/users/{id}", name="admin_users_edit", methods={"GET", "POST"})
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

                        ///////////////////
                        //     STAFF     //
                        ///////////////////
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
     * @Route("/staff/delete/{id}", name="admin_staff_delete", methods={"DELETE"})
     */
    public function deleteStaff(Staff $staff, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $staff->getId(), $request->get('_token'))) {
            $em->remove($staff);
            $em->flush();
        }
        return $this->redirectToRoute('admin_staff');
    }
    /**
     * @Route("/staff/new/", name="admin_staff_new")
     */
    public function new_staff(Request $request, EntityManagerInterface $entityManager): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($staff);
            $entityManager->flush();

            return $this->redirectToRoute('admin_staff', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/staff_new.html.twig', [
            'staff' => $staff,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/staff/{id}", name="admin_staff_edit", methods={"GET", "POST"})
     */
    public function edit_staff(Request $request, Staff $staff, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_staff', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/staff_edit.html.twig', [
            'staff' => $staff,
            'form' => $form,
        ]);
    }

                        ///////////////////
                        //      NEWS     //
                        ///////////////////
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
     * @Route("/news/delete/{id}", name="admin_news_delete", methods={"DELETE"})
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
     * @Route("/news/new", name="admin_news_new")
     */
    public function new_news(Request $request, EntityManagerInterface $entityManager): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('admin_news', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/news_new.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/news/{id}", name="admin_news_edit", methods={"GET", "POST"})
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

                        ///////////////////
                        //    PLAYERS    //
                        ///////////////////
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
     * @Route("/players/delete/{id}", name="admin_players_delete", methods={"DELETE"})
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
     * @Route("/players/new", name="admin_players_new")
     */
    public function new_player(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('admin_players', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/players_new.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/players/{id}", name="admin_players_edit", methods={"GET", "POST"})
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

                        ///////////////////
                        //     STATS     //
                        ///////////////////
    /**
     * @Route("/stats/{id}", name="admin_stats_edit", methods={"GET", "POST"})
     */
    public function edit_stats(Request $request,
                               PlayerRepository $playerRepository,
                               StatsRepository $statsRepository,
                               EntityManager $entityManager,
                               int $id): Response
    {
        $player = $playerRepository->find($id);
        $stats = $statsRepository->findOneBy(['player' => $id]);

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

                        ///////////////////
                        //     TEAMS     //
                        ///////////////////
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
     * @Route("/teams/new", name="admin_teams_new")
     */
    public function new_team(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('admin_teams', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/teams_new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/teams/delete/{id}", name="admin_teams_delete", methods={"DELETE"})
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
     * @Route("/teams/{id}", name="admin_teams_edit", methods={"GET", "POST"})
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

                        ///////////////////
                        //    RESULTS    //
                        ///////////////////
    /**
     * @Route("/results", name="admin_results")
     */
    public function results(): Response
    {
        return $this->render('admin/results.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

                        ///////////////////
                        //     EVENTS    //
                        ///////////////////
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
     * @Route("/events/delete/{id}", name="admin_events_delete", methods={"DELETE"})
     */
    public function deleteEvent(Event $event, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->get('_token'))) {
            $em->remove($event);
            $em->flush();
        }
        return $this->redirectToRoute('admin_events');
    }
    /**
     * @Route("/events/new", name="admin_events_new")
     */
    public function new_event(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(NewEventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('admin_events', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/events_new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/events/{id}", name="admin_events_edit", methods={"GET", "POST"})
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
}
