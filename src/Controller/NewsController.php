<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Service\FileUploader;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use App\Entity\Team;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_index", methods={"GET"})
     */
    public function index(NewsRepository $newsRepository): Response
    {

        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureNews = $form->get('picture')->getData();
            // this condition is needed because the picture's field is not required
            // so the file must be processed only when a file is uploaded
            if ($pictureNews) {
                $pictureFileName = $fileUploader->upload($pictureNews);
                $news->setPicture($pictureFileName);
            }
            $entityManager->persist($news);
            $entityManager->flush();

            // return 303 code to confirm news creation and index redirection
            return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('news/new.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="news_show", methods={"GET"})
     */
    public function show(NewsRepository $newsRepository, int $id): Response
    {
        $news = $newsRepository->find($id);

        if (! $news) {
            throw $this->createNotFoundException('The news '. $id . ' does not exist');
        }

        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, News $news, NewsRepository $newsRepository,
        EntityManagerInterface $entityManager, FileUploader $fileUploader, int $id): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $news = $newsRepository->find($id); //we find team by id
        //we check if an image was already set
        if($news->getPicture()!=null){
            //we must transform the image string from DB to File to respect the form types
            $oldFileName = $news->getPicture(); //we get image name in db
            $oldFileNamePath = $this->getParameter('images_directory').'/'.$oldFileName; //we get his path
            $pictureFile = new File($oldFileNamePath); //create file
            $news->setPicture($pictureFile);
        }else{ //else we define $oldFileNamePath as null to avoid error when trying to remove an inexistant old file
            $oldFileNamePath = null;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($news->getPicture()!=null){
                $filesystem = new Filesystem(); //we use this class in order to use his function remove()
                $pictureNews = $form->get('picture')->getData();
                $pictureFileName = $fileUploader->upload($pictureNews);
                $news->setPicture($pictureFileName);
                $filesystem->remove($oldFileNamePath); //we delete old picture from application
            }
            // else we set old picture
            else{
                $news->setPicture($oldFileName);
            }
            $entityManager->flush();

            return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('news/edit.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem(); //we use this class in order to use his function remove() to remove a file
            $fileName = $news->getPicture();
            $fileNamePath = $this->getParameter('images_directory').'/'.$fileName;
            $filesystem->remove($fileNamePath); //we delete old picture from application
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index', [], Response::HTTP_SEE_OTHER);
    }
}
