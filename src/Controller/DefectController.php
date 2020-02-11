<?php

namespace App\Controller;

use App\Entity\Defect;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefectController extends AbstractController
{
    /**
     * @Route("/api/defects", methods={"GET"})
     * @SWG\Get(
     *     path="/api/defects",
     *     summary="Get defects",
     *     operationId="getDefects",
     *     produces={"application/json"},
     *     description="Returns the 200 last defects",
     *     @SWG\Response(
     *          response="200",
     *          description="Success",
     *          @SWG\Schema(
     *              @SWG\Items(ref=@Model(type=Defect::class, groups={"full"}))
     *          )
     *     )
     * )
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
