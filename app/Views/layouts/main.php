<?php
/**
 * Main Layout
 * Base HTML skeleton that wraps all pages.
 * Variables expected: $pageTitle, $pageDesc, $currentPage, $contentView
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require APP_ROOT . '/app/Views/partials/header.php'; ?>
</head>
<body>

  <?php require APP_ROOT . '/app/Views/partials/navbar.php'; ?>

    <?php if ($successMsg = getFlash('success')): ?>
    <div class="toast toast-success" id="toastNotification">
      <div class="toast-content">
        <span class="toast-icon">✓</span>
        <span class="toast-message"><?= e($successMsg) ?></span>
      </div>
      <button class="toast-close" onclick="this.parentElement.remove()" aria-label="Close">&times;</button>
    </div>
  <?php endif; ?>

  <?php
    $flashErrors = getFlash('errors', []);
    if (!empty($flashErrors) && isset($flashErrors['form'])):
  ?>
    <div class="toast toast-error" id="toastNotification">
      <div class="toast-content">
        <span class="toast-icon">!</span>
        <span class="toast-message"><?= e($flashErrors['form']) ?></span>
      </div>
      <button class="toast-close" onclick="this.parentElement.remove()" aria-label="Close">&times;</button>
    </div>
  <?php
    // Re-flash field-level errors so the page view can still access them
    if (count($flashErrors) > 1) {
        $fieldErrors = $flashErrors;
        unset($fieldErrors['form']);
        // $fieldErrors is now available to the page view below
    }
    endif;

    // If there are only field-level errors (no 'form' key), pass them through
    if (!empty($flashErrors) && !isset($flashErrors['form'])) {
        $fieldErrors = $flashErrors;
    }

    // Ensure $fieldErrors is always set
    if (!isset($fieldErrors)) {
        $fieldErrors = [];
    }
  ?>

    <main>
    <?php require $contentView; ?>
  </main>

  <?php require APP_ROOT . '/app/Views/partials/footer.php'; ?>

</body>
</html>
