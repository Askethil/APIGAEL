<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
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
}