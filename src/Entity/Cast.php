<?php

declare(strict_types=1);

namespace Entity;

class Cast
{
    /* --------------------------------------------------- */
    /*                      Attributes                     */
    /* --------------------------------------------------- */

    private int $Id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;



    /* --------------------------------------------------- */
    /*                   Getters/Setters                   */
    /* --------------------------------------------------- */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->Id;
    }

    /**
     * @param int $Id
     */
    public function setId(int $Id): void
    {
        $this->Id = $Id;
    }


    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @param int $peopleId
     */
    public function setPeopleId(int $peopleId): void
    {
        $this->peopleId = $peopleId;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @param int $movieId
     */
    public function setMovieId(int $movieId): void
    {
        $this->movieId = $movieId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * @param int $orderIndex
     */
    public function setOrderIndex(int $orderIndex): void
    {
        $this->orderIndex = $orderIndex;
    }
}
