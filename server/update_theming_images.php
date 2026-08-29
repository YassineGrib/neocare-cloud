<?php
require_once '/var/www/html/lib/base.php';

$imageManager = \OC::$server->get(\OCA\Theming\ImageManager::class);

echo "Updating main logo...\n";
if (file_exists('/tmp/neocare-logo_withTextName.png')) {
    $imageManager->updateImage('logo', '/tmp/neocare-logo_withTextName.png');
}

echo "Updating header logo...\n";
if (file_exists('/tmp/neocare-logo.png')) {
    $imageManager->updateImage('logoheader', '/tmp/neocare-logo.png');
}

echo "Updating favicon...\n";
if (file_exists('/tmp/neocare-logo.png')) {
    $imageManager->updateImage('favicon', '/tmp/neocare-logo.png');
}

echo "Updating background image...\n";
if (file_exists('/tmp/neocare-bg-fluid.png')) {
    $imageManager->updateImage('background', '/tmp/neocare-bg-fluid.png');
}

echo "All theming images updated successfully!\n";
