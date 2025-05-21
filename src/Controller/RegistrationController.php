<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // On hash le mot de passe // On le stocke dans la base de données // 
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            
            // On génère un token pour l'utilisateur pour valider l'activation du compte via un envoie d'un token par mail pour l'utilisateur pour valider l'activation de son compte //
            $user->setToken(uniqid());

            $entityManager->persist($user);
            $entityManager->flush();

            // On envoie un message flash de succès
            $this->addFlash('success', 'Votre compte a été créé avec succès !');

            // ON envoie un mail à l'utilisateur pour lui dire qu'il doit activer son compte //
            // On redirige l'utilisateur vers la page de connexion
            $email = (new TemplatedEmail())
            ->from(new Address('no-reply@yko.fr', 'No Reply Yko'))
            ->to((string) $user->getEmail())
            ->subject('Activation de votre compte')
            ->htmlTemplate('Email/activation_account.html.twig')
            ->context([
                'user' => $user,
            ])
        ;

        $mailer->send($email);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
    /**
     * Cette méthode est appelée lorsque l'utilisateur clique sur le lien d'activation de son compte
     * @param string $token
     * @return Response
     */
    #[Route('/activation-compte/{token}', name: 'app_activation_account', methods: ['GET', 'POST'])]
    public function activationAccount($token, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {   
       
        $user = $userRepository->findOneBy(['token' => $token]);
        if ($user){
           $user->setToken(null);
           $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été activé avec succès !');
            }else{
              
                $this->addFlash('error', 'Un problème technique est survenu!');
            }
            
        
        
        return $this->redirectToRoute('app_login');    
    }


}
