<?php
namespace Conversion\Eventcalendar\Controller;


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
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * eventRepository
     * 
     * @var \Conversion\Eventcalendar\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $events = $this->flattenEvents($this->eventRepository->findAll());
        $this->view->assign('events', json_encode($events));
    }

    /**
     * action show
     * 
     * @param \Conversion\Eventcalendar\Domain\Model\Event $event
     * @return void
     */
    public function showAction(\Conversion\Eventcalendar\Domain\Model\Event $event)
    {
        $this->view->assign('event', $event);
    }

    /**
     * @param $events
     * @return array
     */
    protected function flattenEvents($events) {
        $eventObjects = [];
        /** @var \Conversion\Eventcalendar\Domain\Model\Event $event */
        foreach ($events as $event) {
            $eventObject = [
                'uid' => $event->getUid(),
                'title' => $event->getTitle(),
                'pid' => $event->getPid(),
                'dateTimeStart' => $event->getDateTimeStart()->getTimestamp(),
                'dateTimeEnd' => $event->getDateTimeEnd()->getTimestamp()
            ];
            $eventObjects[] = $eventObject;
        }
        return $eventObjects;
    }
}
