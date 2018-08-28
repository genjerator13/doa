<?php

namespace Numa\DOAAdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class PdfCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('numa:pdf')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');

        if ($command == 'importFromfolder') {
            dump($param1);
            dump($command);
            $this->importFromFolder($param1);
        }

    }
    public function importFromFolder($folder){
        //$folder = '/var/www/doa/web/temp';
        dump($folder);
        $scanned_directory = array_diff(scandir($folder), array('..', '.'));
        foreach($scanned_directory as $file){
            $pdf = $folder."/".$file;
            dump($pdf);
            $fillablePdf = $this->getContainer()->get("numa.dms.media")->addFillablePdfFromFile($pdf);
        }
        die();
    }

}