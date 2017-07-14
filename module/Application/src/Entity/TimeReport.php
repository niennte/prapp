<?php
namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class TimeReport
 *
 * @package Application\Entity
 *
 *
 * @ORM\Entity(repositoryClass="\Application\Repository\TimeKeepingRepository")
 * @ORM\Table(name="time_reports")
 */
class TimeReport
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="date_filed")
     */
    protected $dateFiled;

    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\TimeCard", mappedBy="timeReport")
     * @ORM\JoinColumn(name="id", referencedColumnName="time_report_id")
     */
    protected $timeCards;

    public function __construct()
    {
        $this->timeCards = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateFiled()
    {
        return $this->dateFiled;
    }

    /**
     * @param mixed $dateFiled
     */
    public function setDateFiled($dateFiled)
    {
        $this->dateFiled = $dateFiled;
    }

    /**
     * @return mixed
     */
    public function getTimeCards()
    {
        return $this->timeCards;
    }

    /**
     * @param mixed $timeCards
     */
    public function setTimeCards($timeCards)
    {
        $this->timeCards = $timeCards;
    }

}