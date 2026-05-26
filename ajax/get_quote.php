<?php
// AJAX endpoint - proxies external Web API (advice slip) server-side
session_start();
require_once '../helpers.php';

header('Content-Type: application/json');

$apiUrl = 'https://api.adviceslip.com/advice';

try {
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'GET',
            'timeout' => 5,
            'header'  => "User-Agent: BrainBoost/1.0\r\n",
        ],
    ]);

    $raw = @file_get_contents($apiUrl, false, $ctx);

    if ($raw === false) {
        throw new Exception('External API not reachable');
    }

    $data = json_decode($raw, true);

    if (!isset($data['slip']['advice'])) {
        throw new Exception('Invalid API response');
    }

    echo json_encode([
        'success' => true,
        'quote'   => sanitize($data['slip']['advice']),
        'author'  => 'Advice Slip API',
    ]);
} catch (Exception $e) {
    error_log('AJAX get_quote error: ' . $e->getMessage());
    echo json_encode([
        'success' => true,
        'quote'   => 'The expert in anything was once a beginner.',
        'author'  => 'Helen Hayes',
    ]);
}
