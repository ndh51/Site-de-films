<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\Movie;

$movie= Movie::findById((int)$_GET['movieId']);

$wp=new WebPage('Etes vous sur de vouloir supprimer'. $movie->getTitle() .'? ');

$wp->appendCssUrl('/css/delete.css');

$wp->appendContent(<<<HTML
    <h1> Etes vous sur de vouloir supprimer {$movie->getTitle()} ?()</h1>
    <form name="frm" method="post" action="deleteMovie.php?movieId={$_GET['movieId']}">
    <label> 
        <input name="verif" value="0" type="radio"  checked>Non</input>
    </label> 
    <label> 
        <input name="verif" value="1" type="radio"  >Oui</input>
    <label> 
        <button type="submit">Valider</button>
    </form>


HTML);



if(isset($_POST['verif']) && $_POST['verif']==0) {
    header("Location: ../movie.php?movieId={$_GET['movieId']}");
    exit();
}
if(isset($_POST['verif']) && $_POST['verif']==1) {
    $q=MyPdo::getInstance()->prepare('DELETE FROM movie WHERE id=?');
    $q->bindValue(1, $movie->getId());
    $q->execute();
    header('Location: ../');
    exit();
}




echo $wp->toHTML();
