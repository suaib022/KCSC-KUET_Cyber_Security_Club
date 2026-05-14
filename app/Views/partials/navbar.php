<?php
/**
 * Navbar Partial
 * Reusable navigation bar. Highlights the active page link.
 * Variables expected: $currentPage
 */
?>
<header class="navbar" id="navbar">
  <div class="nav-container">

        <div class="nav-logo">
      <a href="<?= url('index.php') ?>" style="text-decoration:none;">
        <span class="logo-bracket">[</span>
        <span class="logo-text">KCSC</span>
        <span class="logo-bracket">]</span>
      </a>
    </div>

        <nav class="nav-links" id="navLinks">
      <a href="<?= url('index.php') ?>#about"<?= ($currentPage === 'home') ? ' style="color:#e0e0e0;"' : '' ?>>About</a>
      <a href="<?= url('index.php') ?>#activities">Activities</a>
      <a href="<?= url('team.php') ?>"<?= ($currentPage === 'team') ? ' style="color:#e0e0e0;"' : '' ?>>Team</a>
      <a href="<?= url('index.php') ?>#events">Events</a>
      <a href="<?= url('index.php') ?>#contact">Contact</a>
      <a href="<?= url('join.php') ?>" class="btn-join">Join Now</a>
    </nav>

        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</header>
