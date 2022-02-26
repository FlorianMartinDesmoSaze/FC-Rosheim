<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Service\FileUploader;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/player")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="player_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="player_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picturePlayer = $form->get('picture')->getData();
            // this condition is needed because the picture's field is not required
            // so the file must be processed only when a file is uploaded
            if ($picturePlayer) {
                $pictureFileName = $fileUploader->upload($picturePlayer);
                $player->setPicture($pictureFileName);
            }
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/new.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     */
    public function show(PlayerRepository $playerRepository, int $id): Response
    {
        $player = $playerRepository->find($id);

        if (! $player) {
            throw $this->createNotFoundException('The player '. $id . ' does not exist');
        }
        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="player_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, PlayerRepository $playerRepository,
        Player $player, EntityManagerInterface $entityManager, FileUploader $fileUploader, int $id): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $player = $playerRepository->find($id); //we find player by id
       //we check if an image was already set
        if($player->getPicture()!=null){
            //we must transform the image string from DB to File to respect the form types
            $oldFileName = $player->getPicture(); //we get image name in db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; //we get his path
            $pictureFile = new File($oldFileNamePath); //create file
            $player->setPicture($pictureFile);
        }else{ //else we define $oldFileNamePath as null to avoid error when trying to remove an inexistant old file
            $oldFileNamePath = null;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //we check if picture field isn't null
            if($player->getPicture()!=null){
                $filesystem = new Filesystem(); //we use this class in order to use his function remove()
                $picturePlayer = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($picturePlayer);
                $player->setPicture($pictureFileName);
                $filesystem->remove($oldFileNamePath); //we delete old picture from application
            }
            // else we set old picture
            else{
                $player->setPicture($oldFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/edit.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="player_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_index', [], Response::HTTP_SEE_OTHER);
    }
}
