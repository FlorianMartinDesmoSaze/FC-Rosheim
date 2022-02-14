<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 * 
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="profile")
     */
    public function profile(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        if (! $user) {
            throw $this->createNotFoundException('The user '. $id . ' does not exist');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
