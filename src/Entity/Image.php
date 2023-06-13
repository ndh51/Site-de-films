<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

class Image
{
    /* --------------------------------------------------- */
    /*                      Attributes                     */
    /* --------------------------------------------------- */

    private int $id;
    private string $jpeg;



    /* --------------------------------------------------- */
    /*                   Getters/Setters                   */
    /* --------------------------------------------------- */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }


    /**
     *
     * @param int $id
     * @return Image
     */

    public static function findById(int $id): Image
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM image
            WHERE id = ?;
        SQL
        );
        $r -> bindValue(1, $id);
        $r -> execute();
        return $r -> fetchObject("Entity\\Image");

    }

}
