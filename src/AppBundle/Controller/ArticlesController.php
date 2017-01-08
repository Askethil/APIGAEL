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
     * @Route("/places/{place_id}", name="places_one")
     * @Method({"GET"})
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->find($request->get('place_id'));
        /* @var $place Place */
        
           if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        
        $formatted = [
           'id' => $place->getId(),
           'name' => $place->getName(),
           'address' => $place->getAddress(),
        ];

        return new JsonResponse($formatted);
    }
}