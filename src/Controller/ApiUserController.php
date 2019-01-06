<?php

namespace App\Controller;

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
 * @Route("/api/user")
 */
class ApiUserController extends AbstractController
{
    /**
     * Create a User.
     * @FOSRest\Post("/")
     *
     * @return array
     */
    public function creat(Request $request)
    {
        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setLastname($request->get('lastname'));
        $user->setFirstname($request->get('firstname'));
        $user->setGoogleId($request->get('googleid'));
        $user->setGroups($request->get('groups'));
        $user->setPassword($request->get('password'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED, []);
    }

    /**
     * Lists all Users.
     * @FOSRest\Get("/")
     *
     * @return array
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $users = $repository->findall();

        return View::create($users, Response::HTTP_OK, []);
    }


    /**
     * Get a User.
     * @FOSRest\Get("/{id}")
     *
     * @return array
     */
    public function show(User $user)
    {
        return View::create($user, Response::HTTP_OK, []);
    }

    /**
     * Delete a User.
     * @FOSRest\Delete("/{id}")
     *
     * @return array
     */
    public function delete(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        // query for a single Category by its primary key (usually "id")
        /** @var User $user */
        $user = $repository->findOneById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $users = $repository->findall();

        return View::create($users, Response::HTTP_OK, []);
    }

    /**
     * Update a User.
     * @FOSRest\Post("/{id}")
     *
     * @return array
     */
    public function update(Request $request, User $user)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);

        $em = $this->getDoctrine()->getManager();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setLastname($request->get('lastname'));
        $user->setFirstname($request->get('firstname'));
        $user->setGoogleId($request->get('googleid'));
        $user->setGroups($request->get('groups'));
        $user->setPassword($request->get('password'));
        $em->persist($user);
        $em->flush();

        $users = $repository->findall();

        return View::create($users, Response::HTTP_OK, []);
    }

}
