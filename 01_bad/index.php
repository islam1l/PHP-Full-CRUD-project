<?php

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'islam', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? null;

if($search){
    $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
    $statement->bindValue(':title', "%$search%");
}else{
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}



$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products CRUD</title>
</head>
<body>
<h1>Products CRUD</h1>

<p>
    <a href="create.php" class="btn btn-success">Create Product</a>
</p>
<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search For Products" name="search" value="<?= $search;?>">
        <button class="btn btn-outline-secondary" type="submit" >Search</button>
    </div>
</form>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $key => $product): ?>
        <tr>
            <th scope="row"><?=$key + 1;?></th>
            <td>
                <img src="<?=$product['image'];?>" class="thumb-image">
            </td>
            <td><?=$product['title'];?></td>
            <td><?=$product['price'];?></td>
            <td><?=$product['create_date'];?></td>
            <td>
                <a href="update.php?id=<?= $product['id'];?>" class="btn btn-sm btn-outline-primary">Edit</a>
                <form style="display: inline-block" method="post" action="delete.php">
                    <input type="hidden" name="id" value="<?= $product['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>

            </td>
        </tr>
    <?php endforeach;?>

    </tbody>
</table>

</body>
</html>
