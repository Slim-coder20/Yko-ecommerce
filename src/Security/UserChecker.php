<?php 

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface

{   // cette méthode est applee avant la vérfication de l'utilisateur // 
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if ($user->getToken() != NULL) {
            // C'est un message qui sera envoyé a l'utilisateur pour activé son compte via le lien d'activation qu'il a reçu par mail //
            throw new CustomUserMessageAccountStatusException('Ce compte n\'est pas encore activé.');
        }
    }
   
    
    
    // cette méthode est applee après la vérfication de l'utilisateur //

    public function checkPostAuth(UserInterface $user): void
    {
        // if (!$user instanceof AppUser) {
        //     return;
        // }

        // // user account is expired, the user may be notified
        // if ($user->isExpired()) {
        //     throw new AccountExpiredException('...');
        // }

        // if (!\in_array('foo', $token->getRoleNames())) {
        //     throw new AccessDeniedException('...');
        // }
    }

}

