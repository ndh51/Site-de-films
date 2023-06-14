<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Movie;
use Html\WebPage;

$moviePage = new WebPage();

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

$moviePage->appendCssUrl('/movie.css');

$moviePage -> setTitle("{$movie->getTitle()}");

$moviePage -> appendContent(<<<HTML
    <header class="header">
            <h1>Films - {$movie->getTitle()}</h1>
        </header>
        <form action="index.php" class="menu_accueil">
            <button class="menu_accueil_button">
                <svg class="svg-icon" viewBox="0 0 20 20">
					<path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
				</svg>
			    <p>Retour à l'accueil</p>
			</button>
        </form>
        <main>
            <form class="menu_updtDelMovie">
                <button formaction="updateMovie.php" class="menu_updtDelMovie_update_button">
                    <svg class="svg-icon" viewBox="0 0 20 20">
						<path d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"></path>
					</svg>
                    <p>Modifier</p>
                </button>
                <button formaction="deleteMovie.php" class="menu_updtDelMovie_delete_button">
                    <svg class="svg-icon" viewBox="0 0 20 20">
						<path d="M17.114,3.923h-4.589V2.427c0-0.252-0.207-0.459-0.46-0.459H7.935c-0.252,0-0.459,0.207-0.459,0.459v1.496h-4.59c-0.252,0-0.459,0.205-0.459,0.459c0,0.252,0.207,0.459,0.459,0.459h1.51v12.732c0,0.252,0.207,0.459,0.459,0.459h10.29c0.254,0,0.459-0.207,0.459-0.459V4.841h1.511c0.252,0,0.459-0.207,0.459-0.459C17.573,4.127,17.366,3.923,17.114,3.923M8.394,2.886h3.214v0.918H8.394V2.886z M14.686,17.114H5.314V4.841h9.372V17.114z M12.525,7.306v7.344c0,0.252-0.207,0.459-0.46,0.459s-0.458-0.207-0.458-0.459V7.306c0-0.254,0.205-0.459,0.458-0.459S12.525,7.051,12.525,7.306M8.394,7.306v7.344c0,0.252-0.207,0.459-0.459,0.459s-0.459-0.207-0.459-0.459V7.306c0-0.254,0.207-0.459,0.459-0.459S8.394,7.051,8.394,7.306"></path>
					</svg>
                    <p>Supprimer</p>
                </button>
            </form>
            <div class="movie">
                <div class="movie__poster">
                    <img src='poster.php?posterId={$movie->getPosterId()}' alt="Poster du film : {$movie->getTitle()}">
                </div>
                <div class="movie__description">
                    <div class="movie__description_first_line">
                        <div class="movie__title">
                            Titre : {$movie->getTitle()}
                        </div>
                        <div class="movie__releaseDate">
                            Date : {$movie->getReleaseDate()}
                        </div>
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
    
                 <a href="people.php?peopleId={$line['peopleId']}">
                    <div class="list__people">
                    <div class="list__people__image">
                        <img src="vignette.php?vignetteId={$line['avatarId']}" alt="Image de l'acteur(ice) : {$line['name']}">
                    </div>
                    <div class="list__role_info">
                        <div class="list__people_role">
                            Rôle : {$line['role']}
                        </div>
                        <div class="list__people_name">
                            Nom : {$line['name']}
                        </div>
                    </div>
                    </div>
                 </a>
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
