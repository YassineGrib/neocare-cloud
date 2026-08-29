<?php
require_once '/var/www/html/lib/base.php';

$imageManager = \OC::$server->get(\OCA\Theming\ImageManager::class);

echo "Updating logo...\n";
$imageManager->updateImage('logo', '/tmp/neocare_logo.png');

echo "Updating logoheader...\n";
$imageManager->updateImage('logoheader', '/tmp/neocare_logoheader.png');

echo "Updating favicon...\n";
$imageManager->updateImage('favicon', '/tmp/neocare_favicon.png');

echo "Updating background...\n";
$imageManager->updateImage('background', '/tmp/neocare_background.png');

echo "All images updated successfully!\n";
