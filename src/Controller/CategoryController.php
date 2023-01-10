<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category')]
    public function index(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/add', name:'add_category')]
    public function addCategory(Request $request, EntityManagerInterface $manager):Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager -> persist($category);
            $manager -> flush();

            return $this->redirectToRoute('category',
            [
                'category'=>$category->getCategory()
            ]);

        }

        return $this->render('admin/category/addCategory.html.twig', [
            'myform'=>$form->createView()
        ]);


    }
}
