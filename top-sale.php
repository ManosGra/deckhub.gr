
<?php

// Παράδειγμα χρήσης για ενεργά προϊόντα
$activeProducts = [];
$result = getAllActive('products'); // Ανάκτηση όλων των προϊόντων με status 0 (ενεργά προϊόντα)

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Ελέγχει αν το προϊόν έχει top_sale 'yes'
        if ($row['top_sale'] == 'yes') {
            $activeProducts[] = $row;  
        }
    }
} else {
    echo "Δεν βρέθηκαν ενεργά προϊόντα.";
}
?>

<section id="top-sale" class="pb-5 box show">
    <div class="container-lg ">
        <h1 class="text-center font-rubik">Top Sales</h1>

        <hr>

        <div class="owl-carousel owl-theme">
            
            <?php if (empty($activeProducts)): ?>
                <p class="text-center">Δεν υπάρχουν προϊόντα σε προσφορά.</p>
            <?php else: ?>
                <?php foreach ($activeProducts as $product): ?>
                    <div class="item py-2 product_data">
                        <div class="product font-rale d-flex flex-column align-items-center">
                            <a href="product-view.php?product=<?php echo $product['slug'] ?>"><img data-src="uploads/<?php echo $product['item_image']; ?>"
                                    alt="<?php echo $product['name']; ?>" style="width:220px; height:220px;" 
                                    ></a>
                            <div class="text-center my-3">
                                <h6><?php echo $product['name']; ?></h6>
                                <p class="m-0 font-size-20  fw-bold"><?php echo $product['selling_price']; ?>€</p>
                            </div>
                            <button class="btn btn-danger fw-bold font-size-14 addToCartBtn"
                                    value="<?php echo $product['id']; ?>">
                                    <input type="hidden" class="form-control text-center input-qty bg-white" value="1" disabled>
                                    <i
                                        class="bi bi-cart me-2 font-size-20 fw-bold"></i>Add to cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
