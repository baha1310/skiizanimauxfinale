<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Form\AnimalType;
use UserBundle\Entity\Animal;
use UserBundle\Entity\Annonce;
use UserBundle\Entity\Demande;
use AnnonceBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnimalController extends Controller
{

    public function affichageAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=='anon.')
            return $this->redirectToRoute('fos_user_security_login');
        else {
            $marque = new Animal();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();

            $equipes = $em->getRepository('UserBundle:Animal')->findBy(array('id' => $user->getId()));
            if ($equipes == null) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Vous n avez aucun animal');
                $this->redirectToRoute('adoption');
            }
        }
        return $this->render('AnnonceBundle:Default:MesAnimaux.html.twig', array(
            'm'=>$equipes));

    }
    public function ajoutAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user=='anon.')
            return $this->redirectToRoute('fos_user_security_login');
        else {


        $joueur = new Animal();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AnimalType::class, $joueur);

        if ($form->handleRequest($request)->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $joueur->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $joueur->setImage($fileName);
            $joueur->setId($user);
            $em->persist($joueur);
            $em->flush();
            //return $this->redirectToRoute('affiche');
            return $this->redirectToRoute('affichage');

        }}


        return $this->render('AnnonceBundle:Default:FormulaireAnimal.html.twig',array('f'=>$form->createView()));

    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $equipe=$em->find(Animal::class,$id);
        $equipes = $em->getRepository('UserBundle:Annonce')->findBy(array('id_animal' =>$id));
        foreach ($equipes as $e){
            $em->remove($e);
            $em->flush();
        }
        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('affichage');
    }
}
