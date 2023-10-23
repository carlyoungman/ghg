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
              <?=svg('ghg-logo') ?>
            </a>
            <?=yr_socials(true, '') ?>
          </div>
          <div class="col-12 col-md-7 col-xl-5 footer__navs justify-content-end">
            <nav id="footer">
              <?php wp_nav_menu(['theme_location' => 'footer_menu', 'container' => false]) ?>
              <ul>
                <li><a href="/terms">Terms of use</a></li>
                <li><a href="/privacy-policy">Privacy Policy</a></li>
                <li><a href="/disclaimer">Disclaimer</a></li>
                <li><a href="/accessibility">Accessibility</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="row footer__legals">
          <div class="col-12">
            <p>© <?=date('Y')?> MTM Engineering & Moulding.<br/>All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
