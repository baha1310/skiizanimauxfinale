<?php

namespace AnnonceBundle\Controller;


use UserBundle\Entity\Mail;

use AnnonceBundle\Form\MailType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;


class MailController extends Controller
{
    public function indexAction(Request $request,$id)
    {
        $mail = new Mail();
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository('UserBundle:Demande')->findOneBy(array('idDemande'=>$id));
$demandes=$em->getRepository('UserBundle:Demande')->findBy(array('idUser'=>$demande->getIdUser()));
        $annonce=$em->getRepository('UserBundle:Annonce')->findOneBy(array('id_annonce'=>$demande->getIdAnnonce()));
        $mail->setEmail($demande->getIdUser()->getEmail());
                $message = \Swift_Message::newInstance()
                    ->setSubject("Traitement de la demande")
                    ->setFrom('espritmail2@gmail.com')
                    ->setTo($mail->getEmail())
                    ->setBody(
                       'Cher Utilisateur '.$demande->getIdUser()->getUsername().',
                 la demande  que vous avez passer sur l annonce: '.$demande->getIdAnnonce()->getTitreAnnonce().' à propos de l animal '.$annonce->getIdAnimal()->getNom().'a été accepté'

                    );
$this->get('mailer')->send($message);
//return $this->redirect($this->generateUrl('my_app_mail_accuse'));

            //return $this->redirectToRoute('email',array('id'=>$id));
            $request->getSession()
                ->getFlashBag()
                ->add('danger', 'Succès d envoi');
        $em->remove($demande);
        $em->flush();
        $em->remove($annonce);
        $em->flush();



        return $this->redirectToRoute('traiterDemande');
        return $this->render('AnnonceBundle:Default:Demande.html.twig',array('m'=>$demandes));
    }
    public function refusAction(Request $request,$id)
    {
        $mail = new Mail();
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository('UserBundle:Demande')->findOneBy(array('idDemande'=>$id));
        $demandes=$em->getRepository('UserBundle:Demande')->findBy(array('idUser'=>$demande->getIdUser()));
        $annonce=$em->getRepository('UserBundle:Annonce')->findOneBy(array('id_annonce'=>$demande->getIdAnnonce()));
        $mail->setEmail($demande->getIdUser()->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject("Traitement de la demande")
            ->setFrom('espritmail2@gmail.com')
            ->setTo($mail->getEmail())
            ->setBody(
                'Cher Utilisateur '.$demande->getIdUser()->getUsername().',
                 la demande  que vous avez passer sur l annonce: '.$demande->getIdAnnonce()->getTitreAnnonce().' à propos de l animal '.$annonce->getIdAnimal()->getNom().' a été refusé'

            );
        $this->get('mailer')->send($message);
//return $this->redirect($this->generateUrl('my_app_mail_accuse'));

        //return $this->redirectToRoute('email',array('id'=>$id));
        $request->getSession()
            ->getFlashBag()
            ->add('danger', 'Succès d envoi');


        $em->remove($demande);
        $em->flush();

        return $this->redirectToRoute('traiterDemande');
        return $this->render('AnnonceBundle:Default:Demande.html.twig',array('m'=>$demandes));
    }

    /*public function successAction(){
        /*return new Response("email envoyé avec succès, Merci de vérifier votre boite
mail.");
        return $this->render('BackBundle:Default:email_read2.html.twig');

    }*/

}
