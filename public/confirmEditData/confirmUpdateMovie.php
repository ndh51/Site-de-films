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
    SET title=?, releaseDate=?, originalTitle=?, tagline=?, overview=?
    WHERE id = ?
SQL);
$r -> bindValue(1, $title);
$r -> bindValue(2, $releaseDate);
$r -> bindValue(3, $originalTitle);
$r -> bindValue(4, $tagline);
$r -> bindValue(5, $overview);
$r -> bindValue(6, $id);
$r -> execute();

