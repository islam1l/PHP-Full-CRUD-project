<?php

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);