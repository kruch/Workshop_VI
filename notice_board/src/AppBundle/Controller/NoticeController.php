<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notice;
use AppBundle\Entity\Comment;
use AppBundle\Form\NoticeType;
use AppBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class NoticeController extends Controller
{
    /**
     * @Route("/create")
     * @Template("addNotice.html.twig")
     */
    public function createAction(Request $request)
    {

        $notice= new Notice();
        $notice->setDate(new \DateTime());

        $user=$this->getUser();
        $notice->setUser($user);
        $user->addNotice($notice);

        $form=$this->createForm(NoticeType::class,$notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            return $this->redirectToRoute('app_notice_showall');
        }
        return['form'=>$form->createView(), 'notice'=>$notice];

    }

    /**
     * @Route("/")
     * @Template("main_view.html.twig")
     */
    public function showAll()
    {
        $notices=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->findAll();

        return ['notices'=>$notices];
    }

    /**
     * @Route("/show/{id}")
     * @Template("notice_details.html.twig")
     */
    public function showNotice($id)
    {
        $notice=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->find($id);

        if(!$notice)
        {
            throw $this->createNotFoundException('Notice not found');
        }
        return['notice'=>$notice];
    }

    /**
     * @Route("/del/{id}")
     *
     */
    public function deleteNotice($id)
    {
        $user=$this->getUser();

        $notice=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->find($id);

        if(!$notice)
        {
            throw $this->createNotFoundException("can't find your stupid post...");
        }

        if($user==$notice->getUser())
        {
            $em=$this->getDoctrine()->getManager();
            $em->remove($notice);
            $em->flush();
            return $this->redirectToRoute('app_notice_showall');
        }

    }

    /**
     *@Route("/user/edit_notices")
     * @Template("user/user_edit.html.twig")
     */
    public function editUserNotices()
    {
        //$user=$this->getUser();

        $notices=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->findBy(['user'=>$this->getUser()]);

        if(!$notices)
        {
           // throw $this->createNotFoundException('Notice not found');

            return $this->redirectToRoute('app_notice_showall');
        }
        return['notices'=>$notices];
    }

    /**
     * @Route("/editNotice/{id}")
     * @Template("addNotice.html.twig")
     */
    public function editNoticeAction(Request $request, $id)
    {
        $notice = $this->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->find($id);
        if(!$notice) {
            throw $this->createNotFoundException('Notice not found');
        }
        $form = $this->createForm(NoticeType::class, $notice);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_notice_editusernotices');
        }
        return['form' => $form->createView()];
    }



}
