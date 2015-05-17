<?php

namespace SainsburysBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SainsburysBundle:Default:index.html.twig', array('name' => $name));
    }
}
