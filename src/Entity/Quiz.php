<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity(repositoryClass="App\Repository\QuizRepository")
 */
class Quiz
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;


    /**
     * @var Collection
     *
     * @OneToMany(targetEntity="Question", mappedBy="quiz", cascade={"persist"}, orphanRemoval=true)
     */
    private $questions;

    /**
     * @var Collection
     *
     * @OneToMany(targetEntity="QuizGame", mappedBy="quiz", cascade={"persist"}, orphanRemoval=true)
     */
    private $games;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

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
    public function getName(): ?string
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
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @param Collection $questions
     */
    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }


    /**
     * @param Question $question
     */
    public function addQuestion(Question $question): void
    {
        $this->questions->add($question);
    }

    /**
     * @param Question $question
     */
    public function removeQuestion(Question $question): void
    {
        $this->questions->removeElement($question);
    }

    /**
     * @return Collection
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    /**
     * @param Collection $games
     */
    public function setGames(Collection $games): void
    {
        $this->games = $games;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getUnfinishedGames()
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->isNull('endedAt'));

        return $this->games->matching($criteria);
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getFinishedGames()
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->neq('endedAt', null));

        return $this->games->matching($criteria);
    }
}
