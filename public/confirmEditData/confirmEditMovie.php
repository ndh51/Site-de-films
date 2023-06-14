<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\ParameterException;
use Html\WebPage;


$confirmEditMoviePage = new WebPage("Page de confirmation : Film");

/** Fait une vérification du paramètre donné
 *
 * @param string $param
 * @return string
 */
function verify_exception(string $param): string
{
    try {
        if (!isset($_GET[$param])) {
            throw new ParameterException();
        }
        $paramSecured = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET[$param]);
    } catch (ParameterException) {
        http_response_code(400);
        exit;
    } catch (Exception) {
        http_response_code(500);
        exit;
    }
    return $paramSecured;
}

$id = verify_exception("id");
$title = verify_exception("title");
$releaseDate = verify_exception("releaseDate");
$originalTitle = verify_exception("originalTitle");
$tagline = verify_exception("tagline");
$overview = verify_exception("overview");

$r = MyPdo::getInstance() -> prepare(<<<SQL
    SELECT id
    FROM movie
SQL);
$r -> execute();
$ids = $r -> fetchAll();

try {
    if (!ctype_digit($id) || $id < 0 || $id == '') {
        throw new ParameterException();
    }
    foreach ($ids as $movieid) {
        if ($id == $movieid) {
            throw new ParameterException();
        }
    }
} catch (ParameterException) {
    header('Location: ../menus/addMovie.php');
    http_response_code(400);
    exit;
}

$r = MyPdo::getInstance() -> prepare(<<<SQL
    INSERT INTO movie (id, originalLanguage, title, releaseDate, originalTitle, tagline, overview, runtime)
    VALUES (?,'',?,STR_TO_DATE(?,'YYYY-MM-DD'),?,?,?,0)
SQL);
$r -> bindValue(1, $id);
$r -> bindValue(2, $title);
$r -> bindValue(3, $releaseDate);
$r -> bindValue(4, $originalTitle);
$r -> bindValue(5, $tagline);
$r -> bindValue(6, $overview);
$r -> execute();

$confirmEditMoviePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Ajouter un film</h1>
    </header>
        <h2>Réussite ! </h2>
        <p>Le film a bien été ajouté</p>
        <a class="menu_accueil_button" href="../index.php">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
            </svg>
            <p>Retour à l'accueil</p>
        </a>
    <footer class="footer">
    </footer>
HTML);

echo $confirmEditMoviePage ->toHTML();
