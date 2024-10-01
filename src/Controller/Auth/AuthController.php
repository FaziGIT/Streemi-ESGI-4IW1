<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('auth/login.html.twig');
    }

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(): Response
    {
        return $this->render('auth/forgot.html.twig');
    }

    #[Route('/reset-password', name: 'app_reset_password')]
    public function resetPassword(): Response
    {
        return $this->render('auth/reset.html.twig');
    }

    #[Route('/confirm', name: 'app_reset_password_confirm')]
    public function confirmPassword(): Response
    {
        return $this->render('auth/confirm.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
    }
}
