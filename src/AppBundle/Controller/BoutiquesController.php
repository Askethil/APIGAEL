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
use AppBundle\Form\Type\BoutiquesType;
use AppBundle\Entity\Boutiques;

class BoutiquesController extends Controller
{
   /**
     * @Rest\View()
     * @Rest\Get("/boutiques")
     */
    public function getBoutiquesAction(Request $request)
    {
           $boutiques = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boutiques')
                ->findAll();
        /* @var $places Place[] */

        return  $boutiques;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/boutiques/{idboutique}")
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
        


        return $boutique;
    }
    
     /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/boutique")
     */
    public function postBoutiqueAction(Request $request)
    {

        $boutique = new Boutiques();
        $form = $this->createForm(BoutiquesType::class, $boutique);
        $form->submit($request->request->all()); // Validation des données
         if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($boutique);
            $em->flush();
            return $boutique;
        } else {
            return $form;
        }
        
      
        
    }
    
     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/boutique/{idboutique}")
     */
    public function removeBoutiqueAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $boutique = $em->getRepository('AppBundle:Boutiques')
                    ->find($request->get('idboutique'));
        /* @var $place Place */

        if ($boutique) {
            $em->remove($boutique);
            $em->flush();
        }
    }
    
    
    
    
     /**
     * @Rest\View()
     * @Rest\Patch("/boutique/{idboutique}")
     */
    public function patchBoutiqueAction(Request $request)
    {
        return $this->updateBoutique($request, false);
    }

    private function updateBoutique(Request $request, $clearMissing)
    {
        $boutique = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boutiques')
                ->find($request->get('idboutique')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($boutique)) {
            return new JsonResponse(['message' => 'Boutique not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(BoutiquesType::class, $boutique);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($boutique);
            $em->flush();
            return $boutique;
        } else {
            return $form;
        }
    }
}