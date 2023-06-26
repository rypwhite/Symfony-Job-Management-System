<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

#[Route('/register', name: 'register.')]
class RegisterController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-md float-right btn-success'
                ]
            ])->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $data = $form->getData();

            if (!isset($data['password'])) {
                $this->addFlash(type:'failed', message:'Passwords did not match');

                return $this->redirect($this->generateUrl(route:'register.index'));
            }

            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

            $em->persist($user);
            $em->flush();

            $this->addFlash(type:'success', message:'User was successfully created');

            return $this->redirect($this->generateUrl(route:'app_login'));
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
