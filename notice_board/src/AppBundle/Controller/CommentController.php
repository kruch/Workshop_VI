<?php


namespace AppBundle\Controller;
use AppBundle\Form\CommentType;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notice;

class CommentController extends Controller
{

    /**
     * @Route("/comment/{id}")
     * @Template("comment/comment.html.twig")
     */
    public function addComment(Request $request, $id)
    {
        $comment = new Comment();

        $notice=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Notice')
            ->find($id);

        if(!$notice)
        {
            throw $this->createNotFoundException('notice not found');
        }

        $comment->setNotice($notice);
        $notice->addComment($comment);

        $comment->setCreationDate(new \DateTime());

        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_notice_showall');
        }
        return['form'=>$form->createView(), 'notice'=>$notice, 'comment'=>$comment];
    }
}
