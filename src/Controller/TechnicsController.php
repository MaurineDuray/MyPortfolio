<?php

namespace App\Controller;

use App\Entity\Technics;
use App\Form\TechnicsType;
use App\Repository\TechnicsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TechnicsController extends AbstractController
{
    #[Route('/technics/', name: 'technics')]
    public function index(TechnicsRepository $repo): Response
    {
        $technics = $repo->findAll();

        return $this->render('admin/technics/index.html.twig', [
            'technics' => $technics,
        ]);
    }

    #[Route('/technics/add', name:'add_technic')]
    public function addCategory(Request $request, EntityManagerInterface $manager):Response
    {
        $technic = new Technics();

        $form = $this->createForm(TechnicsType::class, $technic);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager -> persist($technic);
            $manager -> flush();

            return $this->redirectToRoute('technics',
            [
                'technic'=>$technic->getTechnic()
            ]);

        }

        return $this->render('admin/technics/addTechnic.html.twig', [
            'myform'=>$form->createView()
        ]);


    }
}
