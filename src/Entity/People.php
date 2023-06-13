<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

class People
{
    /* --------------------------------------------------- */
    /*                      Attributes                     */
    /* --------------------------------------------------- */

    private int $id;
    private int $avatarId;
    private string $date;
    private string $deathday;
    private string $name;
    private string $bio;
    private string $plaOfBir;



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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getAvatarId(): int
    {
        return $this->avatarId;
    }

    /**
     * @param int $avatarId
     */
    public function setAvatarId(int $avatarId): void
    {
        $this->avatarId = $avatarId;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDeathday(): string
    {
        return $this->deathday;
    }

    /**
     * @param string $deathday
     */
    public function setDeathday(string $deathday): void
    {
        $this->deathday = $deathday;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return string
     */
    public function getPlaOfBir(): string
    {
        return $this->plaOfBir;
    }

    /**
     * @param string $plaOfBir
     */
    public function setPlaOfBir(string $plaOfBir): void
    {
        $this->plaOfBir = $plaOfBir;
    }

    /** Renvoie une personne à partir de son Id
     *
     * @param int $id
     * @return People
     */
    public static function findById(int $id): People
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM people
            WHERE id = ?;
        SQL
        );
        $r -> bindValue(1, $id);
        $r -> execute();
        return $r -> fetchObject("Entity\\People");
    }
}
