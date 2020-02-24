<?php

namespace App\Controller;

use App\Entity\Sport;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SportsController extends AbstractController
{
    /**
     * @Route(name="sports", path="api/sports", methods={"GET"})
     * @SWG\Get(
     *     path="/api/sports",
     *     summary="Get sports",
     *     operationId="getSports",
     *     produces={"application/json"},
     *     description="Returns all sports",
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
     *          @Model(type=Sport::class)
     *     )
     * )
     */
    public function getSports() {
        $sportsPlaceRepo = $this->getDoctrine()->getRepository(Sport::class);
        $sportsPlaces = $sportsPlaceRepo->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($sportsPlaces, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route(
     *     name="sportById",
     *     path="api/sport/{id}",
     *     methods={"GET"}
     * )
     * @SWG\Get(
     *     path="/api/sport/{id}",
     *     summary="Get one sport",
     *     operationId="getSportById",
     *     produces={"application/json"},
     *     description="Returns sport by id",
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
                @Model(type=Sport::class)
     *     )
     * )
     */
    public function getSportById(Request $request) {
        $sportRepository = $this->getDoctrine()->getRepository(Sport::class);
        $sport = $sportRepository->findOneBy(["id" => $request->get("id")]);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($sport, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
    }
}
