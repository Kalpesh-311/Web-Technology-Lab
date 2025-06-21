<?php
require 'vendor/autoload.php'; // Include MongoDB library

header('Content-Type: application/json');

// MongoDB URI
$uri = "mongodb+srv://kalpeshspatil311:MarieCurie@cluster0.v92k8wj.mongodb.net/pet_care?retryWrites=true&w=majority&appName=Cluster0";

try {
    $client = new MongoDB\Client($uri);
    $collection = $client->pet_care->contact_queries;


    // Read form fields
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validate
    if (!$name || !$email || !$subject || !$message) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Insert into MongoDB
    $collection->insertOne([
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Thank you for contacting us!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Submission failed: ' . $e->getMessage()]);
}
