<?php

namespace App\Controller;

use App\Entity\Event;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     */
    public function getEvents() {
        $eventRepo = $this->getDoctrine()->getRepository(Event::class);
        $events = $eventRepo->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($events, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route(name="eventsById", path="api/events/{id}", methods={"GET"})
     * @SWG\Get(
     *     path="/api/events/{id}",
     *     summary="Get events by date id",
     *     operationId="getEventsByDateId",
     *     produces={"application/json"},
     *     description="Returns every events for the given date id",
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
     *          @Model(type=Event::class)
     *     )
     * )
     */
    public function getEventsByDateId(Request $request) {
        $eventRepo = $this->getDoctrine()->getRepository(Event::class);
        $events = $eventRepo->findBy(["dateId" => $request->get("id")]);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($events, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }
}
