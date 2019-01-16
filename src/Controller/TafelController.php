<?php

namespace App\Controller;

use App\Entity\Tafel;
use App\Form\TafelType;
use App\Repository\TafelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tafel")
 */
class TafelController extends AbstractController
{
    /**
     * @Route("/", name="tafel_index", methods={"GET"})
     */
    public function index(TafelRepository $tafelRepository): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'tafel/index.html.twig', [
			    'tafels' => $tafelRepository->findAll(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/new", name="tafel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $tafel = new Tafel();
		    $form  = $this->createForm( TafelType::class, $tafel );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $entityManager = $this->getDoctrine()->getManager();
			    $entityManager->persist( $tafel );
			    $entityManager->flush();

			    return $this->redirectToRoute( 'tafel_index' );
		    }

		    return $this->render( 'tafel/new.html.twig', [
			    'tafel' => $tafel,
			    'form'  => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="tafel_show", methods={"GET"})
     */
    public function show(Tafel $tafel): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'tafel/show.html.twig', [
			    'tafel' => $tafel,
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}/edit", name="tafel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tafel $tafel): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $form = $this->createForm( TafelType::class, $tafel );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $this->getDoctrine()->getManager()->flush();

			    return $this->redirectToRoute( 'tafel_index', [
				    'id' => $tafel->getId(),
			    ] );
		    }

		    return $this->render( 'tafel/edit.html.twig', [
			    'tafel' => $tafel,
			    'form'  => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="tafel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tafel $tafel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tafel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tafel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tafel_index');
    }
}
