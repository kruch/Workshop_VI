<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notice;
use AppBundle\Entity\Comment;
use AppBundle\Form\NoticeType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/nb")
 */
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
     * @Route("/show")
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
        $notice=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->find($id);

        if(!$notice)
        {
            throw $this->createNotFoundException("can't find your stupid post...");
        }

        $em=$this->getDoctrine()->getManager();
        $em->remove($notice);
        $em->flush();
        return $this->redirectToRoute('app_notice_showall');
    }





}
