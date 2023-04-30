<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = 'Product Add';
    include ROOT . '/views/layouts/header.render.php';
    ?>
</head>
<body class="container">
<div id="loader-overlay" class="loader-overlay">
  <div id="loader" class="loader"></div>
</div>
<header>
    <div class="row">
        <div class="col header-left">
            <h2><?= $title ?></h2>
        </div>
        <div class="col header-right">
            <div class="float-end">
                <a class="btn btn-primary" id="submit-btn">Save</a>
                <a class="btn btn-secondary" href="/">Cancel</a>
            </div>
        </div>
    </div>
    <hr>
</header>

<main>

    <form id="product_form" action="/add-product" method="post">
        <div class="col-sm-6">
            <div class="mb-3 row">
                <label for="sku" class="col-sm-2 col-form-label">SKU <span class="red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="sku" id="sku" required>
                </div>
                
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Name <span class="red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 row">
                <label for="price" class="col-sm-2 col-form-label">Price ($) <span class="red">*</span></label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="price" id="price" required> 
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="mb-3 row">
                <label for="productType" class="col-sm-2 col-form-label">Product Type <span class="red">*</span></label>
                <div class="col-sm-4">
                    <select class="form-control" name="productType" id="productType" required>
                        <option value="" selected disabled>Type</option>
                        <option value="dvd">DVD</option>
                        <option value="book">Book</option>
                        <option value="furniture">Furniture</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-8" id="properties"></div>
    </form>
</main>
<?php unset($_SESSION['errors']); ?>
<?php include ROOT . '/views/layouts/footer.render.php'; ?>
<script src="<?=BASE_URL . 'assets/js/add.js'?>"></script>
</body>
</html>