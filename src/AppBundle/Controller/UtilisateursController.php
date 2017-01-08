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

class UtilisateursController extends Controller
{
    /**
     * @Route("/utilisateurs", name="utilisateurs_list")
     * @Method({"GET"})
     */
    public function getUtilisateursAction(Request $request)
    {
           $Utilisateurs = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Utilisateurs')
                ->findAll();
        /* @var $places Place[] */

        $formatted = [];
        foreach ($Utilisateurs as $Utilisateur) {
            $formatted[] = [
               'id' => $Utilisateur->getIdutilisateur(),
               'login' => $Utilisateur->getLogin(),
               'Mdp' => $Utilisateur->getMdp(),
               'Boutique' => $Utilisateur->getIdboutique(),
               'Email' => $Utilisateur->getEmail(),
               'Nom' => $Utilisateur->getNom(),
               'Prenom' => $Utilisateur->getPrenom(),
            ];
        }
        return new JsonResponse($formatted);
    }


    // code de getPlacesAction

    /**
     * @Route("/utilisateurs/{idutilisateur}", name="utilisateurs_one")
     * @Method({"GET"})
     */
    public function getUtilisateurAction(Request $request)
    {
        $Utilisateur = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Utilisateurs')
                ->find($request->get('idutilisateur'));
        /* @var $place Place */
        
           if (empty($Utilisateur)) {
            return new JsonResponse(['message' => 'Utilisateur not found'], Response::HTTP_NOT_FOUND);
        }
        
        $formatted = [
               'id' => $Utilisateur->getIdutilisateur(),
               'login' => $Utilisateur->getLogin(),
               'Mdp' => $Utilisateur->getMdp(),
               'Boutique' => $Utilisateur->getIdboutique(),
               'Email' => $Utilisateur->getEmail(),
               'Nom' => $Utilisateur->getNom(),
               'Prenom' => $Utilisateur->getPrenom(),
        ];

        return new JsonResponse($formatted);
    }
}