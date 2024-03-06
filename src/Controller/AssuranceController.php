<?php

namespace App\Controller;
require_once __DIR__.'/../../vendor/autoload.php';
use App\Entity\Assurance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AssuranceFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AssuranceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class AssuranceController extends AbstractController
{
    #[Route('/detailassurance/{id}', name: 'app_part_detail')]
    public function fedit3($id, EntityManagerInterface $entityManager,AssuranceRepository $entrepriseRepository)
    {
        $entreprise = $entrepriseRepository->find($id);

        // Vérifiez si l'entreprise existe
        if (!$entreprise) {
            throw $this->createNotFoundException('Entreprise non trouvée');
        }

        return $this->render('assurance/details.html.twig', [
            'author' => $entreprise,
        ]);
    }



    #[Route('/assurance', name: 'app_assurance')]
    public function index(AssuranceRepository $fournisseurRepository): Response
    {
        $authors=$fournisseurRepository->findAll();

        return $this->render('assurance/afficher_back.html.twig', array(
            'authors' => $authors,

        ));
    }



    #[Route('/assurance_front', name: 'app_assurance_front')]

    public function indexFront(AssuranceRepository $assuranceRepository): Response
    {
        $authors = $assuranceRepository->findAll();

        return $this->render('assurance/afficher_front.html.twig', [
            'authors' => $authors,
        ]);
    }


    #[Route('/assurance/fnew', name: 'app_assurance_fnew')]
    public function fnew(Request $request , EntityManagerInterface $entityManagerInterface)
    {
        $author = new Assurance();

        $form=$this->createForm(AssuranceFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isvalid()){
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_assurance');
        }

        return $this->renderForm('assurance/ajouter_back.html.twig',['form'=>$form]);
        // dump($author);
        // die();
    }
    #[Route('/assurance/fedit/{id}', name: 'app_assurance_edit')]
    public function fedit(Request $request,$id ,EntityManagerInterface $entityManagerInterface , AssuranceRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $form=$this->createForm(AssuranceFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_assurance');
        }
        return $this->renderForm('assurance/modifier_back.html.twig',['form'=>$form]);
        dump($author);
        die();
    }
    #[Route('/assurance/delete/{id}', name: 'app_assurance_delete')]
    public function delete($id ,EntityManagerInterface $entityManagerInterface , AssuranceRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $entityManagerInterface->remove($author);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_assurance');
        dd($author);

    }

    #[Route('/assurances/favorites', name: 'app_assurances_favorites')]
    public function favoriteAssurances(): Response
    {
        // Récupérer les assurances favorites depuis la base de données
        $favoriteAssurances = $this->getDoctrine()->getRepository(Assurance::class)->findBy(['favoris' => true]);

        // Passer les données à votre template Twig
        return $this->render('assurance/favorites.html.twig', [
            'favoriteAssurances' => $favoriteAssurances,
        ]);
    }

    #[Route('/assurance/{id}/toggle-favorite', name: 'app_assurance_toggle_favorite')]
    public function toggleFavorite(Request $request, Assurance $assurance): JsonResponse
    {
        // Récupérer l'état actuel des favoris de l'assurance
        $isFavorite = $assurance->isFavoris();

        // Inverser l'état des favoris
        $assurance->setFavoris(!$isFavorite);

        // Enregistrer les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($assurance);
        $entityManager->flush();

        // Retourner une réponse JSON indiquant le nouvel état des favoris
        return new JsonResponse(['success' => true, 'isFavorite' => !$isFavorite]);
    }

    #[Route('/assurance/remove_favorite/{id}', name: 'app_assurance_remove_favorite')]
    public function removeFavorite(Request $request, $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($id);

        if (!$assurance) {
            return new JsonResponse(['success' => false, 'message' => 'Assurance non trouvée']);
        }

        // Retirer l'assurance des favoris
        $assurance->setFavoris(false);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'isFavorite' => false]);
    }

    #[Route('/assurance/marquer_favorite/{id}', name: 'app_assurance_marquer_favorite')]
    public function marquerFavorite(Request $request, $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($id);
        $assurance->setFavoris(true);
        $entityManager->flush();
        // Vous pouvez retourner une réponse JSON si nécessaire


        return new JsonResponse(['success' => true, 'isFavorite' => true]);
    }
}
