<?php

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$imagePath = '';

if(!$title){
    $errors[] = 'Product Title is Required.';
}
if(!$price){
    $errors[] = 'Product Price is Required.';
}
if(!is_dir(__DIR__ . '/public/images')){
    mkdir(__DIR__ . '/public/images');
}
if(empty($errors)){
    $imagePath = $product['image'];
    $image = $_FILES['image'] ?? null;

    if($image['name']){

        if ($product['image']) {
            unlink(__DIR__ .'/public/'. $product['image']);
            $dir = dirname($product['image']);
            rmdir($dir);
        }

        $imagePath = 'images/'. randPath(8).'/' . $image['name'];
        mkdir(dirname(__DIR__ .'/public/'.$imagePath));
        move_uploaded_file($image['tmp_name'], __DIR__ .'/public/'.$imagePath);
}}

