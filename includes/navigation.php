<nav class="text-white navigation <?php echo isset($is_main_page) ? 'main-nav' : 'other-nav'; ?>">
  <div class="container-lg">
    <div class="row align-items-center justify-content-between py-4">

      <div class="col-2 col-md-auto">
        <a class="navbar-brand text-white font-rubik" href="http://deckhub.local/">Eshop</a>
      </div>

      <div class="col-8 col-md-9">
        <ul class="nav-items d-flex align-items-center justify-content-center font-rubik m-0 p-0">
          <?php
          // Εκτέλεση του ερωτήματος για να πάρουμε τις κατηγορίες προϊόντων
          $query = "SELECT * FROM product_categories";
          $select_categories_query = mysqli_query($conn, $query);

          // Έλεγχος αν η ερώτηση εκτελέστηκε επιτυχώς
          if (!$select_categories_query) {
            die("QUERY FAILED: " . mysqli_error($conn));
          }

          // Εμφάνιση των κατηγοριών
          if (mysqli_num_rows($select_categories_query) > 0) {
            // Επαναλαμβάνει τις γραμμές από το αποτέλεσμα της ερώτησης
            while ($item = mysqli_fetch_assoc($select_categories_query)) {
              ?> 
              <li class="nav-item list-unstyled mx-3 font-rubik font-size-16">
                <a class="nav-link" href="products?category=<?php echo htmlspecialchars($item['slug']); ?>">
                  <?php echo htmlspecialchars($item['category_name']); ?>
                </a>
              </li>
              <?php
            }
          } else {
            echo "<li class='nav-item list-unstyled mx-3'>Δεν βρέθηκαν κατηγορίες</li>";
          }
          ?>
        </ul>

      </div>

      <div class="col-2 col-md-auto">
        <div class="row align-items-center justify-content-end">

          <div class="col-auto">
            <button type="submit" id="openSearch" name="submit" class="search-button p-0">
              <i class="bi bi-search font-size-25"></i>
            </button>
          </div>

          <div class="col-auto">
            <a href="my-account" class="text-white text-decoration-none">
              <i class="font-size-25 profile bi bi-person-circle"></i>
            </a>
          </div>

          <div class="col-auto">
            <form action="" class="font-size-14 font-rale">
              <a href="cart" class="text-decoration-none" id="cart-link">
                <div class="cart-object">
                  <span class="font-size-25 text-white"><i class="bi bi-cart cart-icon"></i></span>
                  <span class="pill text-white bg-danger" id="cart-empty">0</span>
                </div>
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="searchPopup" class="popup">
    <div class="popup-content">
      <span id="closePopup" class="close">&times;</span>

      <!-- Το search container που θες να κάνεις popup -->
      <div class="search-container">
        <form class="d-flex align-items-center" action="search" method="POST">
          <input type="text" placeholder="Αναζήτηση..." name="search" class="search-input" required>
          <button type="submit" name="submit" hidden>Search</button>
        </form>
      </div>
    </div>
  </div>

</nav>

<div class="responsive-nav py-3 px-2 d-md-none">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>
      <ul class="nav-items nav-menu p-0">
        <?php
        // Εκτέλεση του ερωτήματος για να πάρουμε τις κατηγορίες προϊόντων
        $query = "SELECT * FROM product_categories";
        $select_categories_query = mysqli_query($conn, $query);

        if (!$select_categories_query) {
          die("QUERY FAILED: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($select_categories_query) > 0) {
          while ($item = mysqli_fetch_assoc($select_categories_query)) {
            ?>
            <li class="nav-item list-unstyled font-rubik fw-bold font-size-14">
              <a class="nav-link mt-3" href="products?category=<?php echo htmlspecialchars($item['slug']); ?>">
                <?php echo htmlspecialchars($item['category_name']); ?>
              </a>
            </li>
            <?php
          }
        } else {
          echo "<li class='nav-item list-unstyled mx-3'>Δεν βρέθηκαν κατηγορίες</li>";
        }
        ?>
      </ul>
    </div>

    <div class="col-auto">
      <a class="navbar-brand text-white font-rubik" href="http://eshop.local/">Eshop</a>
    </div>

    <div class="col-auto">
      <div class="row align-items-center justify-content-end g-0 font-size-25">
        <div class="col-auto">
          <a href="my-account" class="text-white text-decoration-none ">
            <i class="profile bi bi-person-circle"></i>
          </a>
        </div>
        <div class="col-auto">
          <form action="" class="font-rale">
            <a href="cart" class="text-decoration-none" id="cart-link">
              <div class="cart-object">
                <span class="px-2 text-white"><i class="bi bi-cart cart-icon ms-2"></i></span>
              </div>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>