<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use App\Validator\Constraint\NotIn;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[UniqueEntity('slug')]
#[UniqueConstraint(name: 'movie_slug', columns: ['slug'])]
class Movie
{
    public const RATED_LIST = [
        self::RATED_GENERAL_AUDIENCES,
        self::RATED_PARENTAL_GUIDANCE_SUGGESTED,
        self::RATED_PARENTS_STRONGLY_CAUTIONED,
        self::RATED_RESTRICTED,
        self::RATED_ADULTS_ONLY,
    ];

    public const RATED_GENERAL_AUDIENCES = 'G';

    public const RATED_PARENTAL_GUIDANCE_SUGGESTED = 'PG';

    public const RATED_PARENTS_STRONGLY_CAUTIONED = 'PG-13';

    public const RATED_RESTRICTED = 'R';

    public const RATED_ADULTS_ONLY = 'NC-17';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[NotIn(list: ['add'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $poster = null;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    #[Assert\NotBlank]
    private ?DateTimeImmutable $releasedAt = null;

    #[ORM\ManyToMany(targetEntity: Genre::class)]
    #[Assert\Count(min: 1)]
    private Collection $genres;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(choices: self::RATED_LIST)]
    private ?string $rated = null;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getReleasedAt(): ?DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    public function getRated(): ?string
    {
        return $this->rated;
    }

    public function setRated(?string $rated): self
    {
        $this->rated = $rated;

        return $this;
    }
}
