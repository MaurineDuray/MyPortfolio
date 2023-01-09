<?php

namespace App\Controller;

use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(SkillsRepository $repo): Response
    {
        $skills = $repo->findAll();

        return $this->render('index.html.twig', [
            'skills' => $skills,
        ]);
    }
}
