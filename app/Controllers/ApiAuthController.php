<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function login()
    {
        if ($this->method() !== 'POST') {
            return $this->json(['error' => 'Método não permitido'], 405);
        }

        $data = $this->request();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            return $this->json(['error' => 'E-mail e senha são obrigatórios'], 422);
        }

        if (!Auth::attempt($email, $password)) {
            return $this->json(['error' => 'Credenciais inválidas'], 401);
        }

        $user = Auth::user();
        return $this->json(['data' => $this->formatUser($user)]);
    }

    public function logout()
    {
        Auth::logout();
        return $this->json(['message' => 'Logout realizado com sucesso']);
    }

    public function me()
    {
        if (!Auth::check()) {
            return $this->json(['error' => 'Não autenticado'], 401);
        }

        $user = Auth::user();
        return $this->json(['data' => $this->formatUser($user)]);
    }

    private function formatUser(?array $user): ?array
    {
        if (!$user) {
            return null;
        }

        return [
            'id' => $user['id'],
            'nome' => $user['nome'],
            'email' => $user['email'],
            'perfil' => $user['perfil'],
            'status' => $user['status'],
        ];
    }

    protected function json(array $data, int $statusCode = 200): string
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        return json_encode($data);
    }

    protected function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    protected function request(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        return is_array($data) ? $data : [];
    }
}
