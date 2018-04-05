<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Form\AnimalType;
use UserBundle\Entity\Animal;
use UserBundle\Entity\Annonce;
use UserBundle\Entity\Demande;
use AnnonceBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemandeController extends Controller
{

    public function affichageAction(Request $request)
    {


            $marque = new Demande();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();

            $equipes = $em->getRepository('UserBundle:Demande')->findBy(array('idUser' => $user->getId()));
            if ($equipes == null) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Vous n avez aucune demande à traiter');


        }
        return $this->render('AnnonceBundle:Default:Demande.html.twig', array(
            'm'=>$equipes));

    }

}
