<?php
namespace Conversion\Eventcalendar\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Mikel Wohlschlegel <mw@con-version.de>
 */
class EventControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Conversion\Eventcalendar\Controller\EventController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Conversion\Eventcalendar\Controller\EventController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllEventsFromRepositoryAndAssignsThemToView()
    {

        $allEvents = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventRepository = $this->getMockBuilder(\Conversion\Eventcalendar\Domain\Repository\EventRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $eventRepository->expects(self::once())->method('findAll')->will(self::returnValue($allEvents));
        $this->inject($this->subject, 'eventRepository', $eventRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('events', $allEvents);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenEventToView()
    {
        $event = new \Conversion\Eventcalendar\Domain\Model\Event();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('event', $event);

        $this->subject->showAction($event);
    }
}
