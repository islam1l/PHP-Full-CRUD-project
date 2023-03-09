<?php

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


$errors = [];

$title = '';
$price = '';
$description = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');
    if(!$title){
        $errors[] = 'Product Title is Required.';
    }
    if(!$price){
        $errors[] = 'Product Price is Required.';
    }
    if(!is_dir('images')){
        mkdir('images');
    }
    if(empty($errors)){
        $imagePath = '';
        $image = $_FILES['image'] ?? null;
        if($image['name']){
            $imagePath = 'images/'. randPath(8).'/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
    }

    $statement = $pdo->prepare("insert into products (title, image, description, price, create_date) 
                    VALUES (:title, :image, :description, :price, :date)"
);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':date', $date);
    $statement->execute();
        header('location: index.php');
    }

}

function randPath($n){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for($i = 0; $i < $n; $i++){
        $index = rand(0 , strlen($characters) - 1);
        $str.= $characters[$index];
    }
    return $str;
}

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products CRUD</title>
</head>
<body>
<h1>Create New Product</h1>
<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach($errors as $error): ?>
        <div><?= $error; ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <br>
        <input type="file" name="image">
    </div>
    <div class="mb-3">
        <label class="form-label">Product Title</label>
        <input type="text" class="form-control" name="title" value="<?= $title; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Product Description</label>
        <textarea class="form-control" name="description" ><?= $description; ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Price</label>
        <input type="number" step=".01" class="form-control" name="price" value="<?= $price; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
</html>


