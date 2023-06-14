<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\People;
use Html\WebPage;

try {
    if (!isset($_GET['peopleId']) || !ctype_digit($_GET['peopleId']) || $_GET['peopleId'] < 0) {
        throw new ParameterException();
    }
    $peopleId = preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['peopleId']);
    if (! People::findById((int) $peopleId)) {
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

$people = People::findById((int)$peopleId);

$updatePeoplePage = new WebPage("Modifier - {$people->getName()}");

$updatePeoplePage -> appendContent(<<<HTML
    <header class="header">
        <h1>Modifier - {$people->getName()}</h1>
    </header>
    <form method="post" action="../confirmEditData/confirmUpdatePeople.php">
        <div class="people__vignette">
            <img src='../vignette.php?vignetteId={$people->getAvatarId()}' alt="Image de l'acteur/ice : {$people->getName()}">
        </div>
        <label class="people__id__input">
            <input name="id" type="hidden" value="{$people->getId()}">
        </label>
        <label class="people__name__input">
            Nom : 
            <input name="name" type="text" value="{$people->getName()}">
        </label>
        <label class="people__placeofbirth__input">
            Lieu de naissance : 
            <input name="placeofbirth" type="text" value="{$people->getPlaceOfBirth()}">
        </label>
        <label class="people__date_Birth__input">
            Date de naissance : 
            <input name="date_Birth" type="date" value="{$people->getBirthday()}">
        </label>
        <label class="people__date_Death__input">
            Date de décès : 
            <input name="date_Death" type="date" value="{$people->getDeathday()}">
        </label>
        <label class="people__bio__input">
            Biographie : 
            <input name="bio" type="text" value="{$people->getBiography()}">
        </label>
        <button type="submit">Modifier</button>
    </form>
    <footer class="footer">
        <a class="menu_abort_button" href="../people.php?peopleId={$people->getId()}">
            <svg class="svg-icon" viewBox="0 0 20 20" height="60">
                <path d="M10.185,1.417c-4.741,0-8.583,3.842-8.583,8.583c0,4.74,3.842,8.582,8.583,8.582S18.768,14.74,18.768,10C18.768,5.259,14.926,1.417,10.185,1.417 M10.185,17.68c-4.235,0-7.679-3.445-7.679-7.68c0-4.235,3.444-7.679,7.679-7.679S17.864,5.765,17.864,10C17.864,14.234,14.42,17.68,10.185,17.68 M10.824,10l2.842-2.844c0.178-0.176,0.178-0.46,0-0.637c-0.177-0.178-0.461-0.178-0.637,0l-2.844,2.841L7.341,6.52c-0.176-0.178-0.46-0.178-0.637,0c-0.178,0.176-0.178,0.461,0,0.637L9.546,10l-2.841,2.844c-0.178,0.176-0.178,0.461,0,0.637c0.178,0.178,0.459,0.178,0.637,0l2.844-2.841l2.844,2.841c0.178,0.178,0.459,0.178,0.637,0c0.178-0.176,0.178-0.461,0-0.637L10.824,10z"></path>
            </svg>
            <p>Annuler</p>
        </a>
    </footer>
HTML);

echo $updatePeoplePage->toHTML();
