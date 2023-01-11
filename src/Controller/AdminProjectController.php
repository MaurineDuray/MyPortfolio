<?php

namespace App\Controller;

use App\Entity\Projects;
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

class AdminProjectController extends AbstractController
{
    /**
     * Permet d'afficher la page avec la liste des projets (administration)
     *
     * @param ProjectsRepository $repo
     * @return Response
     */
    #[Route('/projects', name:'show_projects')]
    public function showProjects(ProjectsRepository $repo):Response
    {
        $projects = $repo->findBy(["category"=>"Retouche photo"], null, null, null);

        return $this->render('admin/portfolio/show.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * Permet d'ajouter un nouveau projet au portfolio
     *
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param CategoryRepository $repo
     * @param TechnicsRepository $req
     * @return Response
     */
    #[Route('/projects/new', name:'new_project')]
    public function addProject(Request $request, EntityManagerInterface $manager, CategoryRepository $repo, TechnicsRepository $req ):Response
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
            'myform'=> $form->createView(),
           
        ]);

    }
}
