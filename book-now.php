<?php
require 'vendor/autoload.php';
use MongoDB\Client;

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Connect to MongoDB Atlas
try {
    $client = new Client("mongodb+srv://kalpeshspatil311:MarieCurie@cluster0.v92k8wj.mongodb.net/pet_care?retryWrites=true&w=majority&appName=Cluster0");
    $collection = $client->pet_care->Bookings; // ✅ Make sure this matches your collection name (case-sensitive)
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

// Retrieve POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$res_date = $_POST['res_date'] ?? '';
$res_time = $_POST['res_time'] ?? '';
$service = $_POST['service'] ?? '';

// Validate
if (!$name || !$email || !$res_date || !$res_time || !$service) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Insert booking
try {
    $result = $collection->insertOne([
        'name' => $name,
        'email' => $email,
        'res_date' => $res_date,
        'res_time' => $res_time,
        'service' => $service,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
    echo json_encode(['status' => 'success', 'message' => 'Reservation successful!', 'id' => (string) $result->getInsertedId()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Booking failed: ' . $e->getMessage()]);
}
?>
