<?php
declare(strict_types=1);

namespace Entity\Collection;


use Database\MyPdo;
use Entity\Cast;

class CastCollection
{
    /** Renvoie un tableau contenant tous les films triés par ordre alphabétique.
     *
     * @return Movie[]
     */
    public static function findMoviesByPeopleId(int $id): array
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM cast 
            where peopleId=$id
            ORDER BY 
        SQL
        );
        $r -> execute();
        return $r -> fetchAll(MyPdo::FETCH_CLASS, Cast::class);
    }
}