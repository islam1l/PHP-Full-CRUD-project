<?php


$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);



$id = $_POST['id'] ?? null;

if(!$id){
    header('location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);
$path = $product['image'];

if (is_file($path)) {
     unlink($path);
     $dir = dirname($path);
      rmdir($dir);
}

$statement = $pdo->prepare('DELETE FROM products WHERE id= :id');
$statement->bindValue(':id', $id);
$statement->execute();
header('Location: index.php');