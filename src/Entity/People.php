<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class People
{
    /* --------------------------------------------------- */
    /*                      Attributes                     */
    /* --------------------------------------------------- */

    private int $id;
    private int $avatarId;
    private ?string $birthday = null;
    private ?string $deathday = null;
    private string $name;
    private ?string $biography  = null;
    private ?string $placeOfBirth  =null;


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
     * @return string|null
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string|null $birthday
     */
    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string|null
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @param string|null $deathday
     */
    public function setDeathday(?string $deathday): void
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
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * @param string|null $biography
     */
    public function setBiography(?string $biography): void
    {
        $this->biography = $biography;
    }

    /**
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string|null $placeOfBirth
     */
    public function setPlaceOfBirth(?string $placeOfBirth): void
    {
        $this->placeOfBirth = $placeOfBirth;
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
            SELECT id, avatarId, birthday, deathday, name, biography, placeOfBirth
            FROM people
            WHERE id = ?;
        SQL
        );
        $r -> bindValue(1, $id);
        $r -> execute();
        if ($people = $r -> fetchObject("Entity\\People")) {
            return $people;
        } else {
            throw new EntityNotFoundException();
        }
    }
}
