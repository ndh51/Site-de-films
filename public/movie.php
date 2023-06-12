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
        <ul class="list">
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

            <li class="list__people">
                <a href="people.php?peopleId={$line['peopleId']}">
                <div class="list__people__image">
                    "Vignette"
                </div>
                <div class="list__people_role">
                    {$line['role']}
                </div>
                <div class="list__people_name">
                    {$line['name']}
                </div>
                </a>
            </li>
HTML);
}

$moviePage -> appendContent(<<<HTML
    
        </ul>
    </main>
    <footer class="footer">
        <h2>Dernière modification : </h2>
    </footer>
HTML);

echo $moviePage -> toHTML();
