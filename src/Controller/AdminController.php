<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\News;
use App\Entity\Player;
use App\Entity\Staff;
use App\Entity\Stats;
use App\Entity\Team;
use App\Entity\User;
use App\Form\AdminNewsType;
use App\Form\EventType;
use App\Form\GameType;
use App\Form\NewEventType;
use App\Form\NewGameType;
use App\Form\PlayerType;
use App\Form\StaffType;
use App\Form\StatsType;
use App\Form\TeamType;
use App\Form\UserType;
use App\Repository\EventRepository;
use App\Repository\GameRepository;
use App\Repository\NewsRepository;
use App\Repository\PlayerRepository;
use App\Repository\StaffRepository;
use App\Repository\StatsRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
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
    public function new_staff(Request $request,
                               FileUploader $fileUploader,
                               EntityManagerInterface $entityManager): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if ($staff->getPicture() != null) {
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $pictureStaff = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureStaff);
                $staff->setPicture($pictureFileName);
            }

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
    public function edit_staff(Request $request,
                                Staff $staff,
                                FileUploader $fileUploader,
                                StaffRepository $staffRepository,
                                EntityManagerInterface $entityManager,
                                int $id): Response

    {
        $form = $this->createForm(StaffType::class, $staff);
        $staff = $staffRepository->find($id); // find staff by id
        // check whether an image is already set

        $oldFileName = null;
        $oldFileNamePath = null;

        if($staff->getPicture() != null){
            // transform the image string from DB to File to comply with form types
            $oldFileName = $staff->getPicture(); // get image name from db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; // get its path
            $pictureFile = new File($oldFileNamePath); // create file
            $staff->setPicture($pictureFile);
            // else define $oldFileNamePath as null to avoid getting an error
            // when trying to remove an inexistant old file
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if($staff->getPicture() != null){
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $pictureStaff = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureStaff);
                $staff->setPicture($pictureFileName);
                if ($oldFileName != null) {
                    // delete old picture from the app only if there was one before
                    $filesystem->remove($oldFileNamePath);
                }
            }
            // else set keep the existing picture
            else {
                $staff->setPicture($oldFileName);
            }
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
            'newsRepository' => $newsRepository->findAllByLatest(),
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
    public function new_news(Request $request,
                             FileUploader $fileUploader,
                             EntityManagerInterface $entityManager): Response
    {
        $news = new News();
        $form = $this->createForm(AdminNewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if ($news->getPicture() != null) {
                $pictureNews = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureNews);
                $news->setPicture($pictureFileName);
            }

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
    public function edit_news(Request $request,
                                News $news,
                                FileUploader $fileUploader,
                                NewsRepository $newsRepository,
                                EntityManagerInterface $entityManager,
                                int $id): Response

    {
        $form = $this->createForm(AdminNewsType::class, $news);
        $news = $newsRepository->find($id); // find news by id
        // check whether an image is already set

        $oldFileName = null;
        $oldFileNamePath = null;

        if($news->getPicture() != null){
            // transform the image string from DB to File to comply with form types
            $oldFileName = $news->getPicture(); // get image name from db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; // get its path
            $pictureFile = new File($oldFileNamePath); // create file
            $news->setPicture($pictureFile);
            // else define $oldFileNamePath as null to avoid getting an error
            // when trying to remove an inexistant old file
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if($news->getPicture() != null){
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $pictureNews = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureNews);
                $news->setPicture($pictureFileName);
                if ($oldFileName != null) {
                    // delete old picture from the app only if there was one before
                    $filesystem->remove($oldFileNamePath);
                }
            }
            // else set keep the existing picture
            else {
                $news->setPicture($oldFileName);
            }
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
    public function new_player(Request $request,
                             FileUploader $fileUploader,
                             EntityManagerInterface $entityManager): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if ($player->getPicture() != null) {
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $picturePlayer = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($picturePlayer);
                $player->setPicture($pictureFileName);
            }

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
    public function edit_player(Request $request,
                                Player $player,
                                FileUploader $fileUploader,
                                PlayerRepository $playerRepository,
                                EntityManagerInterface $entityManager,
                                int $id): Response

    {
        $form = $this->createForm(PlayerType::class, $player);
        $player = $playerRepository->find($id); // find player by id
        // check whether an image is already set

        $oldFileName = null;
        $oldFileNamePath = null;

        if($player->getPicture() != null){
            // transform the image string from DB to File to comply with form types
            $oldFileName = $player->getPicture(); // get image name from db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; // get its path
            $pictureFile = new File($oldFileNamePath); // create file
            $player->setPicture($pictureFile);
            // else define $oldFileNamePath as null to avoid getting an error
            // when trying to remove an inexistant old file
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if($player->getPicture() != null){
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $picturePlayer = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($picturePlayer);
                $player->setPicture($pictureFileName);
                if ($oldFileName != null) {
                    // delete old picture from the app only if there was one before
                    $filesystem->remove($oldFileNamePath);
                }
            }
            // else set keep the existing picture
            else {
                $player->setPicture($oldFileName);
            }
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
                               StatsRepository $statsRepository,
                               PlayerRepository $playerRepository,
                               EntityManagerInterface $entityManager,
                               int $id): Response
    {
        // fetch player and stats by id
        $player = $playerRepository->find($id);
        $stats = $statsRepository->findOneBy(['player' => $id]);

        // if there are no stats for this player yet, create them
        if ($stats == null){
            $stats = new Stats();
            $newStats = true;
        } else {
            $newStats = false;
        }

        $form = $this->createForm(StatsType::class, $stats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // only persist if we had to create a new stat sheet
            if ($newStats){
                $stats->setPlayer($player);
                $entityManager->persist($stats);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_players_edit', ['id'=>$id], Response::HTTP_SEE_OTHER);
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
    public function new_team(Request $request,
                             FileUploader $fileUploader,
                             EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if ($team->getPicture() != null) {
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $pictureTeam = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureTeam);
                $team->setPicture($pictureFileName);
            }

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
    public function edit_team(Request $request,
                                Team $team,
                                FileUploader $fileUploader,
                                TeamRepository $teamRepository,
                                EntityManagerInterface $entityManager,
                                int $id): Response

    {
        $form = $this->createForm(TeamType::class, $team);
        $team = $teamRepository->find($id); // find team by id
        // check whether an image is already set

        $oldFileName = null;
        $oldFileNamePath = null;

        if($team->getPicture() != null){
            // transform the image string from DB to File to comply with form types
            $oldFileName = $team->getPicture(); // get image name from db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; // get its path
            $pictureFile = new File($oldFileNamePath); // create file
            $team->setPicture($pictureFile);
            // else define $oldFileNamePath as null to avoid getting an error
            // when trying to remove an inexistant old file
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // check if picture field isn't null
            if($team->getPicture() != null){
                $filesystem = new Filesystem(); // use this class in order to use its remove() function
                $pictureTeam = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureTeam);
                $team->setPicture($pictureFileName);
                if ($oldFileName != null) {
                    // delete old picture from the app only if there was one before
                    $filesystem->remove($oldFileNamePath);
                }
            }
            // else set keep the existing picture
            else {
                $team->setPicture($oldFileName);
            }
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
    public function results(GameRepository $gameRepository): Response
    {
        return $this->render('admin/results.html.twig', [
            'gameRepository' => $gameRepository->findAllByLatest(),
        ]);
    }
    /**
     * @Route("/results/delete/{id}", name="admin_results_delete", methods={"DELETE"})
     */
    public function deleteGame(Game $game, EntityManagerInterface $em, Request $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete' . $game->getId(), $request->get('_token'))) {
            $em->remove($game);
            $em->flush();
        }
        return $this->redirectToRoute('admin_results');
    }
    /**
     * @Route("/results/new", name="admin_results_new")
     */
    public function new_game(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $form = $this->createForm(NewGameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('admin_results', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/results_new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/results/{id}", name="admin_results_edit", methods={"GET", "POST"})
     */
    public function edit_game(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_results', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/results_edit.html.twig', [
            'game' => $game,
            'form' => $form,
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
            'eventRepository' => $eventRepository->findAllByLatest(),
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
