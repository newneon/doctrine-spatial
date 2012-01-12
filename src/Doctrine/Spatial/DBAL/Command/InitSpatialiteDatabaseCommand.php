<?php

/*
 * This file is part of Doctrine\Spatial.
 *
 * (c) Jan Sorgalla <jsorgalla@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Doctrine\Spatial\DBAL\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console;

/**
 * @author  Jan Sorgalla <jsorgalla@googlemail.com>
 */
class InitSpatialiteDatabaseCommand extends Console\Command\Command
{
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
        $this
        ->setName('dbal:init-spatialite-database')
        ->setDescription('Initializes a Spatialite database.')
        ->setHelp(<<<EOT
Initializes a Spatialite database.
EOT
        );
    }

    /**
     * @see Console\Command\Command
     */
    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $conn = $this->getHelper('db')->getConnection();

        $name = $conn->getDatabase();
        
        $output->writeln(sprintf('Initializing database <info>%s</info>...', $name));

        ob_start();
        $conn->executeUpdate("SELECT InitSpatialMetadata()");
        $message = ob_get_clean();

        $output->write($message);
        
        $output->write('Done');
    }
}
