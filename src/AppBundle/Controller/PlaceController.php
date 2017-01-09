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
use AppBundle\Entity\Place;

class PlaceController extends Controller
{
   /**
     * @Rest\View()
     * @Rest\Get("/places")
     */
    public function getPlacesAction(Request $request)
    {
           $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->findAll();
        /* @var $places Place[] */

       return $places;
    }

     /**
     * @Rest\View()
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction( Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Place')
                ->find($request->get('id'));
        /* @var $place Place */
        
           if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        
        $formatted = [
           'id' => $place->getId(),
           'name' => $place->getName(),
           'address' => $place->getAddress(),
        ];

        // Récupération du view handler
        $viewHandler = $this->get('fos_rest.view_handler');

        // Création d'une vue FOSRestBundle
        $view = View::create($formatted);
        $view->setFormat('json');

        // Gestion de la réponse
        return $viewHandler->handle($view);
    }
}