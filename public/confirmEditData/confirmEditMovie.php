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
    if ($_GET['id'] == '') {
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
    INSERT INTO movie (id,title,releaseDate, originalTitle, tagline, overview)
    VALUES (?,?,?,?,?,?)
SQL);
$r -> bindValue(1, $id);
$r -> bindValue(2, $title);
$r -> bindValue(3, $releaseDate);
$r -> bindValue(4, $originalTitle);
$r -> bindValue(5, $tagline);
$r -> bindValue(6, $overview);
$r -> execute();

echo $confirmEditMoviePage ->toHTML();
