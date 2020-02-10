<?php

namespace App\Controller;

use App\Entity\EventPlace;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EventsController extends AbstractController
{
    /**
     * @Route("/events", name="events")
     */
    public function index()
    {
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
        ]);
    }

    /**
     * @Route(
     *     name="event_places",
     *     path="/event_places",
     *     methods={"GET"}
     * )
     */
    public function getEventPlaces() {
        $eventPlaceRepo = $this->getDoctrine()->getRepository(EventPlace::class);
        $eventPlaces = $eventPlaceRepo->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($eventPlaces, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }
}
