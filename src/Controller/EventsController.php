<?php

namespace App\Controller;

use App\Entity\Event;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EventsController extends AbstractController
{
    /**
     * @Route(name="events", path="api/events", methods={"GET"})
     * @SWG\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     operationId="getEvents",
     *     produces={"application/json"},
     *     description="Returns all events",
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
     *          @Model(type=Event::class)
     *     )
     * )
     */
    public function getEvents()
    {
        $eventRepository = $this->getDoctrine()->getRepository(Event::class);
        $events = $eventRepository->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($events, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonContent, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }

}
