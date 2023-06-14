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
                <svg class="svg-icon" viewBox="0 0 20 20">
					<path d="M17.064,4.656l-2.05-2.035C14.936,2.544,14.831,2.5,14.721,2.5H3.854c-0.229,0-0.417,0.188-0.417,0.417v14.167c0,0.229,0.188,0.417,0.417,0.417h12.917c0.229,0,0.416-0.188,0.416-0.417V4.952C17.188,4.84,17.144,4.733,17.064,4.656M6.354,3.333h7.917V10H6.354V3.333z M16.354,16.667H4.271V3.333h1.25v7.083c0,0.229,0.188,0.417,0.417,0.417h8.75c0.229,0,0.416-0.188,0.416-0.417V3.886l1.25,1.239V16.667z M13.402,4.688v3.958c0,0.229-0.186,0.417-0.417,0.417c-0.229,0-0.417-0.188-0.417-0.417V4.688c0-0.229,0.188-0.417,0.417-0.417C13.217,4.271,13.402,4.458,13.402,4.688"></path>
				</svg>
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
