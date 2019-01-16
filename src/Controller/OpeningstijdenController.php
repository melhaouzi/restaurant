<?php

namespace App\Controller;

use App\Entity\Openingstijden;
use App\Form\OpeningstijdenType;
use App\Repository\OpeningstijdenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/openingstijden")
 */
class OpeningstijdenController extends AbstractController
{
    /**
     * @Route("/", name="openingstijden_index", methods={"GET"})
     */
    public function index(OpeningstijdenRepository $openingstijdenRepository): Response
    {

        return $this->render('openingstijden/index.html.twig', [
            'openingstijdens' => $openingstijdenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="openingstijden_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $openingstijden = new Openingstijden();
		    $form           = $this->createForm( OpeningstijdenType::class, $openingstijden );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $entityManager = $this->getDoctrine()->getManager();
			    $entityManager->persist( $openingstijden );
			    $entityManager->flush();

			    return $this->redirectToRoute( 'openingstijden_index' );
		    }

		    return $this->render( 'openingstijden/new.html.twig', [
			    'openingstijden' => $openingstijden,
			    'form'           => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="openingstijden_show", methods={"GET"})
     */
    public function show(Openingstijden $openingstijden): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    return $this->render( 'openingstijden/show.html.twig', [
			    'openingstijden' => $openingstijden,
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}/edit", name="openingstijden_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Openingstijden $openingstijden): Response
    {
	    if($this->isGranted("ROLE_SUPER_ADMIN")) {
		    $form = $this->createForm( OpeningstijdenType::class, $openingstijden );
		    $form->handleRequest( $request );

		    if ( $form->isSubmitted() && $form->isValid() ) {
			    $this->getDoctrine()->getManager()->flush();

			    return $this->redirectToRoute( 'openingstijden_index', [
				    'id' => $openingstijden->getId(),
			    ] );
		    }

		    return $this->render( 'openingstijden/edit.html.twig', [
			    'openingstijden' => $openingstijden,
			    'form'           => $form->createView(),
		    ] );
	    }
	    else{
	    	return $this->render('default/accessdenied.html.twig');
	    }
    }

    /**
     * @Route("/{id}", name="openingstijden_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Openingstijden $openingstijden): Response
    {
        if ($this->isCsrfTokenValid('delete'.$openingstijden->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($openingstijden);
            $entityManager->flush();
        }

        return $this->redirectToRoute('openingstijden_index');
    }
}
