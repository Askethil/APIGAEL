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
use AppBundle\Entity\Utilisateurs;

class UtilisateursController extends Controller
{
   /**
     * @Rest\View()
     * @Rest\Get("/utilisateurs")
     */
    public function getUtilisateursAction(Request $request)
    {
           $Utilisateurs = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Utilisateurs')
                ->findAll();
        /* @var $places Place[] */

        return $Utilisateurs;
    }


 /**
     * @Rest\View()
     * @Rest\Get("/utilisateurs/{idutilisateur}")
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
        


        return $Utilisateur;
    }
    
    
             /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/utilisateur")
     */
    public function postUtilisateurAction(Request $request)
    {

        $Utilisateur = new Utilisateurs();
        $form = $this->createForm(ArticlesType::class, $Utilisateur);
        $form->submit($request->request->all()); // Validation des données
         if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Utilisateur);
            $em->flush();
            return $Utilisateur;
        } else {
            return $form;
        }
        
      
        
    }
}