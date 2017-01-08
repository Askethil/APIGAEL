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
use AppBundle\Entity\Place;

class ArticlesController extends Controller
{
    /**
     * @Route("/articles", name="articles_list")
     * @Method({"GET"})
     */
    public function getArticlesAction(Request $request)
    {
           $articles = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Articles')
                ->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($articles as $article) {
            $formatted[] = [
               'id' => $article->getIdarticle(),
               'Libelle' => $article->getLib(),
               'dateCreation' => $article->getDatecreation(),
               'Stock' => $article->getStock(),
               'Description' => $article->getDescription(),
               'IdBoutique' => $article->getIdboutique(),
               'Image' => $article->getUrlimage(),
               'Prix' => $article->getPrix(),
                
            ];
        }
        return new JsonResponse($formatted);
    }


    // code de getPlacesAction

    /**
     * @Route("/articles/{idarticle}", name="articles_one")
     * @Method({"GET"})
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
        
        $formatted = [
           'id' => $article->getIdarticle(),
               'Libelle' => $article->getLib(),
               'dateCreation' => $article->getDatecreation(),
               'Stock' => $article->getStock(),
               'Description' => $article->getDescription(),
               'IdBoutique' => $article->getIdboutique(),
               'Image' => $article->getUrlimage(),
               'Prix' => $article->getPrix(),
        ];

        return new JsonResponse($formatted);
    }
}