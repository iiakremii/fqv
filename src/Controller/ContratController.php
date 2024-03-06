<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContratFormType;
use App\Entity\Contrat;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContratRepository;
use Knp\Component\Pager\PaginatorInterface;

class ContratController extends AbstractController
{
    #[Route('/contrat', name: 'app_contrat_back')]
    public function index(Request $request, ContratRepository $fournisseurRepository): Response
    {
        $added = false;
        $authors=$fournisseurRepository->findAll();
        if ($request->query->get('added')) {
            $added = $request->query->get('added');
        }
         // Retrieve the 'added' variable from the request query parameters

        return $this->render('contrat/afficher_back.html.twig',
            ['authors' => $authors,
            'added' => $added,]
        );
    }


    #[Route('/contrat/fnew', name: 'app_contrat_fnew')]
    public function fnew(Request $request , EntityManagerInterface $entityManagerInterface)
    {
        $author = new Contrat();

        $form=$this->createForm(ContratFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isvalid()){
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_contrat_back',[
                "added" => true
            ]);
        }
        return $this->renderForm('contrat/ajouter_back.html.twig',['form'=>$form]);
        // dump($author);
        // die();
    }
    #[Route('/contrat/fedit/{id}', name: 'app_contrat_edit')]
    public function fedit(Request $request,$id ,EntityManagerInterface $entityManagerInterface , ContratRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $form=$this->createForm(ContratFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_contrat_back');
        }
        return $this->renderForm('contrat/modifier_back.html.twig',['form'=>$form]);
        dump($author);
        die();
    }
    #[Route('/contrat/delete/{id}', name: 'app_contrat_delete')]
    public function delete($id ,EntityManagerInterface $entityManagerInterface , ContratRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $entityManagerInterface->remove($author);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_contrat_back');
        dd($author);

    }

    #[Route('/contrat_front', name: 'app_contrat')]
    public function index1(Request $request,ContratRepository $fournisseurRepository): Response
    {
        $added = false;
        $authors=$fournisseurRepository->findAll();
        if ($request->query->get('added')) {
            $added = $request->query->get('added');
        }

        return $this->render('contrat/afficher_front.html.twig', array(
            'authors' => $authors,
            'added' => $added
        ));
    }

    #[Route('/contrat/fnew1', name: 'app_contrat_fnew1')]
    public function fnew1(Request $request , EntityManagerInterface $entityManagerInterface)
    {
        $author = new Contrat();

        $form=$this->createForm(ContratFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isvalid()){
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_contrat', [
                'added' => true
            ]);
        }
        return $this->renderForm('contrat/ajouter_front.html.twig',['form'=>$form]);
        // dump($author);
        // die();
    }
    #[Route('/contrat/fedit1/{id}', name: 'app_contrat_edit1')]
    public function fedit1(Request $request,$id ,EntityManagerInterface $entityManagerInterface , ContratRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $form=$this->createForm(ContratFormType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManagerInterface->persist($author);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_contrat');
        }
        return $this->renderForm('contrat/modifier_front.html.twig',['form'=>$form]);
        dump($author);
        die();
    }
    #[Route('/contrat/delete1/{id}', name: 'app_contrat_delete1')]
    public function delete1($id ,EntityManagerInterface $entityManagerInterface , ContratRepository $authorRepository)
    {
        $author = $authorRepository->find($id);
        $entityManagerInterface->remove($author);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('app_contrat');
        dd($author);

    }
}
