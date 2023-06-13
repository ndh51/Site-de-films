<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\Collection\MovieCollection;

$wp=new WebPage('Films');

$ans=MovieCollection::findAllMovies();

$wp->setTitle('Films');

$wp->appendContent('<header> <h1>Films</h1> </header> ');

$wp->appendContent('<div class="list"> ');

$query=MyPdo::getInstance()->prepare('select jpeg from cutron01_movie.image where id=?');

foreach ($ans as $line) {
    $wp->appendContent('<div class="movie">');
    $wp->appendContent(
        <<<HTML
    <a href="Movie.php?movieId={$line->getId()}">
        <div class="movie_cover">
            <a href="Movie.php?movieId={$line->getId()}"> 
                <img src='image.php?imageId={$line->getPosterId()}'>
            </a>
        </div>
        <div class="movie_title">
        <a href="Movie.php?movieId={$line->getId()}">
            <p> {$line->getTitle()} </p>
        </a>
        </div>
    HTML
    );
    $wp->appendContent('</div>');
}


$wp->appendContent('</div> ');




$wp->appendContent('<footer> <h1>Derniere modification :  </h1> </footer> ');


echo $wp->toHTML();
