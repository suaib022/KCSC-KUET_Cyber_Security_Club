<?php
/**
 * Escape output to prevent XSS attacks.
 *
 * @param string|null $value The value to escape
 * @return string Escaped HTML-safe string
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate an asset URL path.
 *
 * @param string $path Relative path from public/assets/ (e.g., "css/style.css")
 * @return string Full URL path to the asset
 */
function asset(string $path): string
{
    $baseUrl = rtrim(APP_URL, '/');
    return $baseUrl . '/assets/' . ltrim($path, '/');
}

/**
 * Generate a URL for a page.
 *
 * @param string $path Relative path (e.g., "join.php")
 * @return string Full URL
 */
function url(string $path = ''): string
{
    $baseUrl = rtrim(APP_URL, '/');
    if (empty($path)) {
        return $baseUrl;
    }
    return $baseUrl . '/' . ltrim($path, '/');
}

/**
 * Set a flash message in the session.
 *
 * @param string $key   Flash key (e.g., "success", "error", "errors")
 * @param mixed  $value The message or data to flash
 */
function flash(string $key, $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

/**
 * Get and clear a flash message from the session.
 *
 * @param string $key     Flash key
 * @param mixed  $default Default value if key doesn't exist
 * @return mixed The flash value or default
 */
function getFlash(string $key, $default = null)
{
    $value = $_SESSION['_flash'][$key] ?? $default;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

/**
 * Check if a flash message exists.
 *
 * @param string $key Flash key
 * @return bool
 */
function hasFlash(string $key): bool
{
    return isset($_SESSION['_flash'][$key]);
}

/**
 * Retrieve old form input (for repopulating forms after validation failure).
 *
 * @param string $field   The form field name
 * @param string $default Default value if not found
 * @return string The old value (already escaped for safe output)
 */
function old(string $field, string $default = ''): string
{
    $oldInput = $_SESSION['_flash']['old_input'] ?? [];
    return e($oldInput[$field] ?? $default);
}

/**
 * Get an environment variable.
 *
 * @param string $key     The env variable name
 * @param mixed  $default Default value
 * @return mixed
 */
function env(string $key, $default = null)
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

/**
 * Generate a CSRF token and store it in the session.
 *
 * @return string The CSRF token
 */
function csrfToken(): string
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

/**
 * Output a hidden CSRF input field for forms.
 *
 * @return string HTML hidden input
 */
function csrfField(): string
{
    $token = csrfToken();
    return '<input type="hidden" name="_csrf_token" value="' . e($token) . '">';
}

/**
 * Validate a CSRF token from the request.
 *
 * @param string $token The token from the form submission
 * @return bool True if valid
 */
function verifyCsrfToken(string $token): bool
{
    $sessionToken = $_SESSION['_csrf_token'] ?? '';
    if (empty($sessionToken) || empty($token)) {
        return false;
    }
    $valid = hash_equals($sessionToken, $token);
    // Regenerate token after verification
    unset($_SESSION['_csrf_token']);
    return $valid;
}

/**
 * Redirect to a URL.
 *
 * @param string $url The URL to redirect to
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Get the current page identifier for nav active state.
 *
 * @return string The current page name
 */
function currentPage(): string
{
    global $currentPage;
    return $currentPage ?? '';
}
