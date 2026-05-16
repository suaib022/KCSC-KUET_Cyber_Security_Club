<?php
/**
 * Homepage View
 * Contains: Hero, About, Activities, Events, Team Preview, Contact sections.
 * This is the page-specific content included by the main layout.
 */
?>

<section class="hero" id="home">
  <div class="hero-content">

    <p class="hero-tag">&lt; KUET Cyber Security Club /&gt;</p>

    <h1 class="hero-heading">
      Defending the<br />
      <span class="accent">Digital Frontier</span><br />
      at KUET
    </h1>

    <p class="hero-sub">
      Learn. Hack. Secure. — Join a community of ethical hackers,
      security researchers, and CTF enthusiasts at KUET.
    </p>

    <div class="hero-buttons">
      <a href="<?= url('join.php') ?>" class="btn-primary">Join the Club</a>
      <a href="#about" class="btn-secondary">Learn More</a>
    </div>

        <div class="hero-stats">
      <div class="stat">
        <span class="stat-num">50+</span>
        <span class="stat-label">Active Members</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">10+</span>
        <span class="stat-label">CTF Events</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat">
        <span class="stat-num">2025</span>
        <span class="stat-label">Founded</span>
      </div>
    </div>

  </div>

  <div class="hero-grid-overlay"></div>
</section>

<section class="section about" id="about">
  <div class="container flex-row">
    <div class="about-visual">
            <div class="terminal-window">
        <div class="terminal-header">
          <span class="dot red"></span>
          <span class="dot yellow"></span>
          <span class="dot green"></span>
        </div>
        <div class="terminal-body">
          <p>user@kcsc:~$ whoami</p>
          <p>KUET Cyber Security Club</p>
          <p>user@kcsc:~$ ./mission.sh</p>
          <p>Raising awareness, CTF training, ethical hacking.</p>
          <p class="cursor">_</p>
        </div>
      </div>
    </div>
    <div class="about-text">
      <h2 class="section-title">About <span class="accent">KCSC</span></h2>
      <p>The KUET Cyber Security Club (KCSC) is dedicated to fostering a community of cybersecurity enthusiasts at Khulna University of Engineering &amp; Technology.</p>
      <p>Our core mission is to raise digital security awareness, provide comprehensive training for Capture The Flag (CTF) competitions, and promote ethical hacking practices among students.</p>
    </div>
  </div>
</section>

<section class="section activities bg-alt" id="activities">
  <div class="container">
    <h2 class="section-title text-center">What We <span class="accent">Do</span></h2>
    <div class="grid-features">
      <div class="feature-card">
        <h3>CTF</h3>
        <p>Participating and training for national and international CTF competitions.</p>
      </div>
      <div class="feature-card">
        <h3>Workshops &amp; Seminars</h3>
        <p>Hands-on sessions on cryptography, web exploitation, and network security.</p>
      </div>
      <div class="feature-card">
        <h3>Bug Bounty</h3>
        <p>Learning responsible disclosure and hunting for vulnerabilities.</p>
      </div>
      <div class="feature-card">
        <h3>Awareness Campaigns</h3>
        <p>Educating the campus community on digital safety.</p>
      </div>
    </div>
  </div>
</section>

<section class="section events" id="events">
  <div class="container">
    <h2 class="section-title text-center">Upcoming <span class="accent">Events &amp; Notices</span></h2>
    <div class="events-notices-container">

      <?php if (!empty($notices)): ?>
        <?php foreach ($notices as $notice): ?>
        <div class="notice-banner">
          <p><strong><?= htmlspecialchars($notice['title']) ?>:</strong> <?= htmlspecialchars($notice['content']) ?></p>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <div class="event-cards">
        <?php if (!empty($events)): ?>
          <?php foreach ($events as $event): ?>
          <div class="event-card">
            <div class="event-details">
              <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
              <p class="event-meta">📅 <?= htmlspecialchars(date('M d, Y', strtotime($event['event_date']))) ?> | <?= htmlspecialchars($event['description']) ?></p>
            </div>
            <a href="#" class="btn-primary">Register</a>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="color: #aaa;">No upcoming events at the moment.</p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<section class="section team bg-alt" id="team">
  <div class="container">
    <h2 class="section-title text-center">Executive <span class="accent">Panel</span></h2>
    <div class="grid-team">
      <?php if (!empty($teamMembers)): ?>
        <?php foreach (array_slice($teamMembers, 0, 4) as $member): ?>
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
    <div class="team-action text-center" style="margin-top: 30px;">
      <a href="<?= url('team.php') ?>" class="btn-primary">View Full Team</a>
    </div>
  </div>
</section>

<section class="section contact" id="contact">
  <div class="container text-center">
    <h2 class="section-title">Ready to secure the web?</h2>
    <p class="contact-text">Join KCSC today and become a part of KUET's elite cybersecurity community.</p>
    <a href="<?= url('join.php') ?>" class="btn-primary btn-large">Join KCSC Form</a>
    <p class="contact-info">Contact us: <a href="mailto:info@kcsc.kuet.ac.bd" class="accent">info@kcsc.kuet.ac.bd</a></p>
  </div>
</section>
