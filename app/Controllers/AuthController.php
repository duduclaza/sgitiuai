<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Services\AuditLogger;

class AuthController extends Controller
{
    public function login(): void
    {
        if (Auth::check()) {
            redirect('/dashboard');
        }

        $this->authView('auth/login', ['title' => 'Entrar']);
    }

    public function authenticate(): void
    {
        verify_csrf();
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['senha'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            flash('error', 'Informe um e-mail válido e sua senha.');
            set_old($_POST);
            redirect('/login');
        }

        if (!Auth::attempt($email, $password)) {
            flash('error', 'E-mail, senha ou status do usuário inválido.');
            set_old(['email' => $email]);
            redirect('/login');
        }

        AuditLogger::log('login', 'usuarios', Auth::id());
        flash('success', 'Bem-vindo ao sistema.');
        redirect('/dashboard');
    }

    public function forgot(): void
    {
        $this->authView('auth/forgot', ['title' => 'Recuperar senha']);
    }

    public function forgotSend(): void
    {
        verify_csrf();
        flash('success', 'Se o e-mail existir, o administrador poderá gerar uma nova senha para você.');
        redirect('/login');
    }

    public function logout(): void
    {
        verify_csrf();
        AuditLogger::log('logout', 'usuarios', Auth::id());
        Auth::logout();
        flash('success', 'Sessão encerrada com segurança.');
        redirect('/login');
    }
}
