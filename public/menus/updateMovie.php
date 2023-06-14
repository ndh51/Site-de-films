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

$updateMoviePage = new WebPage("Modifier - {$movie->getTitle()}");

$updateMoviePage->appendCssUrl('/css/update.css');

$updateMoviePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Modifier - {$movie->getTitle()}</h1>
    </header>
    <form method="post" action="../confirmEditData/confirmUpdateMovie.php">
        <div class="movie__poster">
            <img src='../poster.php?posterId={$movie->getPosterId()}' alt="Poster du film : {$movie->getTitle()}">
        </div>
        <label class="movie__id__input">
            <input name="id" type="hidden" value="{$movie->getId()}">
        </label>
        <label class="movie__title__input">
            Titre : 
            <input name="title" type="text" value="{$movie->getTitle()}">
        </label>
        <label class="movie__releaseDate__input">
            Date de sortie : 
            <input name="releaseDate" type="date" value="{$movie->getReleaseDate()}">
        </label>
        <label class="movie__originalTitle__input">
            Titre original : 
            <input name="originalTitle" type="text" value="{$movie->getOriginalTitle()}">
        </label>
        <label class="movie__tagline__input">
            Slogan : 
            <input name="tagline" type="text" value="{$movie->getTagline()}">
        </label>
        <label class="movie__overview__input">
            Résumé : 
            <input name="overview" type="text" value="{$movie->getOverview()}">
        </label>
        <button type="submit">Modifier</button>
    </form>
    <footer class="footer">
        <a class="menu_abort_button" href="../movie.php?movieId={$movie->getId()}">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z"></path>
            </svg>
            <p>Annuler</p>
        </a>
    </footer>
HTML);

$updateMoviePage->appendCssUrl('css/update.css');

echo $updateMoviePage->toHTML();
