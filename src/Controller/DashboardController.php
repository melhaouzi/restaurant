<?php

namespace App\Controller;

use App\Entity\BestelRegel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager();
    	$regels = $em->getRepository(BestelRegel::class)->findAll();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'regels' => $regels
        ]);
    }
}
