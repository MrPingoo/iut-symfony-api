<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Game;
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
            'categories' => $categories
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
     * @Route("/", name="admin_category_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
    {

    }


    /**
     * @Route("/edit/{id}", name="admin_category_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request)
    {

    }

    /**
     * @Route("/{id}", name="admin_category_delete")
     * @Method("POST")
     */
    public function delete(Request $request)
    {

    }
}
