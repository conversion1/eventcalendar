<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Conversion.Eventcalendar',
            'Calendar',
            'Event Calendar'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('eventcalendar', 'Configuration/TypoScript', 'Event Calendar');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_eventcalendar_domain_model_event', 'EXT:eventcalendar/Resources/Private/Language/locallang_csh_tx_eventcalendar_domain_model_event.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_eventcalendar_domain_model_event');

    }
);
