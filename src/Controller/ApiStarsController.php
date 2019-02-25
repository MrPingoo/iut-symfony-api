<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Stars;
use App\Entity\User;
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
 * @Route("/api/stars")
 */
class ApiStarsController extends AbstractController
{
    /**
     * Create a Stars.
     * @FOSRest\Post("/")
     *
     * @return array
     */
    public function create(Request $request)
    {
        $star = new Stars();

        // Find all categories
        $game_id = $request->get('game');
        if (!empty($game_id)) {
            $repository = $this->getDoctrine()->getRepository(Game::class);
            $game = $repository->findOneById($game_id);
            // Set Categories
            $star->setGame($game);
        }

        $star->setUser($this->getUser());

        $date = new \DateTime('now');
        $star->setDate($date);
        $star->setStar($request->get('star'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($star);
        $em->flush();

        return View::create($star, Response::HTTP_CREATED, []);
    }

    /**
     * Lists all Stars.
     * @FOSRest\Get("/")
     *
     * @return array
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Stars::class);

        $stars = $repository->findall();

        return View::create($stars, Response::HTTP_OK, []);
    }


    /**
     * Get a Stars.
     * @FOSRest\Get("/{id}")
     *
     * @return array
     */
    public function show(Game $game)
    {
        // Ici moyenne des notes

        return View::create($game, Response::HTTP_OK, []);
    }

    /**
     * Delete a Stars.
     * @FOSRest\Delete("/{id}")
     *
     * @return array
     */
    public function delete(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Stars::class);

        // query for a single Category by its primary key (usually "id")
        /** @var Stars $user */
        $star = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($star);
        $em->flush();

        $stars = $repository->findall();

        return View::create($stars, Response::HTTP_OK, []);
    }
}
