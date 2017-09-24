<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;

class CategoryController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/admin/categories")
     * @Template("admin/admin_categories.html.twig")
     */
    public function CategoryAction()
    {
        $categories=$this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        if(!$categories)
        {
            throw $this->createNotFoundException('Category not found');
        }
        return['categories'=>$categories];
    }

    /**
     * @Route("/admin/addcat")
     */
  /*  public function addCategoryAction(Request $request)
    {
        $category= new Category();


        $user=$this->getUser();
        $category->setName($user);
        ;

        $form=$this->createForm(NoticeType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_notice_showall');
        }
        return['form'=>$form->createView(), 'notice'=>$category];
    }*/
}
