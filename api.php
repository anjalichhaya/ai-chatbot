<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Test endpoint
if (isset($_GET['test'])) {
    echo json_encode([
        'status' => 'success',
        'message' => 'API working',
        'time' => time()
    ]);
    exit;
}

// Main API
if (isset($_GET['role']) && isset($_GET['prompt'])) {

    $role = trim($_GET['role']);
    $prompt = trim($_GET['prompt']);

    $api_key = "YOUR_API_KEY_HERE"; // 🔴 yaha apni key daal
    $url = "https://api.groq.com/openai/v1/chat/completions";

    $data = [
        "model" => "llama3-70b-8192",
        "messages" => [
            ["role" => "system", "content" => $role],
            ["role" => "user", "content" => $prompt]
        ]
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "Authorization: Bearer $api_key"
        ]
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(["error" => curl_error($ch)]);
        exit;
    }

    curl_close($ch);

    echo $response;
    exit;
}

// Default
echo json_encode(["error" => "Missing params"]);
