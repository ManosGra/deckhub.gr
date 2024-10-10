<?php include 'functions/userfunctions.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>

<?php
if (isset($_GET['category'])) {
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("product_categories", $category_slug);
    $category = mysqli_fetch_array($category_data);

    if ($category) {

        $cid = $category['category_name'];
        ?>

        <section id="products" class="box show">
            <div class="container-lg">
                <h6><a class="text-decoration-none" href="index">Home/ </a><?php echo $category['category_name']; ?></h6>
                <div class="row">
                    <div class="col-lg-2 col-12">
                        <?php include 'filters.php' ?>
                    </div>

                    <div class="col-md-10">
                        <h1 class="font-rubik text-center">
                            <?php echo $category['category_name']; ?>
                        </h1>
                        <hr>
                        <div class="row products-container">
                            <?php
                            $products = getProdByCategory($cid);

                            if (mysqli_num_rows($products) > 0) {
                                foreach ($products as $item) {
                                    ?>
                                    <div class="col-md-4 mb-3  product-col">
                                        <div class="card shadow-lg product-box product_data pt-3">
                                            <div class="card-body p-0">
                                                <div class="product-image">
                                                    <a class="text-decoration-none"
                                                        href="product-view?product=<?php echo $item['slug'] ?>"><img
                                                            src="uploads/<?php echo $item['item_image'] ?>" alt="Product Image"
                                                            class="w-100 p-3" style="height:300px"></a>
                                                </div>

                                                <div class="product-price">
                                                    <p class="font-size-25 fw-bold text-center mb-1">
                                                        <?php echo $item['selling_price']; ?>€
                                                    </p>
                                                </div>

                                                <div class="product-info">
                                                    <a class="text-decoration-none"
                                                        href="product-view?product=<?php echo $item['slug'] ?>">
                                                        <p class="text-center font-size-20 text-dark px-3 mb-1">
                                                            <?php echo $item['name']; ?>
                                                        </p>
                                                    </a>

                                                    <p class="text-center"><small>Διαθέσιμα:
                                                            <?php echo $item['qty']; ?>
                                                        </small>+</p>
                                                </div>

                                                <div class="product-btns d-flex flex-row align-items-center justify-content-around">
                                                    <a href="product-view?product=<?php echo $item['slug'] ?>"
                                                        class="text-decoration-none product-btn w-100 text-center p-2"><i
                                                            class="bi bi-search text-white font-size-20"></i></a>

                                                    <button class="product-btn addToCartBtn w-100 text-center p-2"
                                                        value="<?php echo $item['id']; ?>"><input type="hidden"
                                                            class="form-control text-center input-qty bg-white" value="1" disabled><i
                                                            class="bi bi-cart text-white font-size-20"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "No products available";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    } else {
        echo "Something went wrong";
    }
} else {
    echo "Something went wrong";
}
?>

<?php include 'includes/footer.php'; ?>