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
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    calendar {
                        iconIdentifier = eventcalendar-plugin-calendar
                        title = LLL:EXT:eventcalendar/Resources/Private/Language/locallang_db.xlf:tx_eventcalendar_calendar.name
                        description = LLL:EXT:eventcalendar/Resources/Private/Language/locallang_db.xlf:tx_eventcalendar_calendar.description
                        tt_content_defValues {
                            CType = list
                            list_type = eventcalendar_calendar
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'eventcalendar-plugin-calendar',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:eventcalendar/Resources/Public/Icons/user_plugin_calendar.svg']
			);
		
    }
);
