<?php
namespace Conversion\Eventcalendar\Command;
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

use Conversion\Eventcalendar\Domain\Repository\EventRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DeleteEventsCommand extends Command
{

    protected $eventTableName = 'tx_eventcalendar_domain_model_event';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Delete event(s)')
            ->setHelp('Delete all or requested event(s) from events table')
            ->addArgument('uid', InputArgument::REQUIRED, 'uid of the event to delete. Set all! for all events');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('uid')) {
            $output->writeln('Enter uid of event. Enter all! to delete all events');
            $helper = $this->getHelper('question');
            $question = new Question('uid / all!: ');
            $uid = $helper->ask($input, $output, $question);
            $input->setArgument('uid', $uid);
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var SymfonyStyle $io */
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());
        $uid = $number = $input->getArgument('uid');
        $output = '';

        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionForTable($this->eventTableName);

        if ($uid == 'all!') {
            $events = $connection->select(
                ['uid', 'title'],
                $this->eventTableName,
                []
            );
        } else {
            $events = $connection->select(
                ['uid', 'title'],
                $this->eventTableName,
                ['uid' => $uid]
            );
        }

        if ($events->rowCount()) {
            foreach ($events as $event) {
                $connection->delete(
                    $this->eventTableName,
                    ['uid' => $event['uid']]
                );
                $output .= LF . 'Deleted event "' . $event['title'] . '" [uid: ' . $event['uid'] . ']';
            }
        } else {
            $output = 'No events found. No action performed.';
        }

        $io->success($output);
    }

}
