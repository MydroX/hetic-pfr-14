<?php

namespace App\Controller;

use App\Entity\EventPlace;
use App\Entity\Sport;
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
//    /**
//     * @Route(
//     *     name="sports",
//     *     path="/sports",
//     *     methods={"GET"}
//     * )
//     * @return Response
//     */
//    public function getSports() {
//        $sportsPlaceRepo = $this->getDoctrine()->getRepository(Sport::class);
//        $sportsPlaces = $sportsPlaceRepo->findAll();
//
//        $encoders = [new XmlEncoder(), new JsonEncoder()];
//        $normalizers = [new ObjectNormalizer()];
//        $serializer = new Serializer($normalizers, $encoders);
//
//        $jsonObject = $serializer->serialize($sportsPlaces, 'json', [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]);
//        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
//    }
//
//    /**
//     * @Route(
//     *     name="sportById",
//     *     path="/sports/{id}",
//     *     methods={"GET"}
//     * )
//     * @return Response
//     */
//    public function getSportById(Request $request) {
//        $sportPlaceRepo = $this->getDoctrine()->getRepository(Sport::class);
//        $sport = $sportPlaceRepo->findOneBy(["id" => $request->get("id")]);
//
//        $encoders = [new XmlEncoder(), new JsonEncoder()];
//        $normalizers = [new ObjectNormalizer()];
//        $serializer = new Serializer($normalizers, $encoders);
//
//        $jsonObject = $serializer->serialize($sport, 'json', [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]);
//        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
//    }
}
