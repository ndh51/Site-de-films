<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\People;
use Html\WebPage;


if (! isset($_GET['peopleId'])) {
    http_response_code(404);
    exit;
} elseif (! ctype_digit($_GET['peopleId'])) {
    header('Location: /');
    exit;
}

$peopleId= preg_replace('@<(.+)[^>]*>.*?@is', '', $_GET['peopleId']);

$people = People::findById((int)$peopleId);


$wp=new WebPage('Films - '.$people->getName());

$wp->appendCssUrl('/people.css');


$wp->appendContent(<<<HTML
    <main>
        <div class="people">
            <div class="people__image">
                <img src="image.php?imageId={$people->getAvatarId()}" alt="Image de l'acteur(ice) : {$people->getName()}">
            </div>
            <div class="people__info">
                    <div class="people__name">
                        nom : {$people->getName()}
                    </div>
                    <div class="people__placeofbirth">
                        lieu de naissance : {$people->getplaceOfBirth()}
                    </div>
                    <div class="people__dates">
                        <div class="people__date_Birth">
                            Date de naissance : {$people->getBirthday()}
                        </div>
                        <div class="people__date_Death">
                            Date de Décès : {$people->getDeathday()}
                        </div>
                    </div>
                    <div class="people__bio">
                        Biographie : {$people->getBiography()}
                    </div>
            </div>
        </div>
HTML);

$q=MyPdo::getInstance()->query("SELECT m.posterid,m.title,m.releaseDate, c.role FROM cast c join movie m on c.movieId = m.id WHERE peopleId=$peopleId");

foreach ($q->fetchAll(MyPdo::FETCH_ASSOC) AS $line){
    $wp->appendContent(<<<HTML
        <div class="movie">
           <div class="movie__poster">
                <img src="poster.php?posterId={$line['posterid']}" alt="POster de {$line['title']}"> 
           </div>
           <div class="movie__description">
                <div class="movie__description_first_line">
                    <div class="movie__title">
                        Titre : {$line['title']}
                    </div>
                    <div class="movie__releaseDate">
                        Date : {$line['releaseDate']}
                    </div>      
                </div>
                <div class="movie__description_second_line">
                    Role : {$line['role']}
                </div>
           </div>
        
        </div>

HTML);

}

$wp -> appendContent(<<<HTML
    
    </main>
    <footer class="footer">
        <h2>{$wp->getLastModification()}</h2>
    </footer>
HTML);

echo $wp -> toHTML();
