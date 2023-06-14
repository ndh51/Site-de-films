<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\Collection\MovieCollection;

$wp=new WebPage('Films');

$ans=MovieCollection::findAllMovies();

$wp->setTitle('Films');

$wp->appendCssUrl('css/index.css');

$wp->appendContent(
    <<<HTML
    <header> 
        <h1>Films</h1> 
    </header>
        <div class="buttons">
            <a href="menus/addMovie.php" class="menu_addMovie">
                <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                    <path d="M17.064,4.656l-2.05-2.035C14.936,2.544,14.831,2.5,14.721,2.5H3.854c-0.229,0-0.417,0.188-0.417,0.417v14.167c0,0.229,0.188,0.417,0.417,0.417h12.917c0.229,0,0.416-0.188,0.416-0.417V4.952C17.188,4.84,17.144,4.733,17.064,4.656M6.354,3.333h7.917V10H6.354V3.333z M16.354,16.667H4.271V3.333h1.25v7.083c0,0.229,0.188,0.417,0.417,0.417h8.75c0.229,0,0.416-0.188,0.416-0.417V3.886l1.25,1.239V16.667z M13.402,4.688v3.958c0,0.229-0.186,0.417-0.417,0.417c-0.229,0-0.417-0.188-0.417-0.417V4.688c0-0.229,0.188-0.417,0.417-0.417C13.217,4.271,13.402,4.458,13.402,4.688"></path>
                </svg>
                <p>Ajouter Film</p>
            </a>
            <a href="menus/addPeople.php" class="menu_addPeople">
                <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                    <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                </svg>
                <p>Ajouter Acteur/ice</p>
            </a>
        </div>
        
        <div class="list">
        <div class="filter">
            <h1> Filtres <h1>
            <form name="filters" method="GET" action="index.php">
            <label> 
                   <select name="genreid">
                   <button type="submit">Valider</button> 
                   
HTML
);

## Selection des filtres

foreach (MyPdo::getInstance()->query('select * from genre')->fetchAll(MyPdo::FETCH_ASSOC) as $line) {
    $wp->appendContent(
        <<<HTML
                <option name='genreid' value="{$line['id']}" {$line['name']}</option>
    HTML
    );
}

$wp->appendContent('</select> <button type="submit">Valider</button> </label> </form> <a href="/"><p>Réafficher tous les films</p></a> </div>');



##selection de l'affichage


if (!empty($_GET['genreid'])) {

    $query=MyPdo::getInstance()->prepare('select * from cutron01_movie.movie where id in (select movieId from movie_genre where genreId=?)');
    $query->bindValue(1, $_GET['genreid']);
    $query->execute();
    foreach ($query->fetchAll(MyPdo::FETCH_ASSOC) as $line) {
        $wp->appendContent(
            <<<HTML
                <div class="movie">
                    <a href="movie.php?movieId={$line['id']}}">
                        <div class="movie_cover">
                            <a href="movie.php?movieId={$line['id']}"> 
                                <img src='poster.php?posterId={$line['posterId']}' alt="{$line['title']}">
                            </a>
                        </div>
                        <div class="movie_title">
                            <a href="movie.php?movieId={$line['id']}">
                                <p> {$line['title']} </p>
                            </a>
                        </div>
                    </a>
                </div>

    HTML
        );
    }
}

if (empty($_GET['genreid'])) {
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
}
$wp->appendContent('        </div> ');

$wp->appendContent("
        <footer> <h2> {$wp->getLastModification()} </h2> </footer> ");

echo $wp->toHTML();
