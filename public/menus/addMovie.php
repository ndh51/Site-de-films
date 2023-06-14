<?php

declare(strict_types=1);

use Html\WebPage;

$addMoviePage = new WebPage("Ajouter un film");

$addMoviePage->appendCssUrl('/css/add.css');

$addMoviePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Ajouter un film</h1>
    </header>
    <form method="post" action="../confirmEditData/confirmAddMovie.php">
        <div class="movie__poster">
            <img src='../poster.php?posterId=' alt="Poster de film inconnu">
        </div>
        <label class="movie__id__input">
            Id du film : 
            <input name="id" type="text" required>
        </label>
        <label class="movie__title__input">
            Titre : 
            <input name="title" type="text">
        </label>
        <label class="movie__releaseDate__input">
            Date de sortie : 
            <input name="releaseDate" type="date">
        </label>
        <label class="movie__originalTitle__input">
            Titre original : 
            <input name="originalTitle" type="text">
        </label>
        <label class="movie__tagline__input">
            Slogan : 
            <input name="tagline" type="text">
        </label>
        <label class="movie__overview__input">
            Résumé : 
            <input name="overview" type="text">
        </label>
        <button type="submit">Ajouter</button>
        <button type="reset">Recommencer</button>
    </form>
    <footer class="footer">
        <a class="menu_abort_button" href="../index.php">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z"></path>
            </svg>
            <p>Annuler</p>
        </a>
    </footer>
HTML);

echo $addMoviePage->toHTML();
