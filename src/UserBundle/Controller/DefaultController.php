<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }

    public function layoutAction()
    {
        return $this->render('UserBundle::layout.html.twig');
    }


    public function zzAction()
    {
        return $this->render('@User/aaaa.html.twig');
    }

    public function aadminAction()
    {
        return $this->render('@User/admin.html.twig');
    }

    public function veterinaireAction()
    {
        return $this->render('@User/veterinaireAcceuil.html.twig');
    }

}
