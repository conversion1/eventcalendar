<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Conversion.Eventcalendar',
            'Calendar',
            [
                'Event' => 'list, show'
            ],
            // non-cacheable actions
            [
                'Event' => ''
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('@import \'EXT:eventcalendar/Configuration/TSConfig/\'');

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'eventcalendar-plugin-calendar',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:eventcalendar/Resources/Public/Icons/user_plugin_calendar.svg']
        );
    }
);
