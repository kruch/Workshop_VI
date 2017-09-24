<?php

namespace AppBundle\Controller;

use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;


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
     * @Route("/admin/categories/add")
     * @Template("comment/comment.html.twig")
     */
    public function addCategoryAction(Request $request)
    {
        $category= new Category();

        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_category_category');
        }
        return['form'=>$form->createView(), 'categories'=>$category];
    }
}
