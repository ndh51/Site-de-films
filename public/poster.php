<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;

try {
    if (!ctype_digit($_GET['posterId']) || $_GET['posterId'] < 0 || !isset($_GET['posterId'])) {
        throw new ParameterException();
    }
    $posterId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['posterId']);
    if (! Image::findById((int) $posterId)) {
        throw new EntityNotFoundException();
    }
    $poster = Image::findById((int) $posterId);
    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();
} catch (ParameterException) {
    header('Content-Type: image/jpeg');
    echo file_get_contents('../src/Database/Images/movie.png');
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}

