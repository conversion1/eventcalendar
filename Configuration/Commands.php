<?php

return [
    'eventcalendar:events:delete' => [
        'class' => \Conversion\Eventcalendar\Command\DeleteEventsCommand::class,
        'schedulable' => false,
    ],
    'eventcalendar:events:add' => [
        'class' => \Conversion\Eventcalendar\Command\AddEventsCommand::class,
        'schedulable' => false,
    ]
];
