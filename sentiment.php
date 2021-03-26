<?php
require_once __DIR__ . '/vendor/autoload.php';
$sentiment = new \PHPInsight\Sentiment();

$msg = $_GET['msg'];

$scores = $sentiment->score($msg);

header('Content-Type: application/json');
echo json_encode($scores);
