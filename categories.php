<?php include 'functions/userfunctions.php'; ?>

<section id="categories" class="box show">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <h1 class="font-rubik text-center">Collections</h1>
                <hr />
                <div class="row">
                    <?php
                    $categories = getAllActive("product_categories");

                    if (mysqli_num_rows($categories) > 0) {
                        foreach ($categories as $item) {
                            // Ορισμός της κλάσης σε col-md-6 για όλες τις κατηγορίες
                            $colClass = "col-md-6"; // Όλες οι κατηγορίες - 2 στήλες (col-6)
                            ?>
                            <div class="<?php echo $colClass; ?> my-3">
                                <a class="text-decoration-none" href="products?category=<?php echo $item['slug']; ?>">
                                    <div class="meta-title-description">
                                        <img data-src="uploads/<?php echo $item['category_image']; ?>" alt="Category Image"
                                            class="rounded-4 w-100 box-shadow img-fluid category-bg" style="height:356px">
                                        <h4 class="meta-title-hashtag font-size-25 fw-bold"><?php echo $item['meta_title']; ?></h4>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No data available";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
