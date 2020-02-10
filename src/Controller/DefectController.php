<?php

namespace App\Controller;

use App\Entity\Defect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Json;

class DefectController extends AbstractController
{
    /**
     * @Route("/defects", name="defects", methods={"GET"})
     */
    public function index()
    {
        $defectsRepository = $this->getDoctrine()->getRepository(Defect::class);
        $defects = $defectsRepository->get200LastDefects();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($defects, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
