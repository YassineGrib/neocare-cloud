<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$bgDir = '/var/www/html/apps/theming/img/background';
$previewDir = "$bgDir/preview";
$srcDir = '/tmp/bg';

if (!is_dir($bgDir)) {
    mkdir($bgDir, 0755, true);
}
if (!is_dir($previewDir)) {
    mkdir($previewDir, 0755, true);
}

// 1. Clean existing shipped background files
$oldFiles = glob("$bgDir/*.*");
foreach ($oldFiles as $f) {
    if (is_file($f)) {
        unlink($f);
    }
}
$oldPreviews = glob("$previewDir/*.*");
foreach ($oldPreviews as $f) {
    if (is_file($f)) {
        unlink($f);
    }
}

// 2. Define the 7 Neocare Backgrounds
$backgrounds = [
    'neocare-bg-fluid.png' => [
        'attribution' => 'Neocare Fluid Flow (Neocare Clinic)',
        'description' => 'Calming fluid gradient blending off-white with crimson and gold waves',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#e3dbd9',
        'primary_color' => '#7c3a3d',
    ],
    'neocare-bg-topo.png' => [
        'attribution' => 'Neocare Topography Wave (Neocare Clinic)',
        'description' => 'Minimalist gold wavy contours over dark maroon canvas',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#1a0a0a',
        'primary_color' => '#cbab58',
    ],
    'neocare-bg-organic.png' => [
        'attribution' => 'Neocare Organic Cellular (Neocare Clinic)',
        'description' => 'Macro botanical medical precision and growth',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#f5f0ee',
        'primary_color' => '#7c3a3d',
    ],
    'neocare-bg-silk.png' => [
        'attribution' => 'Neocare Satin Silk (Neocare Clinic)',
        'description' => 'Luxurious soft fabric folds with crimson and gold reflections',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#ded4d0',
        'primary_color' => '#7c3a3d',
    ],
    'neocare-bg-glass.png' => [
        'attribution' => 'Neocare Glassmorphism (Neocare Clinic)',
        'description' => 'Frosted glass panels with warm gray and gold overlays',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#e6dfdc',
        'primary_color' => '#7c3a3d',
    ],
    'neocare-bg-poly-dark.png' => [
        'attribution' => 'Neocare Crystalline Dark (Neocare Clinic)',
        'description' => 'Sharp low-poly facets in crimson and gold over dark space',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#180a0a',
        'primary_color' => '#cbab58',
    ],
    'neocare-bg-poly-light.png' => [
        'attribution' => 'Neocare Crystalline Light (Neocare Clinic)',
        'description' => 'Low-poly mosaic with geometric gold and crimson facets',
        'attribution_url' => 'https://neocare.clinic',
        'background_color' => '#ece6e4',
        'primary_color' => '#7c3a3d',
    ],
];

// 3. Copy files and generate previews
foreach ($backgrounds as $filename => $info) {
    $src = "$srcDir/$filename";
    $dst = "$bgDir/$filename";
    $dstPreview = "$previewDir/$filename";

    if (!file_exists($src)) {
        echo "Warning: Source file $src not found\n";
        continue;
    }

    copy($src, $dst);

    // Generate thumbnail using GD (imagecreatefromstring handles both JPEG & PNG)
    $img = imagecreatefromstring(file_get_contents($src));
    if ($img) {
        $width = imagesx($img);
        $height = imagesy($img);
        $thumbWidth = 160;
        $thumbHeight = (int)($height * ($thumbWidth / $width));
        
        $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        imagejpeg($thumb, $dstPreview, 85);
        imagedestroy($thumb);
        imagedestroy($img);
    }
}

// 4. Update BackgroundService.php
$serviceFile = '/var/www/html/apps/theming/lib/Service/BackgroundService.php';
$content = file_get_contents($serviceFile);

$arrayExport = "public const SHIPPED_BACKGROUNDS = [\n";
foreach ($backgrounds as $file => $meta) {
    $arrayExport .= "\t\t'$file' => [\n";
    $arrayExport .= "\t\t\t'attribution' => '{$meta['attribution']}',\n";
    $arrayExport .= "\t\t\t'description' => '{$meta['description']}',\n";
    $arrayExport .= "\t\t\t'attribution_url' => '{$meta['attribution_url']}',\n";
    $arrayExport .= "\t\t\t'background_color' => '{$meta['background_color']}',\n";
    $arrayExport .= "\t\t\t'primary_color' => '{$meta['primary_color']}',\n";
    $arrayExport .= "\t\t],\n";
}
$arrayExport .= "\t];";

$pattern = '/public const SHIPPED_BACKGROUNDS = \[[\s\S]*?\];/';
$newContent = preg_replace($pattern, $arrayExport, $content);
$newContent = str_replace(
    "public const DEFAULT_BACKGROUND_IMAGE = 'jo-myoung-hee-fluid.webp';",
    "public const DEFAULT_BACKGROUND_IMAGE = 'neocare-bg-fluid.png';",
    $newContent
);

file_put_contents($serviceFile, $newContent);

echo "Successfully replaced all shipped backgrounds with Neocare Clinic brand wallpapers!\n";
