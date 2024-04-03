<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecetteController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param RecetteRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    #[Route('/recette', name: 'app_recette', methods: ["GET"])]
    public function index(RecetteRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $recettes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt("page", 1),
            10
        );
        return $this->render('pages/recette/index.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/recette/creation', 'recette_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();
            // dd($recette);
            $manager->persist($recette);
            $manager->flush();
            return $this->redirectToRoute('app_recette');
        }
        return $this->render('pages/recette/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/recette/edition/{id}', 'recette_edit', methods: ['POST', 'GET'])]
    public function edit(
        Recette $recette,
        Request $request,
        EntityManagerInterface $manager
    ) {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();
            $manager->persist($recette);
            $manager->flush();
            return $this->redirectToRoute('app_recette');
        }
        return $this->render('pages/recette/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/recette/suppression/{id}', 'recette_delete', methods: ['POST', 'GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Recette $recette
    ) {
        $manager->remove($recette);
        $manager->flush();
        return $this->redirectToRoute('app_recette');
    }
}
