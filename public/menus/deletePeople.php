<?php

declare(strict_types=1);

use Html\WebPage;
use Database\MyPdo;
use Entity\People;

$people= People::findById((int)$_GET['peopleId']);

$wp=new WebPage('Etes vous sur de vouloir supprimer'. $people->getName() .'? ');

$wp->appendCssUrl('/css/delete.css');

$wp->appendContent(<<<HTML
    <h1> Etes vous sur de vouloir supprimer {$people->getName()} ?</h1>
    <form name="frm" method="post" action="deletePeople.php?peopleId={$_GET['peopleId']}">
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
    header("Location: ../people.php?peopleId={$_GET['peopleId']}");
    exit();
}
if(isset($_POST['verif']) && $_POST['verif']==1) {
    $q=MyPdo::getInstance()->prepare('DELETE FROM people WHERE id=?');
    $q->bindValue(1, $people->getId());
    $q->execute();
    header('Location: ../');
    exit();
}




echo $wp->toHTML();
