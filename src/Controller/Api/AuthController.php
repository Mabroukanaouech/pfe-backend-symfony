<?php
/**
 * Copyright (C) KOCHTI, Inc - All Rights Reserved
 *
 * This file is part of the point_cash_api
 * Created by  KOCHTI AYMEN
 * @author <kochti.aymen.ing@gmail.com>
 * 2/25/20
 * 3:37 PM
 *
 * For the full copyright and license information, please view the LICENSE
 */


namespace App\Controller\Api;

use App\Doctrine\Entity\User;
use Exception;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/register", name="api_auth_register",  methods={"POST"})
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @return JsonResponse|RedirectResponse
     */
    public function register(Request $request, UserManagerInterface $userManager)
    {
        // TODO: validation and data handling for user creation should be decoupled from the controller
        $data = json_decode(
            $request->getContent(),
            true
        );
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection(array(
            // the keys correspond to the keys in the input array
            'username' => new Assert\Length(array('min' => 1)),
            'password' => new Assert\Length(array('min' => 1)),
            'email' => new Assert\Email(),
        ));
        $violations = $validator->validate($data, $constraint);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
        $user = new User();
        $user
            ->setUsername($username)
            ->setPlainPassword($password)
            ->setEmail($email)
            ->setEnabled(true)
            ->setRoles(['ROLE_USER'])
            ->setSuperAdmin(false);
        try {
            $userManager->updateUser($user);
        } catch (Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

        # Code 307 preserves the request method, while redirectToRoute() is a shortcut method.
        return $this->redirectToRoute('auth_login', [
            'username' => $data['username'],
            'password' => $data['password']
        ], 307);
    }
}
