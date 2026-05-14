document.addEventListener('DOMContentLoaded', function () {
  // Hamburger Menu Toggle
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.getElementById('navLinks');

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', function () {
      hamburger.classList.toggle('open');
      navLinks.classList.toggle('open');
    });

    // Close mobile menu when a nav link is clicked
    const links = navLinks.querySelectorAll('a');
    links.forEach(function (link) {
      link.addEventListener('click', function () {
        hamburger.classList.remove('open');
        navLinks.classList.remove('open');
      });
    });
  }
  // Toast Auto-Dismiss
  const toasts = document.querySelectorAll('.toast');
  toasts.forEach(function (toast) {
    // Auto-dismiss after 5 seconds
    setTimeout(function () {
      toast.classList.add('toast-dismiss');
      // Remove from DOM after animation completes
      setTimeout(function () {
        toast.remove();
      }, 300);
    }, 5000);
  });
  // Smooth Scroll for Anchor Links
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

});
