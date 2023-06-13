<?php

declare(strict_types=1);

use Database\MyPdo;
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
                <img src='image.php?imageId={$movie->getPosterId()}' alt="Poster du film : {$movie->getTitle()}">
            </div>
            <div class="movie__title">
                Titre : {$movie->getTitle()}
            </div>
            <div class="movie__releaseDate">
                Date : {$movie->getReleaseDate()}
            </div>
            <div class="movie__originalTitle">
                Titre original : {$movie->getOriginalTitle()}
            </div>
            <div class="movie__tagline">
                Slogan : {$movie->getTagline()}
            </div>
            <div class="movie__overview">
                Résumé : {$movie->getOverview()}
            </div>
        </div>
        <div class="list">
HTML);

$r = MyPdo::getInstance() -> prepare(<<<SQL
         SELECT *
         FROM people p, cast c
         WHERE p.id = c.peopleId
            AND movieId = ?
    SQL);

$r -> bindValue(1, $movieId);
$r -> execute();

foreach ($r -> fetchAll() as $line) {
    $moviePage -> appendContent(<<<HTML

            <div class="list__people">
                <a href="people.php?peopleId={$line['peopleId']}">
                <div class="list__people__image">
                    <img src="image.php?imageId={$line['avatarId']}" alt="Image de l'acteur(ice) : {$line['name']}">
                </div>
                <div class="list__people_role">
                    Rôle : {$line['role']}
                </div>
                <div class="list__people_name">
                    Nom : {$line['name']}
                </div>
                </a>
            </div>
HTML);
}

$moviePage -> appendContent(<<<HTML
    
        </div>
    </main>
    <footer class="footer">
        <h2>{$moviePage->getLastModification()}</h2>
    </footer>
HTML);

echo $moviePage -> toHTML();
