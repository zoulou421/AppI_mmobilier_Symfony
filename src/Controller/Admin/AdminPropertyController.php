<?php

namespace App\Controller\Admin;
use App\Form\PropertyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Property;
//use App\Controller\Admin\PropertyType;
//use App\Controller\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;



#[Route('admin')]

class AdminPropertyController extends AbstractController
{
	public function __construct(private PropertyRepository $repository, private EntityManagerInterface $em){
	
	}

	#[Route('/', name:'app_admin_property_index', methods: ['GET', 'POST'])]

	public function index():Response
	{
       $properties=$this->repository->findAll();
       return $this->render('admin/property/index.html.twig', compact('properties'));
	}

   #[Route('/bien/create', name:'app_admin_property_new')]
	public function new(Request $request){
       $property = new Property();

       $form=$this->createForm(PropertyType::class, $property);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
       	 $this->em->persist($property);
       	 $this->em->flush();
       	 $this->addFlash('success','Bien créé avec succès');
       	 return $this->redirectToRoute('app_admin_property_index');

       }
        return $this->render('admin/property/new.html.twig', [
        'property'=>$property,
        'form'=>$form->createView()
       ]);


	}

	#[Route('/{id}', name:'app_admin_property_edit')]

	public function edit(Property $property=null, Request $request):Response
	{

       $form=$this->createForm(PropertyType::class, $property);

       //debut traitement
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
       	 $this->em->flush();
       	 $this->addFlash('success','Bien modifié avec succès');
       	 return $this->redirectToRoute('app_admin_property_index');

       }

       return $this->render('admin/property/edit.html.twig', [
        'property'=>$property,
        'form'=>$form->createView()
       ]);
	}

   #[Route('/bien/{id}', name:'app_admin_property_delete', methods:['DELETE','POST'])]
	public function delete(Property $property, Request $request){
		$submittedToken = $request->request->get('token');
	//if($this->isCsrfTokenValid('delete-item', $submittedToken))||Doc:https://symfony.com/doc/current/security/csrf.html
       if($this->isCsrfTokenValid('delete'.$property->getId(), $submittedToken)){
          $this->em->remove($property);
          $this->em->flush();
          $this->addFlash('success','Bien supprimé avec succès');
          return $this->redirectToRoute('app_admin_property_index');
       }
       
	}
}