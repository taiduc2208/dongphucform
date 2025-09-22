<?php
// auth.php
$ADMIN_USER = "admin";
$ADMIN_PASS = "abu220830080501"; // đổi thành pass mạnh

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Authentication required";
    exit;
} else {
    if ($_SERVER['PHP_AUTH_USER'] !== $ADMIN_USER || $_SERVER['PHP_AUTH_PW'] !== $ADMIN_PASS) {
        header('HTTP/1.0 403 Forbidden');
        echo "Forbidden";
        exit;
    }
}
