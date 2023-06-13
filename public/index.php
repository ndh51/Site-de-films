<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\Collection\MovieCollection;

$wp=new WebPage('Films');

$ans=MovieCollection::findAllMovies();

$wp->setTitle('Films');

$wp->appendCssUrl('/index.css');

$wp->appendContent('<header> <h1>Films</h1> </header> ');

$wp->appendContent('<div class="list"> ');

$query=MyPdo::getInstance()->prepare('select jpeg from cutron01_movie.image where id=?');

foreach ($ans as $line) {

    $wp->appendContent(
        <<<HTML
    <div class="movie">
        <a href="Movie.php?movieId={$line->getId()}">
        <div class="movie_cover">
            <a href="Movie.php?movieId={$line->getId()}"> 
                <img src='image.php?imageId={$line->getPosterId()}' alt="{$line->getTitle()}">
            </a>
        </div>
        <div class="movie_title">
            <a href="Movie.php?movieId={$line->getId()}">
                <p> {$line->getTitle()} </p>
            </a>
        </div>
    </div>
    HTML
    );
}


$wp->appendContent('</div> ');




$wp->appendContent('<footer> <h1> {$ans->getLastModification()} </h1> </footer> ');


echo $wp->toHTML();
