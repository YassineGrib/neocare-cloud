<?php
define('OC_CONSOLE', true);
require_once '/var/www/html/lib/base.php';

$css = file_get_contents('/tmp/neocare-custom.css');
if ($css === false || empty($css)) {
    echo "Error reading CSS file\n";
    exit(1);
}

$config = \OC::$server->getConfig();
$config->setAppValue('theming_customcss', 'customcss', $css);
$config->setAppValue('theming_customcss', 'cachebuster', (string)time());

echo "Custom CSS injected successfully! (" . strlen($css) . " bytes)\n";
