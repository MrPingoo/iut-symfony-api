<?php

namespace App\Controller;

use App\Entity\Category;
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
 * @Route("/api/game")
 */
class ApiGameController extends AbstractController
{

    /**
     * Create a Game.
     * @FOSRest\Post("/")
     *
     * @return array
     */
    public function creat(Request $request)
    {
        $game = new Game();

        $date = new \DateTime($request->get('date'));
        $game->setDate($date);
        $game->setPrice($request->get('price'));
        $game->setPicture($request->get('picture'));
        $date = new \DateTime($request->get('release_date'));
        $game->setReleaseDate($date);
        $game->setTitle($request->get('title'));
        $game->setDesciption($request->get('description'));
        $game->setVideo($request->get('video'));
        $game->setExternalSite($request->get('external_site'));
        $game->setStoreLink($request->get('store_link'));

        // Find the user by this ID
        $user_id = $request->get('author');
        if (!empty($user_id)) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            /** @var User $user */
            $user = $repository->findOneById($user_id);

            // Set User object
            $game->setAuthor($user);
        }

        // Find all categories
        $category_id = $request->get('category');
        if (!empty($category_id)) {
            $repository = $this->getDoctrine()->getRepository(Category::class);
            $category = $repository->findOneById($category_id);
            // Set Categories
            $game->setCategory($category);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($game);
        $em->flush();

        return View::create($game, Response::HTTP_CREATED, []);
    }

    /**
     * Lists all Games.
     * @FOSRest\Get("/")
     *
     * @return array
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);

        $games = $repository->findall();

        return View::create($games, Response::HTTP_OK, []);
    }


    /**
     * Get a Game.
     * @FOSRest\Get("/{id}")
     *
     * @return array
     */
    public function show(Game $game)
    {
        $repository = $this->getDoctrine()->getRepository(Stars::class);
        $moy = $repository->countNumberByGame($game);

        $game->setCount(ceil($moy['total'] / $moy['count']));

        return View::create($game, Response::HTTP_OK, []);
    }

    /**
     * Delete a Game.
     * @FOSRest\Delete("/{id}")
     *
     * @return array
     */
    public function delete(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);

        // query for a single Game by its primary key (usually "id")
        /** @var User $user */
        $game = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($game);
        $em->flush();

        $games = $repository->findall();

        return View::create($games, Response::HTTP_OK, []);
    }

    /**
     * Update a Game.
     * @FOSRest\Post("/{id}")
     *
     * @return array
     */
    public function update(Request $request, Game $game)
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);

        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime($request->get('date'));
        $game->setDate($date);
        $game->setPrice($request->get('price'));
        $game->setPicture($request->get('picture'));
        $date = new \DateTime($request->get('release_date'));
        $game->setReleaseDate($date);
        $game->setTitle($request->get('title'));
        $game->setDesciption($request->get('description'));
        $game->setVideo($request->get('video'));
        $game->setExternalSite($request->get('external_site'));
        $game->setStoreLink($request->get('store_link'));

        // Find the user by this ID
        $user_id = $request->get('author');
        if (!empty($user_id)) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            /** @var User $user */
            $user = $repository->findOneById($user_id);

            // Set User object
            $game->setAuthor($user);
        }

        // Find all categories
        $category_id = $request->get('category');
        if (!empty($category_id)) {
            $repository = $this->getDoctrine()->getRepository(Category::class);
            $category = $repository->findOneById($category_id);
            // Set Categories
            $game->setCategory($category);
        }

        $em->persist($game);
        $em->flush();

        $repository = $this->getDoctrine()->getRepository(Game::class);

        $games = $repository->findall();

        return View::create($games, Response::HTTP_OK, []);
    }

}
