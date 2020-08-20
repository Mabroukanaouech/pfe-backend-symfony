<?php

namespace App\Controller\Api\Open;
use App\Doctrine\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Doctrine\Form\CompteType;
use App\Doctrine\Repository\CompteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Doctrine\Repository\UserRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;
/**
 * @Route("/compte")
 */

class CompteController extends AbstractController
{   
    
    /**
    * @Route("/new", name="Compte_new", methods={"POST"})
    */
   public function new(Request $request): Response
   {
    $manager = $this->getDoctrine()->getManager();
    $compte = new Compte();
    $form=$this->createForm(CompteType::class,$compte,['csrf_protection' => false]);
    $form->handleRequest($request);
    $form->submit($request->request->all());
    $manager->persist($compte);
    $manager->flush();

  
  

    return new JsonResponse(
        [
            'status' => 'created',
            'code' => 200
        ],
        JsonResponse::HTTP_CREATED
    );

}

    /**
     * @Route("/", name="compte_index", methods={"GET"})
     */
    public function index()
    {$comptes = $this->getDoctrine()->getRepository(Compte::class)->findAll();
        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(),new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($comptes, 'json'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ,[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

   /**
     * @Route("/{id}", name="compte_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        $compte = $this->getDoctrine()->getRepository(Compte::class)->find($request->get('id'));
        if (!$compte) {
            return new Response('not found');
        }else {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($compte, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
            $response = new Response($jsonContent);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

}
