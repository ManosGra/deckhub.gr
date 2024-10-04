<footer id="footer" class=" text-white pt-5 pb-4 box show">
  <div class="container-lg">
    <div class="row footer">

      <div class="col-lg-2 col-12 mb-2 ">
        <h4 class="fw-bold  font-size-20">Πληροφορίες</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Σχετικά με εμάς</a>
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Φόρμα Επικοινωνίας</a>
        </div>
      </div>

      <div class="col-lg-3 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Χρήσιμα</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Τρόποι πληρωμής</a>
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">Τρόποι αποστολής</a>
          <a href="#" class="text-decoration-none  font-size-14 text-white-50 pb-1">'Οροι χρήσης</a>
        </div>
      </div>

      <div class="col-lg-3 col-12 mb-2 ">
        LOGO
      </div>

      <div class="col-lg-2 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Λογαριασμός</h4>
        <div class="d-flex flex-column flex-wrap">
          <a href="my-account.php" class="text-decoration-none  font-size-14 text-white-50 pb-1">Ο λογαριασμός μου</a>
          <a href="my-account.php?source=orders"
            class="text-decoration-none  font-size-14 text-white-50 pb-1">Παραγγελίες</a>
          <a href="my-account.php?source=edit-profile"
            class="text-decoration-none  font-size-14 text-white-50 pb-1">Διευθύνσεις</a>
        </div>
      </div>

      <div class="col-lg-2 col-12 mb-2">
        <h4 class="fw-bold font-size-20">Επικοινωνία</h4>
        <div class="d-flex flex-column flex-wrap">
          <p href="#" class=" font-size-14 text-white-50 pb-1 text-decoration-none m-0">Phone 210 1234567</p>
          <p href="#" class=" font-size-14 text-white-50 pb-1 text-decoration-none ">Viber: 6971762734<br>
            (Μόνο γραπτά μηνύματα)</p>
          <p href="#" class=" font-size-14 text-white-50 pb-1 text-decoration-none m-0">Email: info@gmail.com</p>
          <h5 class="my-2">Ωράριο Λειτουργίας</h5>
          <p href="#" class=" font-size-14 text-white-50 pb-1 text-decoration-none m-0">Δευτέρα έως Παρασκευή:
            15:30-17:30</p>
        </div>
      </div>
    </div>
  </div>

  <div class="copyright text-center">
    <p class="font-rale font-size-14 pt-4 m-0">&copy;Copyright 2024. Design By <a href="#" class="color-second">Manos
        Grammos</a></p>
  </div>
</footer>

<!-- jQuery (Must be loaded first) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"
  integrity="sha512-k2WPPrSgRFI6cTaHHhJdc8kAXaRM4JBFEDo1pPGGlYiOyv4vnA0Pp0G5XMYYxgAPmtmv/IIaQA6n5fLAyJaFMA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!----ALLERTIFY JS --->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>

    <?php

    if (isset($_SESSION['message'])) { ?>

    alertify.alert('<?php echo $_SESSION['message']; ?>');
    alertify.success('<?php echo $_SESSION['message']; ?>');

    <?php unset($_SESSION['message']);
    } ?>
</script>

<!-- Your Custom JS -->
<script src="index.js"></script>

<script>
    $(document).ready(function () {
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 1
      });
    });
</script>
</body>

</html>