<?php

declare(strict_types=1);

if (! isset($_GET['imageId']) || ! ctype_digit($_GET['imageId'])) {
    http_response_code(400);
    exit;
}

$imageId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['imageId']);

$image = Image::findById($imageId);

header('Content-Type: image/jpeg');
echo $image->getJpeg();
