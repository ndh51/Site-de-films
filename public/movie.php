<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Movie;
use Html\WebPage;

$moviePage = new WebPage();

if (! isset($_GET['movieId'])) {
    http_response_code(404);
    exit;
} elseif (! ctype_digit($_GET['movieId'])) {
    header('Location: /');
    exit;
}

$movieId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['movieId']);

$movie = Movie::findById((int)$movieId);

$moviePage -> setTitle("{$movie->getTitle()}");

$moviePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Films - {$movie->getTitle()}</h1>
    </header>
    <main>
        <div class="movie">
            <div class="movie__poster">
                "poster"
            </div>
            <div class="movie__title">
                {$movie->getTitle()}
            </div>
            <div class="movie__releaseDate">
                {$movie->getReleaseDate()}
            </div>
            <div class="movie__originalTitle">
                {$movie->getOriginalTitle()}
            </div>
            <div class="movie__tagline">
                {$movie->getTagline()}
            </div>
            <div class="movie__overview">
                {$movie->getOverview()}
            </div>
        </div>
        <div class="list">
            
        </div>
    </main>
    <footer class="footer">
        <h2>Dernière modification : {$moviePage->getLastModification()}</h2>
    </footer>
HTML);

echo $moviePage -> toHTML();
