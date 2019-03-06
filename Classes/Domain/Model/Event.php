<?php
namespace Conversion\Eventcalendar\Domain\Model;


/***
 *
 * This file is part of the "Event Calendar" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Mikel Wohlschlegel <mw@con-version.de>, conversion online solutions
 *
 ***/
/**
 * Event
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * dateTimeStart
     * 
     * @var \DateTime
     */
    protected $dateTimeStart = null;

    /**
     * dateTimeEnd
     * 
     * @var \DateTime
     */
    protected $dateTimeEnd = null;

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the dateTimeStart
     * 
     * @return \DateTime $dateTimeStart
     */
    public function getDateTimeStart()
    {
        return $this->dateTimeStart;
    }

    /**
     * Sets the dateTimeStart
     * 
     * @param \DateTime $dateTimeStart
     * @return void
     */
    public function setDateTimeStart(\DateTime $dateTimeStart)
    {
        $this->dateTimeStart = $dateTimeStart;
    }

    /**
     * Returns the dateTimeEnd
     * 
     * @return \DateTime $dateTimeEnd
     */
    public function getDateTimeEnd()
    {
        return $this->dateTimeEnd;
    }

    /**
     * Sets the dateTimeEnd
     * 
     * @param \DateTime $dateTimeEnd
     * @return void
     */
    public function setDateTimeEnd(\DateTime $dateTimeEnd)
    {
        $this->dateTimeEnd = $dateTimeEnd;
    }
}
