<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\ParameterException;
use Html\WebPage;


$confirmUpdateMoviePage = new WebPage("Page de confirmation : Film");

/** Fait une vérification du paramètre donné
 *
 * @param string $param
 * @return string
 */
function verify_exception(string $param): string
{
    try {
        if (!isset($_POST[$param])) {
            throw new ParameterException();
        }
        $paramSecured = preg_replace('@<(.+)[^>]*>.*?@is', '', $_POST[$param]);
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

try {
    if (!ctype_digit($id) || $id < 0 || $id == '') {
        throw new ParameterException();
    }
} catch (ParameterException) {
    header('Location: ../index.php');
    http_response_code(400);
    exit;
}

$r = MyPdo::getInstance() -> prepare(<<<SQL
    UPDATE movie
    SET title=?, releaseDate=STR_TO_DATE(?,'YYYY-MM-DD'), originalTitle=?, tagline=?, overview=?
    WHERE id = ?
SQL);
$r -> bindValue(1, $title);
$r -> bindValue(2, $releaseDate);
$r -> bindValue(3, $originalTitle);
$r -> bindValue(4, $tagline);
$r -> bindValue(5, $overview);
$r -> bindValue(6, $id);
$r -> execute();

$confirmUpdateMoviePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Modifier - {$title}</h1>
    </header>
        <h2>Réussite ! </h2>
        <p>Le film a bien été modifié</p>
        <a class="menu_return_button" href="../movie.php?movieId={$id}">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M18.175,4.142H1.951C1.703,4.142,1.5,4.344,1.5,4.592v10.816c0,0.247,0.203,0.45,0.451,0.45h16.224c0.247,0,0.45-0.203,0.45-0.45V4.592C18.625,4.344,18.422,4.142,18.175,4.142 M4.655,14.957H2.401v-1.803h2.253V14.957zM4.655,12.254H2.401v-1.803h2.253V12.254z M4.655,9.549H2.401V7.747h2.253V9.549z M4.655,6.846H2.401V5.043h2.253V6.846zM14.569,14.957H5.556V5.043h9.013V14.957z M17.724,14.957h-2.253v-1.803h2.253V14.957z M17.724,12.254h-2.253v-1.803h2.253V12.254zM17.724,9.549h-2.253V7.747h2.253V9.549z M17.724,6.846h-2.253V5.043h2.253V6.846z"></path>            </svg>
            <p>Retour au film</p>
        </a>
    <footer class="footer">
    </footer>
HTML);

echo $confirmUpdateMoviePage ->toHTML();

