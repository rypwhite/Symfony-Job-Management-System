<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/job', name: 'job.')]
class JobController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(JobRepository $job_repo): Response
    {
        $jobs = $job_repo->findAll();

        return $this->render('job/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    #[Route('/view/{id}', name: 'view')]
    public function show(Job $job): Response
    {
        return $this->render('job/view.html.twig', [
            'job' => $job,
        ]);
    }

    #[Route('/view_all', name: 'view_all')]
    public function view(JobRepository $job_repo): Response
    {
        $jobs = $job_repo->findAll();

        return $this->render('job/view_all.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em) : Response {
        $job = new Job();
        
        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($job);
            $em->flush();

            $this->addFlash(type:'success', message:'Job was successfully created');

            return $this->redirect($this->generateUrl(route:'job.index'));
        }

        return $this->render('job/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Job $job, EntityManagerInterface $em) : Response {
        $em->remove($job);
        $em->flush();

        $this->addFlash(type:'success', message:'Job was successfully deleted');

        return $this->redirect($this->generateUrl(route:'job.view_all'));
        //return new Response(content: 'Job was removed :(');
    }
}
