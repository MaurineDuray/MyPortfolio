<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\AddSkillsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SkillsController extends AbstractController
{
    #[Route('/skills/', name: 'index_skills')]
    public function index(): Response
    {
        return $this->render('admin/skills/index.html.twig', [
            'controller_name' => 'SkillsController',
        ]);
    }

    #[Route('/skills/new', name:'add_skills')]
    public function addSkills(Request $request, EntityManagerInterface $manager): Response
    {
        $skills = new Skills();

        $form = $this->createForm(AddSkillsType::class, $skills);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form-> isValid()){
            // Gestion de l'image
            $file = $form['image']->getData();
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
                $skills->setImage($newFilename);
            } 
            
            $manager->persist($skills);
            $manager->flush();
            
        
        

        $this->addFlash(
            'success',
            "L'annonce <strong>{$skills->getSkill()}</strong> a bien été enregistrée!"
        );

        return $this->redirectToRoute('index_skills', [
            'skills' => $skills->getSkill()
        ]);
        }

        return $this->render('admin/skills/addSkills.html.twig', [
            'myform'=> $form->createView()
        ]);
    
}
}