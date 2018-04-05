<?php

namespace AnnonceBundle\Controller;

use UserBundle\Entity\Annonce;
use UserBundle\Entity\Demande;
use AnnonceBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends Controller
{
    public function indexAction()
    {
        return $this->render('AnnonceBundle:Default:index.html.twig');
    }
    public function backAction()
    {
        $marque=new Annonce();

        $em=$this->getDoctrine()->getManager();

        $equipes=$em->getRepository('UserBundle:Annonce')->findAll();

        return $this->render('AnnonceBundle:Default:AnnonceBack.html.twig', array(
            'm'=>$equipes));
    }
    public function adoptionAction()
    {
        $marque=new Annonce();

        $em=$this->getDoctrine()->getManager();
        $equipes=$em->getRepository('UserBundle:Annonce')->findBy(array('type_annonce'=>'Adoption'));


        return $this->render('AnnonceBundle:Default:ListeAdoption.html.twig', array(
            'm'=>$equipes));

    }
    public function accouplementAction()
    {
        $marque=new Annonce();

        $em=$this->getDoctrine()->getManager();

        $equipes=$em->getRepository('UserBundle:Annonce')->findBy(array('type_annonce'=>'Accouplement'));


        return $this->render('AnnonceBundle:Default:ListeAccouplement.html.twig', array(
            'm'=>$equipes));

    }
    public function venteAction()
    {
        $marque=new Annonce();

        $em=$this->getDoctrine()->getManager();

        $equipes=$em->getRepository('UserBundle:Annonce')->findBy(array('type_annonce'=>'Vente'));


        return $this->render('AnnonceBundle:Default:ListeVente.html.twig', array(
            'm'=>$equipes));

    }
    public function demanderAction($idUser,$idAnnonce,Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($user=='anon.')
            return $this->redirectToRoute('fos_user_security_login');
        else {
            $marque = new Demande();
            $d = $em->getRepository('UserBundle:Demande')->findOneBy(array('idUser' => $idUser,'idAnnonce'=>$idAnnonce));
            if($d!=null){
                $equipes = $em->getRepository('UserBundle:Annonce')->findBy(array('type_annonce' => 'Adoption'));
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Vous avez déjà envoyé une demande à propos de cette annonce');

            }else {
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $idUser));
                $ann = $em->getRepository('UserBundle:Annonce')->findOneBy(array('id_annonce' => $idAnnonce));
                $equipes = $em->getRepository('UserBundle:Annonce')->findBy(array('type_annonce' => 'Adoption'));
                $marque->setIdUser($user);
                $marque->setIdAnnonce($ann);
                $em->persist($marque);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Votre Demande a été envoyer');
            }
        }
        return $this->render('AnnonceBundle:Default:ListeAdoption.html.twig', array(
            'm'=>$equipes));

    }
    public function ajoutAction(Request $request,$id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

            $joueur = new Annonce();
            $em = $this->getDoctrine()->getManager();

            $animal = $em->getRepository('UserBundle:Animal')->findOneBy(array('id_animal' => $id));
            $form = $this->createForm(AnnonceType::class, $joueur);

            if ($form->handleRequest($request)->isValid()) {

                /**
                 * @var UploadedFile $file
                 */

                $joueur->setDateAnnonce(new \DateTime('now'));
                $file = $joueur->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('image_directory'), $fileName);
                $joueur->setImage($fileName);
                $joueur->setIdAnimal($animal);
                $joueur->setId($user);
                $em->persist($joueur);
                $em->flush();
                //return $this->redirectToRoute('affiche');
                return $this->redirectToRoute('MesAnnonces');



            }
        return $this->render('AnnonceBundle:Default:FormulaireAnnonce.html.twig',array('f'=>$form->createView()));

    }
    public function affichageAction(Request $request)
    {


            $marque = new Annonce();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();

            $equipes = $em->getRepository('UserBundle:Annonce')->findBy(array('id' => $user->getId()));
            if ($equipes == null) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', 'Vous n avez aucune Annonce');

            }

        return $this->render('AnnonceBundle:Default:MesAnnonces.html.twig', array(
            'm'=>$equipes));

    }
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $equipe=$em->find(Annonce::class,$id);

        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('MesAnnonces');
    }
    public function deleteBackAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $equipe=$em->find(Annonce::class,$id);

        $em->remove($equipe);
        $em->flush();
        return $this->redirectToRoute('annonceBack');
    }
    public function modifierAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('UserBundle:Annonce')->find($id);
        $form = $this->createForm(AnnonceType::class, $mark);

        if ($form->handleRequest($request)->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file=$mark->getImage() ;
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'),$fileName) ;
            $mark->setImage($fileName);
            $em->persist($mark);
            $em->flush();
            return $this->redirectToRoute('MesAnnonces');
        }

        return $this->render('AnnonceBundle:Default:modifierAnnonce.html.twig', array('f' => $form->createView()));
    }

    public function rechercherAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $motcle=$request->get('motcle');
        $repository=$em->getRepository('UserBundle:Annonce');
        $query=$em->createQueryBuilder()
            ->select('p')->from('UserBundle:Annonce','p')
            ->where('p.type_annonce like :nom')
            ->setParameter('nom','%'.$motcle.'%')
            ->orderBy('p.date_annonce','ASC')
            ->getQuery();

        $produits=$query->getResult();


        return $this->render('AnnonceBundle:Default:MesAnnonces.html.twig',array('m'=>$produits));
    }
    public function rechercherBackAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $motcle=$request->get('motcle');
        $repository=$em->getRepository('UserBundle:Annonce');
        $query=$em->createQueryBuilder()
            ->select('p')->from('UserBundle:Annonce','p')
            ->where('p.type_annonce like :nom')
            ->setParameter('nom','%'.$motcle.'%')
            ->orderBy('p.date_annonce','ASC')
            ->getQuery();

        $produits=$query->getResult();


        return $this->render('AnnonceBundle:Default:AnnonceBack.html.twig',array('m'=>$produits));
    }
    public function trierAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        if($request->getMethod()=="POST") {

            $x = $request->get('select');

            // var_dump($x);
            if ($x == 'type') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Adoption')
                    ->orderBy('u.type','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
            if ($x == 'race') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Adoption')
                    ->orderBy('u.race','DESC')
                    ->getQuery();
                $produits = $query2->getResult();

            }
            if ($x == 'age') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Adoption')
                    ->orderBy('u.age','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
        }

        return $this->render('AnnonceBundle:Default:ListeAdoption.html.twig',array('m'=>$produits));
    }
    public function trierVAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        if($request->getMethod()=="POST") {

            $x = $request->get('select');

            // var_dump($x);
            if ($x == 'type') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Vente')
                    ->orderBy('u.type','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
            if ($x == 'race') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Vente')
                    ->orderBy('u.race','DESC')
                    ->getQuery();
                $produits = $query2->getResult();

            }
            if ($x == 'age') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Vente')
                    ->orderBy('u.age','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
        }

        return $this->render('AnnonceBundle:Default:ListeVente.html.twig',array('m'=>$produits));
    }
    public function trierACAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        if($request->getMethod()=="POST") {

            $x = $request->get('select');

            // var_dump($x);
            if ($x == 'type') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Accouplement')
                    ->orderBy('u.type','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
            if ($x == 'race') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Accouplement')
                    ->orderBy('u.race','DESC')
                    ->getQuery();
                $produits = $query2->getResult();

            }
            if ($x == 'age') {
                $query2 =$em->createQueryBuilder()->select('m')->from('UserBundle:Annonce','m')
                    ->join('UserBundle:Animal','u')->where('m.id_animal = u.id_animal and m.type_annonce =:x')
                    ->setParameter('x','Accouplement')
                    ->orderBy('u.age','DESC')
                    ->getQuery();
                $produits = $query2->getResult();
            }
        }

        return $this->render('AnnonceBundle:Default:ListeAccouplement.html.twig',array('m'=>$produits));
    }
}
