<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\WebPage;

try {
    if (!isset($_GET['movieId']) || !ctype_digit($_GET['movieId']) || $_GET['movieId'] < 0) {
        throw new ParameterException();
    }
    $movieId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['movieId']);
    if (! Movie::findById((int) $movieId)) {
        throw new EntityNotFoundException();
    }
} catch (ParameterException) {
    http_response_code(400);
    exit;
} catch (EntityNotFoundException) {
    http_response_code(404);
    exit;
} catch (Exception) {
    http_response_code(500);
    exit;
}



$movie = Movie::findById((int)$movieId);

$updateMoviePage = new WebPage("Modification de {$movie->getTitle()}");

$updateMoviePage -> appendContent("<h1>test</h1>");

$updateMoviePage->appendCssUrl('css/update.css');

echo $updateMoviePage->toHTML();
