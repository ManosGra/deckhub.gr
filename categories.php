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
                        $counter = 1; // Μετρητής για να αλλάζουμε το layout ανά κατηγορία
                    
                        foreach ($categories as $item) {
                            // Ανάλογα με τον μετρητή ορίζουμε τη σωστή κλάση για το column
                            if ($counter == 1 || $counter == 2) {
                                $colClass = "col-md-6"; // Πρώτη και δεύτερη κατηγορία - 2 στήλες (col-6)
                            } elseif ($counter == 3) {
                                $colClass = "col-md-12 "; // Τρίτη κατηγορία - πλήρης σειρά (col-12)
                            } elseif ($counter >= 4 && $counter <= 7) {
                                $colClass = "col-md-4"; // Τέταρτη, πέμπτη, έκτη και έβδομη κατηγορία - 4 στήλες (col-3)
                            } elseif ($counter == 8) {
                                $colClass = "col-md-8"; // Όγδοη κατηγορία - 8 στήλες (col-8)
                            } elseif ($counter == 9 || $counter == 10) {
                                $colClass = "col-md-2"; // Ένατη και δέκατη κατηγορία - 2 στήλες (col-2)
                            }

                            ?>
                            <div class="<?php echo $colClass; ?> my-3">

                                <a class="text-decoration-none" href="products.php?category=<?php echo $item['slug']; ?>">
                                    <div class="meta-title-description">
                                        <img src="uploads/<?php echo $item['category_image']; ?>" alt="Category Image"
                                            class="rounded-4 w-100 box-shadow img-fluid category-bg" style="height:400px">
                                        <h4 class="meta-title-hashtag font-size-25 fw-bold"><?php echo $item['meta_title']; ?></h4>
                                    </div>
                                </a>

                            </div>
                            <?php
                            $counter++;

                            // Μηδενίζουμε τον μετρητή μετά την 10η κατηγορία για να επαναληφθεί το μοτίβο
                            if ($counter > 10) {
                                $counter = 1;
                            }
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