<?php
echo "<h2>Debug - Cek Struktur Folder</h2>";

echo "<h3>Current Directory:</h3>";
echo "<p>" . __DIR__ . "</p>";

echo "<h3>Current File:</h3>";
echo "<p>" . __FILE__ . "</p>";

echo "<h3>Files in Current Directory:</h3>";
$files = scandir('.');
foreach ($files as $file) {
    echo "<p>- $file</p>";
}

echo "<h3>Parent Directory Files:</h3>";
if (is_dir('..')) {
    $parentFiles = scandir('..');
    foreach ($parentFiles as $file) {
        echo "<p>- $file</p>";
    }
}

echo "<h3>Public Directory Check:</h3>";
$paths = [
    '../../public/app.php',
    '../public/app.php',
    './public/app.php',
    'app.php',
    'config.php',
    'koneksi.php'
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        echo "<p style='color: green;'>✓ Found: $path</p>";
    } else {
        echo "<p style='color: red;'>✗ Not found: $path</p>";
    }
}

echo "<h3>Session Check:</h3>";
session_start();
if (isset($_SESSION)) {
    echo "<p>Session variables:</p>";
    foreach ($_SESSION as $key => $value) {
        echo "<p>- $key: $value</p>";
    }
} else {
    echo "<p>No session data found</p>";
}
?>