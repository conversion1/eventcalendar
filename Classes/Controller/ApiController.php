<?php
namespace Conversion\Eventcalendar\Controller;


use TYPO3\CMS\Extbase\Mvc\View\JsonView;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
class ApiController extends EventController
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\View\JsonView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = JsonView::class;

    public function getAction()
    {
        $events = $this->flattenEvents($this->eventRepository->findAll()->toArray());
        $this->view->setControllerContext($this->controllerContext);
        $this->view->assign('events', $events);
        $this->view->setVariablesToRender(array('events'));
        return $this->view->render();
    }

}
