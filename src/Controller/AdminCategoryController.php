<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Game;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/admin/category")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category_index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repository->findall();

        return $this->render('admin/index.html.twig', [
            'categories' => $categories,
            'date' => new \DateTime('now')
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_show")
     */
    public function show(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $category = $repository->findOneById($request->get('id'));

        return $this->render('admin/show.html.twig', [
            'category' => $category
        ]);
    }


    /**
     * @Route("/new/", name="admin_category_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_show', [
                'id' => $category->getId()
            ]);
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="admin_category_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Category $category)
    {
        
    }

    /**
     * @Route("/del/{id}", name="admin_category_delete")
     * @Method("GET")
     */
    public function delete(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // query for a single Category by its primary key (usually "id")
        /** @var Category $category */
        $category = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('admin_category_index');
    }
}
