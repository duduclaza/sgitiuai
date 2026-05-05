<?php

/**
 * Servidor combinado: React SPA + PHP API
 * 
 * Este arquivo serve como ponto de entrada para servir:
 * 1. A aplicação React (dist/index.html)
 * 2. Os arquivos estáticos (dist/js, dist/assets, etc)
 * 3. A API PHP (/api/*)
 */

// Paths
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = str_replace('/dist', '', $requestUri);
$distPath = __DIR__ . '/dist';

// 1. Se for requisição de API, roteia para o PHP
if (strpos($requestPath, '/api') === 0) {
    // Remove /dist do caminho se houver
    $_SERVER['REQUEST_URI'] = $requestPath;
    require __DIR__ . '/public/index.php';
    exit;
}

// 2. Se for um arquivo estático, serve
$filePath = $distPath . $requestPath;
if (is_file($filePath)) {
    // Definir content-type correto
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'js' => 'application/javascript',
        'css' => 'text/css',
        'html' => 'text/html',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
    ];
    
    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
    }
    
    // Cache headers para assets
    if (strpos($requestPath, '/assets/') !== false || strpos($requestPath, '/js/') !== false) {
        header('Cache-Control: public, max-age=31536000, immutable');
    }
    
    readfile($filePath);
    exit;
}

// 3. Se for diretório, redireciona
if (is_dir($filePath) && !empty($requestPath) && $requestPath !== '/') {
    header('Location: ' . rtrim($requestPath, '/') . '/', true, 301);
    exit;
}

// 4. Para tudo mais, serve o index.html do React (SPA)
header('Content-Type: text/html; charset=utf-8');
readfile($distPath . '/index.html');
