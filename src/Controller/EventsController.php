<?php

namespace App\Controller;

use App\Entity\Defect;
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

    /**
     * @Route(name="eventsByDateId", path="api/events/{date_id}", methods={"GET"})
     * @SWG\Get(
     *     path="/api/events/{date_id}",
     *     summary="Get events by date id",
     *     operationId="getEventsByDateId",
     *     produces={"application/json"},
     *     description="Returns every events for the given date id",
     *     @SWG\Parameter(
     *          name="date_id",
     *          in="path",
     *          type="integer",
     *          description="This need a date id. It can take the value between 1 and 11, and 26 and 31"
     *     ),
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
     *          @Model(type=Event::class)
     *     )
     * )
     */
    public function getEventsByDateId(Request $request) {
        $eventRepo = $this->getDoctrine()->getRepository(Event::class);
        $events = $eventRepo->findBy(["dateId" => $request->get("date_id")]);

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
     * @param Request $request
     *
     * @Route(name="CountEventsByDistrict", path="api/events/count/district", methods={"GET"})
     * @SWG\Get(
     *     path="/api/events/count/district/",
     *     summary="Get number of events for a district",
     *     operationId="getCountEventsByDistrict",
     *     produces={"application/json"},
     *     @SWG\Response(
     *          response="200",
     *          description="Success"
     *     )
     * )
     *
     * @return Response
     */
    public function getCountEventsByDistrict(Request $request)
    {
        $eventPlaceRepository = $this->getDoctrine()->getRepository(Event::class);

        $numberOfDistricts = 20;
        $data = array();

        $olympicsDuration = 16;
        $day = 26;

        $defaultEvent = array();
        for ($i=0 ; $i <= $olympicsDuration ; $i++) {
            if ($day == 32) {
                $day = 1;
            }
            $defaultEvent[$i] = ["events" => "0", "date_id" => "".$day];
            $day++;
        }

        for ($i=1 ; $i <= $numberOfDistricts ; $i++) {
            $events = $eventPlaceRepository->findCountForEveryDate($i);
            $districtFrontId = "d".$i;

            $events = array_replace($defaultEvent, $events);

            $districtData = ["district" => $districtFrontId, "days" => $events];
            array_push($data, $districtData);
        }

        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonContent, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }
}
