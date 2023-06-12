<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /** Renvoie un tableau contenant tous les films triés par ordre alphabétique.
     *
     * @return Movie[]
     */
    public static function findAllMovies(): array
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM movie
            ORDER BY releaseDate DESC
        SQL
        );
        $r -> execute();
        return $r -> fetchAll(MyPdo::FETCH_CLASS, Movie::class);
    }
}
