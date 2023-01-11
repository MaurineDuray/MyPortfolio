<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Entity\Technics;
use App\Form\ProjectsType;
use App\Repository\CategoryRepository;
use App\Repository\ProjectsRepository;
use App\Repository\TechnicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProjectsController extends AbstractController
{

    /**
     * Permet l'affichage des projets sur la page portfolio du site
     *
     * @param ProjectsRepository $repo
     * @return Response
     */
    #[Route('/portfolio', name: 'portfolio')]
    public function index(ProjectsRepository $repo): Response
    {
        $projects = $repo->findAll();

        return $this->render('portfolio/index.html.twig', [
            'projects' => $projects,
        ]);
    }

   
}
