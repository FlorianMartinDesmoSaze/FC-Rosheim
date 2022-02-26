<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

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
        ]);
    }

    /**
     * @Route("/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}", name="team_show", methods={"GET"})
     */
    public function playersByTeam(Team $team, PlayerRepository $playerRepository, TeamRepository $teamRepository): Response
    {
        
        //looking for team id
        $id = $teamRepository->find($team->getId());
        //use custom request from playerRepo
        $players = $playerRepository->findPlayersByTeam($id);
        $goalKeepers = $playerRepository->findPlayersByPosition($id, 1); //find goalkeepers = 1
        $defenders = $playerRepository->findPlayersByPosition($id, 2); //find defenders = 2
        $midfielders = $playerRepository->findPlayersByPosition($id, 3); //find midfielders = 3
        $strickers = $playerRepository->findPlayersByPosition($id, 4); //find strickers = 4

        //if there's no player in team display an error 404
        if (!$players) {
            throw $this->createNotFoundException(
                'Il n\'y a pas de joueurs dans cette équipe'
            );
        }

        return $this->render('team/show.html.twig', [
            'goalKeepers' => $goalKeepers,
            'defenders' => $defenders,
            'midfielders' => $midfielders,
            'strickers' => $strickers,
            'players' => $players,
            'team' => $team
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Team $team, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);        

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureTeam = $form->get('picture')->getData();
            // this condition is needed because the picture's field is not required
            // so the file must be processed only when a file is uploaded
            if ($pictureTeam) {
                $pictureFileName = $fileUploader->upload($pictureTeam);
                $team->setPicture($pictureFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', [], Response::HTTP_SEE_OTHER);
    }

}
