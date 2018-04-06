<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 2/26/2018
 * Time: 3:29 AM
 */

namespace PdfBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PdfController extends Controller
{
    public function pdfAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $equipes=$em->getRepository('UserBundle:Annonce')->findBy(array('id'=>$user->getId()));

        $html = $this->renderView('PdfBundle:Pdf:Pdf.html.twig',array('annonce'=>$equipes));




        $filename = sprintf('Annonce-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
        return $this->redirectToRoute('MesAnnonces');
    }
}