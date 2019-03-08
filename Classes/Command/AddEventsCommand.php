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

class AddEventsCommand extends Command
{

    protected $eventTableName = 'tx_eventcalendar_domain_model_event';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Add events')
            ->setHelp('Add example events')
            ->addArgument('number', InputArgument::REQUIRED, 'Number of events to add (min 5)')
            ->addArgument('pid', InputArgument::REQUIRED, 'PID where new records should be stored');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('number')) {
            $output->writeln('How many events should be added?');
            $helper = $this->getHelper('question');
            $question = new Question('Number: ');
            $number = $helper->ask($input, $output, $question);
            $input->setArgument('number', $number);
        }
        if (!$input->getArgument('pid')) {
            $output->writeln('On which page should the records be stored (pid)?');
            $helper = $this->getHelper('question');
            $question = new Question('pid: ');
            $pid = $helper->ask($input, $output, $question);
            $input->setArgument('pid', $pid);
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
        $number = $input->getArgument('number');
        $pid = $input->getArgument('pid');
        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionForTable($this->eventTableName);
        $output = 'Creating random events';
        $randomEvents = $this->generateRandomEvents($number, $pid);
        foreach ($randomEvents as $event) {
            $connection->insert(
                $this->eventTableName,
                $event
            );
            $output .= LF . 'Added new event: ' . $event['title'];
        }
        $io->success($output);
    }

    /**
     * @param int $count
     * @param $pid
     * @return array
     */
    protected function generateRandomEvents($count = 50, $pid)
    {
        $count = $count -1;
        $events = [];
        $dummyTitles = file_get_contents('http://loripsum.net/api/'.$count.'/short/plaintext');
        $dummyTitles = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $dummyTitles);
        $dummyTitles = explode(PHP_EOL, $dummyTitles);
        $now = new \DateTime();
        foreach ($dummyTitles as $dummyTitle) {
            if ($dummyTitle) {
                $randomStartDate = $this->getRandomDate();
                $randomEndDate = clone $randomStartDate;
                $randomEndDate->modify('+3 hours');
                $event = [
                    'title' => substr($dummyTitle, 0, 50),
                    'date_time_start' => $randomStartDate->getTimestamp(),
                    'date_time_end' => $randomEndDate->getTimestamp(),
                    'pid' => $pid
                ];
            }
            $events[] = $event;
        }
        return $events;
    }

    /**
     * @return \DateTime
     */
    protected function getRandomDate() {
        $now = new \DateTime();
        $threeMonthsLater = new \DateTime();
        $threeMonthsLater->modify('+3 months');
        $randomTimeStamp = mt_rand($now->getTimestamp(), $threeMonthsLater->getTimestamp());
        $randomDate = new \DateTime();
        return $randomDate->setTimestamp($randomTimeStamp);
    }

}
