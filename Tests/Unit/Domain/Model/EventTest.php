<?php
namespace Conversion\Eventcalendar\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Mikel Wohlschlegel <mw@con-version.de>
 */
class EventTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Conversion\Eventcalendar\Domain\Model\Event
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Conversion\Eventcalendar\Domain\Model\Event();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDateTimeStartReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDateTimeStart()
        );
    }

    /**
     * @test
     */
    public function setDateTimeStartForDateTimeSetsDateTimeStart()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDateTimeStart($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'dateTimeStart',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDateTimeEndReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDateTimeEnd()
        );
    }

    /**
     * @test
     */
    public function setDateTimeEndForDateTimeSetsDateTimeEnd()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDateTimeEnd($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'dateTimeEnd',
            $this->subject
        );
    }
}
