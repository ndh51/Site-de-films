<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Image;

try {
    if (!isset($_GET['vignetteId']) || !ctype_digit($_GET['vignetteId']) || $_GET['vignetteId'] < 0) {
        throw new ParameterException();
    }
    $vignetteId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['vignetteId']);
    if (! Image::findById((int) $vignetteId)) {
        throw new EntityNotFoundException();
    }
    $vignette = Image::findById((int) $vignetteId);
    header('Content-Type: image/jpeg');
    echo $vignette->getJpeg();
} catch (ParameterException) {
    header('Content-Type: image/jpeg');
    echo file_get_contents('../src/Database/Images/actor.png');
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
