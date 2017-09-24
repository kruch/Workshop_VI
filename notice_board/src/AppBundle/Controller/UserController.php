<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Exception\Exception;


/**
 * @Route("/user")
 *
 */
class UserController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        $user = $this->getUser();
        if($user->hasRole('ROLE_ADMIN')){
            return $this->render('admin/admin.html.twig');
        }else{
            return $this->redirectToRoute('app_notice_showall');
        }
    }

    /**
     * @Route("/profile/edit")     *
     */
    public function editUserAction()
    {
        $user=$this->getUser();
        if(!$user){
            throw $this->createNotFoundException("can't find your stupid post...");
        }
        return ['user'=>$user];
    }

    /**
     * @Route("/admin/all_users")
     * @Template("admin/admin_users.html.twig")
     */
    public function adminEditUsersAction()
    {
        $users=$this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if(!$users){
            throw $this->createNotFoundException('no users registered ;<');
        }
        return ['users'=>$users];
    }

    /**
     * @Route("/admin/edit_notices")
     * @Template("admin/admin_notice.html.twig")
     */
    public function adminEditNoticesAction()
    {
        $notices=$this->getDoctrine()->getRepository('AppBundle:Notice')->findAll();
        if(!$notices){
            throw $this->createNotFoundException('no notices posted ;<');
        }
        return ['notices'=>$notices];
    }
}
