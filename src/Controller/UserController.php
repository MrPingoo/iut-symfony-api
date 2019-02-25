<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 24/02/2019
 * Time: 19:20
 */

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\FOSRestBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * Create a User.
     * @FOSRest\Post("/user/login")
     *
     * @return array
     */
    public function login(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $repository = $this->getDoctrine()->getRepository(User::class);

        // query for a single Category by its primary key (usually "id")
        /** @var User $user */
        $user = $repository->findOneByUsername($username);

        if ($encoder->isPasswordValid($user, $password)) {
            return View::create($user, Response::HTTP_CREATED, []);
        }

        return View::create([], Response::HTTP_NOT_FOUND, []);
    }

    /**
     * Create a User.
     * @FOSRest\Post("/user/register")
     *
     * @return array
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {

        // whatever *your* User object is
        $user = new User();
        $encoded = $encoder->encodePassword($user, $request->get('password'));
        $user->setPassword($encoded);
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setLastname($request->get('lastname'));
        $user->setFirstname($request->get('firstname'));
        $user->setGoogleId($request->get('googleid'));
        $user->setGroups($request->get('groups'));
        $user->setRoles($request->get('groups'));
        $user->setApiKey(md5(uniqid()));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED, []);
    }
}