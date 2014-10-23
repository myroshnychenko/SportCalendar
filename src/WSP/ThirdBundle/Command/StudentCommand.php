<?php

namespace WSP\ThirdBundle\Command;

use WSP\ThirdBundle\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentCommand extends ContainerAwareCommand
{
    const BATCH_SIZE = 100;

    protected function configure()
    {
        $this
            ->setName('student:generate:path')
            ->setDescription('Generate path for students')
        ;
    }
    /**
     * Generate unique path for all students
     *
     * Here we are using Doctrine Iterator, see:
     * @link http://doctrine-orm.readthedocs.org/en/latest/reference/batch-processing.html#iterating-results
     */
    protected function generatePath()
    {
        /** @var StudentService $studentService */
        $studentService = $this->getContainer()->get('wsp_third_bundle.student');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $studentsIterator = $em->getRepository('ThirdBundle:Student')->getStudentsIterator();
        $i = 0;
        foreach ($studentsIterator as $row) {
            /** @var Student $student */
            $student = $row[0];
            $path = $studentService->getUniquePath($student->getName());
            $student->setPath($path);
            if (($i % self::BATCH_SIZE) === 0) {
                $em->flush(); // Executes all updates.
                $em->clear(); // Detaches all objects from Doctrine!
                gc_collect_cycles();
            }
            ++$i;
        }
        $em->flush();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);
        $this->generatePath();
        $timeElapsed = microtime(true) - $startTime;
        $output->writeln(
            sprintf('Batch size: %d pcs', self::BATCH_SIZE)
        );
        $output->writeln(
            sprintf('Time elapsed: %.3f s', $timeElapsed)
        );
        $output->writeln(
            sprintf('Memory usage: %.3f Mb', memory_get_peak_usage() / pow(2, 20))
        );
    }
} 