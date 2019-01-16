<?php

namespace App\Controller;

use App\Entity\GerechtType;
use App\Form\GerechtTypeType;
use App\Repository\GerechtTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerecht/type")
 */
class GerechtTypeController extends AbstractController
{
    /**
     * @Route("/", name="gerecht_type_index", methods={"GET"})
     */
    public function index(GerechtTypeRepository $gerechtTypeRepository): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'gerecht_type/index.html.twig', [
			    'gerecht_types' => $gerechtTypeRepository->findAll(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/new", name="gerecht_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $gerechtType = new GerechtType();
		    $form        = $this->createForm( GerechtTypeType::class, $gerechtType );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $entityManager = $this->getDoctrine()->getManager();
			    $entityManager->persist( $gerechtType );
			    $entityManager->flush();

			    return $this->redirectToRoute( 'gerecht_type_index' );
		    }

		    return $this->render( 'gerecht_type/new.html.twig', [
			    'gerecht_type' => $gerechtType,
			    'form'         => $form->createView(),
		    ] );
	    }else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="gerecht_type_show", methods={"GET"})
     */
    public function show(GerechtType $gerechtType): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'gerecht_type/show.html.twig', [
			    'gerecht_type' => $gerechtType,
		    ] );
	    }else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}/edit", name="gerecht_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GerechtType $gerechtType): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $form = $this->createForm( GerechtTypeType::class, $gerechtType );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $this->getDoctrine()->getManager()->flush();

			    return $this->redirectToRoute( 'gerecht_type_index', [
				    'id' => $gerechtType->getId(),
			    ] );
		    }

		    return $this->render( 'gerecht_type/edit.html.twig', [
			    'gerecht_type' => $gerechtType,
			    'form'         => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="gerecht_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GerechtType $gerechtType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gerechtType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gerechtType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gerecht_type_index');
    }
}
