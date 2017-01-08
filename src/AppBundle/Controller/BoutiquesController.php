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

class BoutiquesController extends Controller
{
    /**
     * @Route("/boutiques", name="boutiques_list")
     * @Method({"GET"})
     */
    public function getBoutiquesAction(Request $request)
    {
           $boutiques = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boutiques')
                ->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($boutiques as $boutique) {
            $formatted[] = [
               'id' => $boutique->getIdboutique(),
               'nom' => $boutique->getLib(),
               'DateCreation' => $boutique->getDatecreation(),
               'Description' => $boutique->getDescription(),
               'UrlImage' => $boutique->getUrlimage(),
            ];
        }
        return new JsonResponse($formatted);
    }


    /**
     * @Route("/boutiques/{idboutique}", name="boutiques_one")
     * @Method({"GET"})
     */
    public function getBoutiqueAction(Request $request)
    {
        $boutique = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boutiques')
                ->find($request->get('idboutique'));
        /* @var $place Boutique */
        
           if (empty($boutique)) {
            return new JsonResponse(['message' => 'boutique not found'], Response::HTTP_NOT_FOUND);
        }
        
        $formatted = [
              'id' => $boutique->getIdboutique(),
               'nom' => $boutique->getLib(),
               'DateCreation' => $boutique->getDatecreation(),
               'Description' => $boutique->getDescription(),
               'UrlImage' => $boutique->getUrlimage(),
        ];

        return new JsonResponse($formatted);
    }
}