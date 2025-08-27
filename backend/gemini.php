<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;

function getSQLFromGemini($question, $dbSchema) {
    $client = new Client();
    $apiKey = $_ENV['GEMINI_API_KEY'];
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    $prompt = "Você é um tradutor de linguagem natural para SQL. Com base no esquema do banco de dados a seguir, converta a pergunta do usuário para uma consulta SQL válida. Não adicione nenhum texto adicional, apenas a consulta SQL.

Esquema do banco de dados:
$dbSchema

Pergunta do usuário:
$question

Consulta SQL:";

    $body = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $response = $client->post($url, [
        'headers' => [
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json'
        ],
        'json' => $body
    ]);

    $data = json_decode($response->getBody(), true);
    $rawSql = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

    // Sanitização: pega apenas o trecho a partir do primeiro comando SQL
    if (preg_match('/(SELECT|INSERT|UPDATE|DELETE)[\s\S]+/i', $rawSql, $matches)) {
        $sanitizedSql = trim($matches[0]);
    } else {
        $sanitizedSql = trim($rawSql);
    }

    $sanitizedSql = preg_replace('/```$/', '', $sanitizedSql);
    $sanitizedSql = rtrim($sanitizedSql);

    return $sanitizedSql;
}
?>