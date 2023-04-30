<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = 'Products List';
    include ROOT . '/views/layouts/header.render.php';
    ?>
</head>
<body class="container">
<header>
    <div class="row">
        <div class="col header-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="col header-right ">
           <div class="row float-end">
            <div class="col-6">
            <a class="btn btn-primary float-end" href="/add-product">ADD</a>
                
            </div>
            <div class="col-6">
            <a class="btn btn-danger" id="delete-product-btn">MASS DELETE</a>
            </div>
           </div>
        </div>
    </div>
    <hr>
</header>
<main>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <form id="product_form" action="/" method="post">
        <div class="row">
            <?php foreach ($data as $product) : ?>
                <div class="col-sm-3 card-<?= $product['id']; ?>">
                    <div class="card product-card hvr-round-corners hvr-border-fade hvr-grow">
                        <div class="card-body">
                            
                            <div class="product-card-body">
                                <p class="product-card-text"><?= $product['sku']; ?></p>
                                <p class="product-card-text"><?= $product['name']; ?></p>
                                <p class="product-card-text"><?= $product['price'] . ' $'; ?></p>
                                <p class="product-card-text"><?= $product['property']; ?></p>
                            </div>
                            <label>
                                <input type="checkbox" class="delete-checkbox" name="product-<?= $product['id']; ?>" value="<?= $product['id']; ?>">
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
</main>
<?php include ROOT . '/views/layouts/footer.render.php'; ?>
<script src="<?=BASE_URL . 'assets/js/main.js'?>"></script>
</body>
</html>