<?php

namespace App\Controller;

use App\Entity\Gerecht;
use App\Entity\GerechtType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController {
	/**
	 * @Route("/menu", name="menu")
	 */
	public function index() {
		$em    = $this->getDoctrine()->getManager();
		$menu  = $em->getRepository( Gerecht::class )->findAll();
		$types = $em->getRepository( GerechtType::class )->findAll();

		return $this->render( 'menu/index.html.twig', [
			'controller_name' => 'MenuController',
			'menu'            => $menu,
			'types'           => $types,
		] );
	}
}
