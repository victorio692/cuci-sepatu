<?php
/**
 * Script untuk membuat logo SYH Cleaning
 * Run dari terminal: php create_logo.php
 */

// Buat directory jika belum ada
$dir = __DIR__ . '/public/assets/images';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Create image with GD library
$width = 200;
$height = 200;
$image = imagecreatetruecolor($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$dark = imagecolorallocate($image, 31, 41, 55); // #1f2937
$light_gray = imagecolorallocate($image, 243, 244, 246); // #f3f4f6
$blue = imagecolorallocate($image, 59, 130, 246); // #3b82f6
$purple = imagecolorallocate($image, 124, 58, 237); // #7c3aed

// Fill with white background
imagefill($image, 0, 0, $white);

// Draw circle border
imagefilledellipse($image, 100, 100, 190, 190, $white);
imageellipse($image, 100, 100, 190, 190, $dark);
imageellipse($image, 100, 101, 190, 190, $dark);
imageellipse($image, 101, 100, 190, 190, $dark);

// Draw shoe icons
// Left shoe
imagefilledellipse($image, 55, 67, 30, 35, $light_gray);
imageellipse($image, 55, 67, 30, 35, $dark);
imageline($image, 40, 75, 70, 75, $dark);

// Right shoe  
imagefilledellipse($image, 95, 67, 30, 35, $light_gray);
imageellipse($image, 95, 67, 30, 35, $dark);
imageline($image, 80, 75, 110, 75, $dark);

// Draw star
$star_points = array(
    120, 52,  // top
    125, 65,  // top right
    138, 68,  // right
    128, 76,  // bottom right
    132, 89,  // bottom
    120, 82,  // bottom left
    108, 89,  // left
    112, 76,  // top left
    102, 68,  // left top
    115, 65   // top
);
imagefilledpolygon($image, $star_points, 5, $blue);

// Add text - SYH.CLEANING (using built-in font)
// Since built-in fonts are limited, we'll use imagestring
$text_color = $dark;
// Position text at bottom
imagestring($image, 2, 35, 155, 'SYH.CLEANING', $text_color);

// Add FREE DELIVERY text at bottom
imagestring($image, 1, 45, 175, 'FREE DELIVERY', $purple);

// Save image as PNG
$filename = $dir . '/logo.png';
if (imagepng($image, $filename)) {
    echo "✓ Logo created successfully!\n";
    echo "File: {$filename}\n";
    echo "Size: {$width}x{$height}px\n";
} else {
    echo "✗ Error creating logo image\n";
}

// Free up memory
imagedestroy($image);
?>
