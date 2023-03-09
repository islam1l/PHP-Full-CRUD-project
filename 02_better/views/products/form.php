<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach($errors as $error): ?>
            <div><?= $error; ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <?php if($product['image']): ?>
        <img src="/<?=$product['image'];?>" class="update-image">
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