<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/calendar", name="event_calendar", methods={"GET"})
     *
     * @return Response
     */
    public function calendar(): Response
    {
        return $this->render('booking/calendar.html.twig');
    }
    
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, Breadcrumbs $breadcrumbs): Response
    {

        $breadcrumbs->addItem('home', $this->generateUrl('home'));
        $breadcrumbs->addItem('event', $this->generateUrl('event_index'));

        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAllByLatest(),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }


    /**
     * @Route("/new", name="event_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Breadcrumbs $breadcrumbs): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        $breadcrumbs->addItem("home", $this->generateUrl("home"));
        $breadcrumbs->addItem("event", $this->generateUrl("event_index"));
        $breadcrumbs->addItem("new", $this->generateUrl("event_new"));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(EventRepository $eventRepository, int $id, Breadcrumbs $breadcrumbs): Response
    {

        $event = $eventRepository->find($id);

        $eventId = $event->getId();
        $eventSlug = $event->getSlug();

        $breadcrumbs->addItem("home", $this->generateUrl("home"));
        $breadcrumbs->addItem("event", $this->generateUrl("event_index"));
        $breadcrumbs->addItem($eventId, $this->generateUrl("news_index", [], $eventId));

        if (!$event) {
            throw $this->createNotFoundException(
                'The event '. $id . ' does not exist'
            );
        }
            return $this->render('event/show.html.twig', [
                'event' => $event,
                'breadcrumbs' => $breadcrumbs,
            ]);
        
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index', [], Response::HTTP_SEE_OTHER);
    }
}
