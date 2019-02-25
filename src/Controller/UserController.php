<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 24/02/2019
 * Time: 19:20
 */

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

class ApiLogin extends AbstractController
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
}