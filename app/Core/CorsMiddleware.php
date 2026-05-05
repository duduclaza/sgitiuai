<?php

namespace App\Core;

/**
 * Middleware para configurar CORS e headers de segurança
 * Deve ser executado antes do roteamento
 */
class CorsMiddleware
{
    public static function handle(): void
    {
        // Headers de segurança
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // CORS headers (se necessário)
        $allowedOrigins = [
            'http://localhost:5173',  // Desenvolvimento
            'http://localhost:8000',  // Local testing
            'https://sgi.tiuai.com.br', // Produção
        ];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origin, $allowedOrigins, true)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            header('Access-Control-Max-Age: 86400');
        }

        // Responder a preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        // Content-Type para API
        if (strpos($_SERVER['REQUEST_URI'], '/api') === 0) {
            header('Content-Type: application/json; charset=utf-8');
        }
    }
}
