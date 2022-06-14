<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
//use App\Repository\Property\Repository;
use App\Repository\PropertyRepository;
use Cocur\Slugify\Slugify;


class PropertyController extends AbstractController
{
    
	/**
     * 
     * @var PropertyRepository
    */
	 public function __construct(private PropertyRepository $repository, private EntityManagerInterface $em, private ManagerRegistry $doctrine)
	 {
	 }

	 #[Route('/biens', name: 'app_properties_index')]
	  public function index():Response
	  {
          
	  	  /*$property = new Property();
	  	  $property->setTitle('Mon premier bien')
                   ->setPrice(200000)
                   ->setRooms(4)
                   ->setBedrooms(3)
                   ->setDescription('Une petite description')
                   ->setSurface(60)
                   ->setFloor(4)
                   ->setHeat(1)
                   ->setCity('Dakar')
                   ->setAddress('Liberté 6 extension porte 38')
                   ->setPostalCode('19999');
                  $em = $doctrine->getManager();
                  $em->persist($property);
                  $em->flush();*/

                  /* procedons maintenant à la récupération des données */
                  /* voici donc la première approche */
                 // $repository =$doctrine->getRepository(Property::class);
                 // dump($repository);
                  //$property[0]->setSold(sold:true);
                  //dd($property);
                 // $this->em->flush();

          return $this->render('property/index.html.twig',[

           'current_menu'=>'properties'
          ]);
	  }
     

     #[Route('/biens/{slug}-{id}', name:'app_property_show', requirements: ['slug' => '[a-z0-9\-9]*'])]
    /**
     * 
     * @param Property $repository
    */
//	  public function show($slug, $id):Response
//	  {
	  //	$property = $this->repository->find($id);
	  //	return $this->render('property/show.html.twig',[
     //      'property'=> $property
 //          'current_menu'=>'properties'
      //    ]);
        //with an injection method you have the same result
       public function show(Property $property, string $slug):Response
       { 
          if ($property->getSlug()!==$slug) {
              return $this->redirectToRoute('app_property_show',
          [
            'id'=>$property->getId(),
            'slug'=>$property->getSlug(),
          ],301);
          }
          return $this->render('property/show.html.twig',[
           'property'=> $property
 //          'current_menu'=>'properties'
          ]);


	  }
}