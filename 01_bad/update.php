<?php

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if(!$id){
    header('location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

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
        $imagePath = $product['image'];
        $image = $_FILES['image'] ?? null;


        if($image['name']){

            if ($product['image']) {
                unlink($product['image']);
                $dir = dirname($product['image']);
                rmdir($dir);
            }

            $imagePath = 'images/'. randPath(8).'/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement = $pdo->prepare("UPDATE products 
            SET title = :title, image = :image, description = :description, 
                price = :price
                WHERE id = :id"
        );
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
    header('location: index.php');
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
<p>
    <a href="index.php" class="btn btn-secondary">Go Back to Products</a>
</p>
<h1>Update Product <b><?= $product['title'];?></b></h1>
<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach($errors as $error): ?>
            <div><?= $error; ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <?php if($product['image']): ?>
        <img src="<?=$product['image'];?>" class="update-image">
    <?php endif; ?>
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


