<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\ParameterException;
use Html\WebPage;

$confirmAddPeoplePage = new WebPage("Page de confirmation : People");

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
$name = verify_exception("name");
$placeofbirth = verify_exception("placeofbirth");
$date_Birth = verify_exception("date_Birth");
$date_Death = verify_exception("date_Death");
$bio = verify_exception("bio");

$r = MyPdo::getInstance()->prepare(
    <<<SQL
    SELECT id
    FROM people
SQL
);
$r->execute();
$ids = $r->fetchAll();

try {
    if (!ctype_digit($id) || $id < 0 || $id == '' || $name == '') {
        throw new ParameterException();
    }
    foreach ($ids as $peopleId) {
        if ($id == $peopleId) {
            throw new ParameterException();
        }
    }
} catch (ParameterException) {
    header('Location: ../menus/addPeople.php');
    http_response_code(400);
    exit;
}

$r = MyPdo::getInstance()->prepare(<<<SQL
    INSERT INTO people (id, birthday, deathday, name, biography, placeofbirth)
    VALUES (?, STR_TO_DATE(?,'YYYY-MM-DD'), STR_TO_DATE(?,'YYYY-MM-DD'), ?, ?, ?)
SQL);
$r -> bindValue(1, $id);
$r -> bindValue(2, $date_Birth);
$r -> bindValue(3, $date_Death);
$r -> bindValue(4, $name);
$r -> bindValue(5, $bio);
$r -> bindValue(6, $placeofbirth);
$r -> execute();

$confirmAddPeoplePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Ajouter un(e) Acteur/ice</h1>
    </header>
        <h2>Réussite ! </h2>
        <p>L'acteur/ice a bien été ajouté(e)</p>
        <a class="menu__toPeople" href="../people.php?peopleId={$id}">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>            </svg>
            <p>Vers l'acteur/ice</p>
        </a>
    <footer class="footer">
    </footer>
HTML);

echo $confirmAddPeoplePage ->toHTML();
