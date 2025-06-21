<?php

require __DIR__ . '/vendor/autoload.php'; // Composer autoloader

$uri = 'mongodb+srv://kalpeshspatil311:MarieCurie@cluster0.v92k8wj.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0';

try {
    $client = new MongoDB\Client($uri);
    $dbs = $client->listDatabases();
    echo "Connected successfully. Databases:\n";
    foreach ($dbs as $db) {
        echo $db->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}