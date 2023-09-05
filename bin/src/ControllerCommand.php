<?php

namespace Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputFormatterStyle;

use Make\Make;

class ControllerCommand extends Command {

    protected function configure() {
        $this->setName("make:controller")
            ->setDescription("Creates a controller file in app/Controllers")
            ->addArgument('controllerName', InputArgument::REQUIRED, 'What is the name of the controller you wish to create? Controller name must be capitalized and Plural with ending with the suffix Controller. eg. BooksController');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $make = new Make();
        $controllerName = $input->getArgument('controllerName');

        // Confirm that the Controller name entered is formatted correctly

        // Confirm that it contains the word controller
        if (strpos($controllerName, "Controller") === false) {
            $output->writeln('<error>Error: Your controller name is not named correctly. It should be in plural and should end with the word Controller. Eg. BooksController </error>');
        } else if ($controllerName[0] !== strtoupper($controllerName[0])) {
            // The first character does not start with an upper case
            $output->writeln('<error>Error: Your controller name must start with a capital letter eg. BooksController</error>');
        } else if (strpos($controllerName, ".") !== false) {
            $output->writeln('<error>Error: Your controller name cannot contain a dot. Here is an example of a good controller name: BooksController</error>');
        } else {
            $result = $make->makeController($controllerName);

            $output->writeln('<info>Your controller has been created in app/Controllers/</info>' . $controllerName . '.php');
        }
    }
}
