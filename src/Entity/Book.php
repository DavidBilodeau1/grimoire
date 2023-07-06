<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pageCount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageRating;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="Books")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     */
    private $Author;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="book")
     */
    private $ratings;

    /**
     * @ORM\ManyToMany(targetEntity=TBR::class, mappedBy="books")
     */
    private $tBRs;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="book")
     */
    private $reviews;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->Author = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->tBRs = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(?\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getPageCount(): ?int
    {
        return $this->pageCount;
    }

    public function setPageCount(?int $pageCount): self
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(?float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addBook($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->Author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->Author->contains($author)) {
            $this->Author[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->Author->removeElement($author);

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setBook($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getBook() === $this) {
                $rating->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TBR>
     */
    public function getTBRs(): Collection
    {
        return $this->tBRs;
    }

    public function addTBR(TBR $tBR): self
    {
        if (!$this->tBRs->contains($tBR)) {
            $this->tBRs[] = $tBR;
            $tBR->addBook($this);
        }

        return $this;
    }

    public function removeTBR(TBR $tBR): self
    {
        if ($this->tBRs->removeElement($tBR)) {
            $tBR->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBook() === $this) {
                $review->setBook(null);
            }
        }

        return $this;
    }
}
