<?php
require_once '/var/www/html/lib/base.php';

$css = file_get_contents('/tmp/neocare-custom.css');
if ($css === false || empty($css)) {
    echo "Error reading CSS file\n";
    exit(1);
}

\OC::$server->getConfig()->setAppValue('theming_customcss', 'customcss', $css);
\OC::$server->getConfig()->setAppValue('theming_customcss', 'cachebuster', (string)time());

echo "CSS successfully injected! Total bytes: " . strlen($css) . "\n";
