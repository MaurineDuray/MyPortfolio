<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProjectsController extends AbstractController
{
    #[Route('/portfolio', name: 'portfolio')]
    public function index(ProjectsRepository $repo): Response
    {
        $projects = $repo->findAll();

        return $this->render('portfolio/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects', name:'show_projects')]
    public function showProjects(ProjectsRepository $repo):Response
    {
        $projects = $repo->findAll();

        return $this->render('admin/portfolio/show.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/new', name:'new_project')]
    public function addProject(Request $request, EntityManagerInterface $manager ):Response
    {
        $projet  = new Projects();

        $form = $this->createForm(ProjectsType::class, $projet);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $file = $form['cover']->getData();
            if(!empty($file)){
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin;Latin-ASCII;[^A-Za-z0-9_]remove;Lower()', $originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . "." . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $e->getMessage();
                }
                $projet->setCover($newFilename);
            }

            $manager->persist($projet);
            $manager->flush();

            return $this->redirectToRoute('portfolio', [
                'projets' => $projet->getTitle()
            ]);
            
        }

        return $this->render('admin/portfolio/newProject.html.twig', [
            'myform'=> $form->createView()
        ]);

    }
}
