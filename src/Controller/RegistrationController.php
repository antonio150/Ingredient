<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
   #[Route('/login/new', 'new_login', methods: ['GET', 'POST'])]
   public function new(
      Request $request,
      EntityManagerInterface $manager,
      UserPasswordHasherInterface $passwordHasher
   ): Response {
      $user = new User();
      $form = $this->createForm(LoginFormType::class, $user);
      $form->handleRequest($request);
      // if ($form->isSubmitted() && $form->isValid()) {
      //    $users = $form->getData();
      // dd($users);
      // hash the password (based on the security.yaml config for the $user class)
      // $hashedPassword = $passwordHasher->hashPassword(
      //    $users,
      //    $plaintextPassword
      // );
      // $user->setPassword($hashedPassword);

      // $manager->persist($users);
      // $manager->flush();
      // return $this->redirectToRoute('app_recette');
      // }
      return $this->render('pages/login/index.html.twig', [
         'form' => $form->createView()
      ]);
   }
}
