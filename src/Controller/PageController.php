<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController {

    /**
     * @Route("primera_pagina")
     */
    public function index(){
        return $this->render('task/index.html.twig',
            array('controller_name' => 'TaskController')
        );
    }

}