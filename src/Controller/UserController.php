<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Entity\PasswordUpdate;
use App\Form\ChangePasswordType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function profile(User $user): Response
    {

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit")
     */
    public function edit(Request $request, User $userConnected): Response
    {
        $id = $userConnected->getId();

        $form = $this->createForm(UserProfileType::class, $userConnected);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
            $user = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', ['id' => $id]);

            //message add flash de confirmation
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }

    /**
     * 
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/{id}/passwordUpdate", name="update_password")
     */
    public function updateUserPassword(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $user = $this->getUser();
        $id = $this->getUser()->getId();

        $passwordUpdate = new PasswordUpdate;

        $form = $this->createForm(ChangePasswordType::class, $passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Verify if the current password match with the one sent
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                // error message
                $form->get('old_password')->addError(new FormError("Le mot de passe n'est pas bon."));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $passwordHasher->hashPassword($user, $newPassword);

                $user->setPassword($password);

                $manager->persist($user);
                $manager->flush();
                return $this->redirectToRoute('profile', ['id' => $id]);
            }
        }

        return $this->render('security/update_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete")
     */
    public function delete(User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
