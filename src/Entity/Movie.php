<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Movie
{
    /* --------------------------------------------------- */
    /*                      Attributes                     */
    /* --------------------------------------------------- */

    private int $id;
    private ?int $posterId = null;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private ?int $runtime = null;
    private string $tagline;
    private string $title;



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
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int|null $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return int|null
     */
    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    /**
     * @param int|null $runtime
     */
    public function setRuntime(?int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** Renvoie un Film à partir de son Id
     *
     * @param int $id
     * @return Movie
     */
    public static function findById(int $id): Movie
    {
        $r = MyPdo::getInstance() -> prepare(
            <<<SQL
            SELECT *
            FROM movie
            WHERE id = ?;
        SQL
        );
        $r -> bindValue(1, $id);
        $r -> execute();
        if ($movie = $r -> fetchObject("Entity\\Movie")) {
            return $movie;
        } else {
            throw new EntityNotFoundException();
        }
    }
}
