<?php
/** @var $pdo PDO */
require_once "../../database.php";
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


<?php include_once "../../views/partials/header.php";?>

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
                <img src="/<?=$product['image'];?>" class="thumb-image">
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
