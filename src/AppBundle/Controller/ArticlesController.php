<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use AppBundle\Form\Type\ArticlesType;
use AppBundle\Entity\Articles;

class ArticlesController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("articles")
     */
    public function getArticlesAction(Request $request)
    {
           $articles = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Articles')
                ->findAll();
        /* @var $places Place[] */

        return $articles;
    }



      /**
     * @Rest\View()
     * @Rest\Get("/articles/{idarticle}")
     */
 
    public function getArticleAction(Request $request)
    {
        $article = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Articles')
                ->find($request->get('idarticle'));
        /* @var $place Place */
        
           if (empty($article)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }


        return $article;
    }
    
    
    
     /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/article")
     */
    public function postArticleAction(Request $request)
    {

        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->submit($request->request->all()); // Validation des données
         if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($article);
            $em->flush();
            return $article;
        } else {
            return $form;
        }
        
      
        
    }
    
    
     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/article/{idarticle}")
     */
    public function removeArticleAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $article = $em->getRepository('AppBundle:Articles')
                    ->find($request->get('idarticle'));
        /* @var $place Place */

        $em->remove($article);
        $em->flush();
    }
    
     /**
     * @Rest\View()
     * @Rest\Patch("/article/{idarticle}")
     */
    public function patchArticleAction(Request $request)
    {
        return $this->updateArticle($request, false);
    }

    private function updateArticle(Request $request, $clearMissing)
    {
        $article = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Articles')
                ->find($request->get('idarticle')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($article)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ArticlesType::class, $article);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($article);
            $em->flush();
            return $article;
        } else {
            return $form;
        }
    }
    
    
}