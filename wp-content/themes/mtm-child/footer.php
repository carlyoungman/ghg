<?php
/*============================================
|	  Footer Component
============================================*/
global $prefix;
?>
</main>
<footer>
  <div class="container-fluid container--max-lg">
    <div class="row">
      <div class="col-12 col-md-5 col-xl-7 footer__branding">
        <a href="/">
          <?= svg('ghg-logo') ?>
        </a>
        <?= yr_socials(true, '') ?>
      </div>
      <div class="col-12 col-md-7 col-xl-5 footer__navs justify-content-end">
        <nav id="footer">
          <?php wp_nav_menu(['theme_location' => 'footer_primary_menu', 'container' => false]) ?>
          <?php wp_nav_menu(['theme_location' => 'footer_secondary_menu', 'container' => false]) ?>
        </nav>
      </div>
    </div>
    <div class="row footer__legals">
      <div class="col-12">
        <p>© <?= date('Y') ?> MTM Injection Moulding & Machining. <br />All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>