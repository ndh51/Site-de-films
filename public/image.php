<?php

declare(strict_types=1);

use Entity\Image;

if (!isset($_GET['imageId']) || !ctype_digit($_GET['imageId'])) {
    echo "Database/Image/movie.png";
    exit;
}

$imageId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['imageId']);

$image = Image::findById((int) $imageId);

header('Content-Type: image/jpeg');
echo $image->getJpeg();
