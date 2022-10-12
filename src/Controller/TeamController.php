<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\PlayerRepository;
use App\Repository\StatsRepository;
use App\Repository\TeamRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository, Breadcrumbs $breadcrumbs): Response
    {

        $breadcrumbs->addItem("home", $this->generateUrl("home"));
        $breadcrumbs->addItem("team", $this->generateUrl("team_index"));

        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, Breadcrumbs $breadcrumbs): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        $breadcrumbs->addItem("home", $this->generateUrl("home"));
        $breadcrumbs->addItem("team", $this->generateUrl("team_index"));
        $breadcrumbs->addItem("new", $this->generateUrl("team_new"));

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureTeam = $form->get('picture')->getData();
            // this condition is needed because the picture's field is not required
            // so the file must be processed only when a file is uploaded
            if ($pictureTeam) {
                $pictureFileName = $fileUploader->upload($pictureTeam);
                $team->setPicture($pictureFileName);
            }
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @Route("/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}", name="team_show", methods={"GET"})
     */
    public function playersByTeam(Team $team, PlayerRepository $playerRepository, 
        StatsRepository $statsRepository, TeamRepository $teamRepository, Breadcrumbs $breadcrumbs): Response
    {
        
        //looking for team id
        $id = $teamRepository->find($team->getId());
        //use custom request from playerRepo
        $players = $playerRepository->findPlayersByTeam($id);
        $goalKeepers = $playerRepository->findPlayersByPosition($id, 1); //find goalkeepers = 1
        $defenders = $playerRepository->findPlayersByPosition($id, 2); //find defenders = 2
        $midfielders = $playerRepository->findPlayersByPosition($id, 3); //find midfielders = 3
        $strickers = $playerRepository->findPlayersByPosition($id, 4); //find strickers = 4
        $stats = $statsRepository->findBy(['player' => $players]);

        $team = $teamRepository->find($id);
        $teamId = $team->getId();

        $breadcrumbs->addItem("home", $this->generateUrl("home"));
        $breadcrumbs->addItem("team", $this->generateUrl("team_index"));
        $breadcrumbs->addItem($teamId, $this->generateUrl("news_index", [], $teamId));

        return $this->render('team/show.html.twig', [
            'stats' => $stats,
            'goalKeepers' => $goalKeepers,
            'defenders' => $defenders,
            'midfielders' => $midfielders,
            'strickers' => $strickers,
            'players' => $players,
            'team' => $team,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, TeamRepository $teamRepository,
        Team $team, EntityManagerInterface $entityManager, FileUploader $fileUploader, int $id, Breadcrumbs $breadcrumbs): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $team = $teamRepository->find($id); //we find team by id

        //we check if an image was already set
        if($team->getPicture()!=null){
            //we must transform the image string from DB to File to respect the form types
            $oldFileName = $team->getPicture(); //we get image name in db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; //we get his path
            $pictureFile = new File($oldFileNamePath); //create file
            $team->setPicture($pictureFile);
        }else{ //else we define $oldFileNamePath as null to avoid error when trying to remove an inexistant old file
            $oldFileNamePath = null;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //we check if picture field isn't null
            if($team->getPicture()!=null){
                $filesystem = new Filesystem(); //we use this class in order to use his function remove()
                $pictureTeam = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureTeam);
                $team->setPicture($pictureFileName);
                $filesystem->remove($oldFileNamePath); //we delete old picture from application
            }
            // else we set old picture
            else{
                $team->setPicture($oldFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem(); //we use this class in order to use his function remove() to remove a file
            $fileName = $team->getPicture();
            $fileNamePath = $this->getParameter('images_directory').'/'.$fileName;
            $filesystem->remove($fileNamePath); //we delete old picture from application
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
    }

}
