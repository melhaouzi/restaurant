<?php

namespace App\Controller;

use App\Entity\BestelRegel;
use App\Form\BestelRegelType;
use App\Repository\BestelRegelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bestel/regel")
 */
class BestelRegelController extends AbstractController
{
    /**
     * @Route("/", name="bestel_regel_index", methods={"GET"})
     */
    public function index(BestelRegelRepository $bestelRegelRepository): Response
    {
    	if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'bestel_regel/index.html.twig', [
			    'bestel_regels' => $bestelRegelRepository->findAll(),
		    ] );
	    }
    	else{
    		return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/new", name="bestel_regel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $bestelRegel = new BestelRegel();
		    $form        = $this->createForm( BestelRegelType::class, $bestelRegel );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $entityManager = $this->getDoctrine()->getManager();
			    $entityManager->persist( $bestelRegel );
			    $entityManager->flush();

			    return $this->redirectToRoute( 'bestel_regel_index' );
		    }

		    return $this->render( 'bestel_regel/new.html.twig', [
			    'bestel_regel' => $bestelRegel,
			    'form'         => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="bestel_regel_show", methods={"GET"})
     */
    public function show(BestelRegel $bestelRegel): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'bestel_regel/show.html.twig', [
			    'bestel_regel' => $bestelRegel,
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}/edit", name="bestel_regel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BestelRegel $bestelRegel): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $form = $this->createForm( BestelRegelType::class, $bestelRegel );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $this->getDoctrine()->getManager()->flush();

			    return $this->redirectToRoute( 'bestel_regel_index', [
				    'id' => $bestelRegel->getId(),
			    ] );
		    }

		    return $this->render( 'bestel_regel/edit.html.twig', [
			    'bestel_regel' => $bestelRegel,
			    'form'         => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="bestel_regel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BestelRegel $bestelRegel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bestelRegel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bestelRegel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bestel_regel_index');
    }
}
