<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;

class PeopleCollection
{
    /** Renvoie un tableau contenant toutes les personnes triées par leur nom
     * par ordre alphabétique.
     *
     * @return People[]
     */
    public static function findAllPeople(): array
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM people
            ORDER BY name
        SQL
        );
        $r -> execute();
        return $r -> fetchAll(PDO::FETCH_CLASS, People::class);
        return $r -> fetchAll(MyPdo::FETCH_CLASS, People::class);
    }
}
