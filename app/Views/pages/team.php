<?php
/**
 * Team Page View
 * Displays the full team grid with all members.
 * This is the page-specific content included by the main layout.
 */
?>

<section class="section team-page-section">
  <div class="container">
    <h2 class="section-title text-center">Our <span class="accent">Team</span></h2>
    <div class="team-grid-full">
      <?php if (!empty($teamMembers)): ?>
        <?php foreach ($teamMembers as $member): ?>
          <div class="profile-card">
            <img src="<?= $member['image_url'] ? e($member['image_url']) : asset('images/default-avatar.png') ?>" alt="<?= e($member['full_name']) ?>" class="avatar" />
            <h3><?= e($member['full_name']) ?></h3>
            <p class="title" style="color:#00ffcc; font-weight:bold; font-size:0.9em; margin-bottom:10px;"><?= e($member['role']) ?></p>
            <p style="font-size:0.85em; color:#ccc;"><?= e($member['department']) ?></p>
            <div class="social-links" style="margin-top:15px;">
              <a href="mailto:<?= e($member['email']) ?>">✉</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="color:#ccc;">The team list is currently being updated.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
