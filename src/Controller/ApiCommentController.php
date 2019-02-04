<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Game;
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
 * @Route("/api/comment")
 */
class ApiCommentController extends AbstractController
{
    /**
     * Create a Comment.
     * @FOSRest\Post("/")
     *
     * @return array
     */
    public function create(Request $request)
    {
        $comment = new Comment();

        $date = new \DateTime('now');
        $comment->setDate($date);
        $comment->setComment($request->get('comment'));

        // Find all categories
        $game_id = $request->get('game');
        if (!empty($game_id)) {
            $repository = $this->getDoctrine()->getRepository(Game::class);
            $game = $repository->findOneById($game_id);
            // Set Categories
            $comment->setGame($game);
        }

        // Find all categories
        $user_id = $request->get('user');
        if (!empty($game_id)) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneById($user_id);
            // Set Categories
            $comment->setUser($user);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return View::create($comment, Response::HTTP_CREATED, []);
    }

    /**
     * Lists all Comment.
     * @FOSRest\Get("/")
     *
     * @return array
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);

        $comments = $repository->findall();

        return View::create($comments, Response::HTTP_OK, []);
    }


    /**
     * Get a Comment.
     * @FOSRest\Post("/game/")
     *
     * @return array
     */
    public function show(Request $request)
    {
        $repositoryComment = $this->getDoctrine()->getRepository(Comment::class);
        $repositoryGame = $this->getDoctrine()->getRepository(Game::class);

        $game = $repositoryGame->findOneById($request->get('game'));

        $comments = $repositoryComment->findByGameWithRowsAndOffset($game, $request->get('rows'), $request->get('offset'), $request->get('sorting'));

        return View::create($comments, Response::HTTP_OK, []);
    }

    /**
     * Delete a Comment.
     * @FOSRest\Delete("/{id}")
     *
     * @return array
     */
    public function delete(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);

        // query for a single Category by its primary key (usually "id")
        /** @var User $user */
        $comment = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        $comments = $repository->findall();

        return View::create($comments, Response::HTTP_OK, []);
    }

}
