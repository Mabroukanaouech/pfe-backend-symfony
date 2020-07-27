<?php

namespace App\Controller\Api\Open;

use App\Doctrine\Entity\Publicity;
//use App\Doctrine\Entity\Image;
use App\Doctrine\Form\PublicityType;
use App\Doctrine\Repository\PublicityRepository;
use App\Doctrine\Repository\CategoryRepository;
use App\Doctrine\Entity\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Doctrine\Repository\UserRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;
/**
 * @Route("/publicity")
 */
class PublicityController extends AbstractController
{
       /**
     * @Route("/", name="publicity_index", methods={"GET"})
     * @param PublicityRepository $publicityRepository
     * @return JsonResponse|RedirectResponse
     */
public function index(PublicityRepository $publicityRepository): Response
{
    //AnnonceRepository $annonceRepository
//        return $this->render('annonce/index.html.twig', [
//            'annonces' => $annonceRepository->findAll(),
//        ]);
    $publicitys = $this->getDoctrine()->getRepository(Publicity::class)->findAll();
    $encoders = [new JsonEncoder()];
    $normalizers = [new DateTimeNormalizer(),new ObjectNormalizer()];
    $serializer = new Serializer($normalizers, $encoders);
    $jsonContent = $serializer->serialize($publicitys, 'json'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ,[
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);
    $response = new Response($jsonContent);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
}

    /**
     * @Route("/new", name="publicity_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $publicity = new Publicity();
        $form=$this->createForm(PublicityType::class,$publicity,['csrf_protection' => false]);
        $form->handleRequest($request);
        $form->submit($request->request->all());
        $ctgry = $request->request->get('category');
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $ctgry]);
       // $data = $request->request->all();
        //die(var_dump($data));
      // dump($data);die;
        if (!$form->isValid()) {
           Response::HTTP_EXPECTATION_FAILED;
        }
        $uploadedImage = $request->files->get('image');
       // $uploadedImage = $publicity->getImage()->getFile();
        /**
         * @var UploadedFile $file
         */
        $file = $uploadedImage;
        $imageName = md5(uniqid('', true)) . '.' . $file->guessExtension();
        $file->move($this->getParameter('image_directory'), $imageName);
       // $img = new Image();
       $publicity->setCategory($category);
        
        $publicity->setImage($imageName);
        $manager->persist($publicity);
        $manager->flush();
        return new JsonResponse(
            [
                'status' => 'created',
                'code' => 200
            ],
            JsonResponse::HTTP_CREATED
        );
    
       /* $manager = $this->getDoctrine()->getManager();
        $publicity = new Publicity();
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create(PublicityType::class, $publicity, ['csrf_protection' => false]);
        $form->handleRequest($request);
        $form->submit(json_decode($request->getContent(), true), false);
        if (!$form->isValid()) {
            //Exception
            JsonResponse::HTTP_FAILED_DEPENDENCY;
        }
        $manager->persist($publicity);
        $manager->flush();
        return new JsonResponse('ok',JsonResponse::HTTP_CREATED);*/

       /* $publicity = new Publicity();
        $form = $this->createForm(PublicityType::class, $publicity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicity);
            $entityManager->flush();

            return $this->redirectToRoute('publicity_index');
        }

        return $this->render('publicity/new.html.twig', [
            'publicity' => $publicity,
            'form' => $form->createView(),
        ]);*/
    }

/**
     * @Route("/{id}", name="publicity_show", methods={"GET"})
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */

    public function show(Request $request): Response
    {
        $publicity = $this->getDoctrine()->getRepository(Publicity::class)->find($request->get('id'));
        if (!$publicity) {
            return new Response('not found');
        }else {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($publicity, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
            $response = new Response($jsonContent);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
       // return $this->render('publicity/show.html.twig', [
           // 'publicity' => $publicity,
      //  ]);
    }

    /**
     * @Route("/{id}/edit", name="publicity_edit", methods={"POST"})
     */
    public function edit(Request $request, Publicity $publicity): Response
    {
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create(PublicityType::class, $publicity, ['csrf_protection' => false]);
        $form->handleRequest($request);
        $form->submit(json_decode($request->getContent(), true), false);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            //Exception
        }
        return new JsonResponse('ok');

//        $form = $this->createForm(PublicityType::class, $publicity);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('publicity_index');
//        }
//
//        return $this->render('publicity/edit.html.twig', [
//            'publicity' => $publicity,
//            'form' => $form->createView(),
//        ]);
    }

    /**
     * @Route("/{id}", name="publicity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publicity $publicity): Response
   {
        if (!$publicity) {
            return new Response('not found');
        }else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicity);
            $entityManager->flush();
            return new Response('ok');
        }

//        if ($this->isCsrfTokenValid('delete'.$publicity->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($publicity);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('publicity_index');
    }
}
