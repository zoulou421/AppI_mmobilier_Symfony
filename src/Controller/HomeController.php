<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\PropertyRepository;

use Twig\Environment;

class HomeController
{

   /**
    * 
    * @var Environment
    */

    private $twig;

    public function __construct(Environment $twig) {
        $this->twig=$twig; 
    }

    public function index(PropertyRepository $repository): Response
    {
    	$properties = $repository->findLatest();
        return new Response($this->twig->render('pages/home.html.twig',[
        	'properties'=>$properties
        ]));
    }

	
}