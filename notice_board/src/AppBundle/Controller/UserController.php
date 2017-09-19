<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Route("/user")
 *
 */
class UserController extends Controller
{
    /**
     * @Route("/register")
     */
    public function registerUserAction()
    {
        return $this->render('user_register.html.twig');
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        $user = $this->getUser();
        if($user->hasRole('ROLE_ADMIN')){
            return $this->render('admin/admin.html.twig');
        }

    }

}
