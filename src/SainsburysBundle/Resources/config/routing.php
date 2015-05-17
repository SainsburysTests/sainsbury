<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sainsburys_homepage', new Route('/hello/{name}', array(
    '_controller' => 'SainsburysBundle:Default:index',
)));

return $collection;
