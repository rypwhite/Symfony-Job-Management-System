<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/home/{name?}', name: 'home')]
    public function index(Request $request): Response
    {
        $name = ucfirst($request->get(key: 'name'));
        return $this->render('/home/index.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/ping/{name?}', name: 'ping')]
    public function ping(Request $request): Response
    {
        $name = $request->get(key: 'name');
        return $this->render('/home/ping.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/pong', name: 'custom')]
    public function view(Request $request): Response
    {
        //$name = $request->get(key: 'name');
        return $this->render(view:'/home/index.html.twig');
    }
}
