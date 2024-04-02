<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_security', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    #[Route('/deconnexion', 'security_logout')]
    public function logout()
    {
    }

    #[Route('/inscription', 'security_registration', methods: ["GET", "POST"])]
    public function registration(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $users = $form->getData();
            $plainPasswd = $users->getPlainPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainPasswd
            );
            $user->setPassword($hashedPassword);

            $this->addFlash(
                'success',
                'votre classe a été crée'
            );
            $manager->persist($users);
            $manager->flush();
            return $this->redirectToRoute('app_security');
        }

        return $this->render('pages/security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
