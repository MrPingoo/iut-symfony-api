<?php

namespace App\Controller;

use App\Entity\Category;
use FOS\RestBundle\FOSRestBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/api/category")
 */
class ApiCategoryController extends AbstractController
{
    /**
     * Create Category.
     * @FOSRest\Post("/")
     *
     * @return array
     */
    public function postCategory(Request $request)
    {
        $category = new Category();
        $category->setName($request->get('name'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return View::create($category, Response::HTTP_CREATED, []);
    }

    /**
     * Lists all Category.
     * @FOSRest\Get("/")
     *
     * @return array
     */
    public function getCategory()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repository->findall();

        return View::create($categories, Response::HTTP_OK, []);
    }


    /**
     * Delete a Category.
     * @FOSRest\Delete("/{id}")
     *
     * @return array
     */
    public function deleteCategory(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // query for a single Category by its primary key (usually "id")
        /** @var Category $category */
        $category = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $categories = $repository->findall();

        return View::create($categories, Response::HTTP_OK, []);
    }

    /**
     * Update a Category.
     * @FOSRest\Post("/{id}")
     *
     * @return array
     */
    public function putCategory(Request $request, Category $category)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $em = $this->getDoctrine()->getManager();
        $name = $request->get('name');
        $category->setName($name);
        $em->persist($category);
        $em->flush();

        $categories = $repository->findall();

        return View::create($categories, Response::HTTP_OK, []);
    }

}
