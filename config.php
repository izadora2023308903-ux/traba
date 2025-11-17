<?php
session_start();

$DB_HOST = 'localhost';
$DB_NAME = 'petshop'; // mesmo nome do seu banco
$DB_USER = 'root';
$DB_PASS = ''; // senha do MySQL se tiver

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
