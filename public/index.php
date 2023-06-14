<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\Collection\MovieCollection;

$wp=new WebPage('Films');

$ans=MovieCollection::findAllMovies();

$wp->setTitle('Films');

$wp->appendCssUrl('/index.css');

$wp->appendContent(<<<HTML
    <header> <h1>Films</h1> </header>
        <form action="addMovie.php" class="menu_addMovie">
            <button class="menu_addMovie_button">
			    <p>Ajouter Film</p>
			</button>
        </form>
        <div class="list">

HTML);

$query=MyPdo::getInstance()->prepare('select jpeg from cutron01_movie.image where id=?');

foreach ($ans as $line) {

    $wp->appendContent(
        <<<HTML
                <div class="movie">
                    <a href="movie.php?movieId={$line->getId()}">
                        <div class="movie_cover">
                            <a href="movie.php?movieId={$line->getId()}"> 
                                <img src='poster.php?posterId={$line->getPosterId()}' alt="{$line->getTitle()}">
                            </a>
                        </div>
                        <div class="movie_title">
                            <a href="movie.php?movieId={$line->getId()}">
                                <p> {$line->getTitle()} </p>
                            </a>
                        </div>
                    </a>
                </div>

    HTML
    );
}

$wp->appendContent('        </div> ');

$wp->appendContent("
        <footer> <h2> {$wp->getLastModification()} </h2> </footer> ");

echo $wp->toHTML();
