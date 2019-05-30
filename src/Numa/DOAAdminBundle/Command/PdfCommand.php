<?php

namespace Numa\DOAAdminBundle\Command;


use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;
use mikehaertl\pdftk\Pdf;


class PdfCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('numa:pdf')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1')
            ->addArgument('param2', InputArgument::OPTIONAL, 'param2');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');
        $param2 = $input->getArgument('param2');

        if ($command == 'importFromfolder') {
            //php app/console numa:pdf importFromfolder /var/www/doa/pdfs
            $state = $param2;
            $this->importFromFolder($param1,$state);
        }elseif($command == 'parseAllFillablePdf'){

            //php app/console numa:pdf parseAllFillablePdf
            $this->parseAllFillablePdf($param1);
        }
    }

    public function importFromFolder($folder,$state){
        //$folder = '/var/www/doa/web/temp';
        //php app/console numa:pdf importFromfolder /var/www/doa/pdfs
        $scanned_directory = array_diff(scandir($folder), array('..', '.'));
        foreach($scanned_directory as $file){
            $pdf = $folder."/".$file;
            dump($pdf);
            $fillablePdf = $this->getContainer()->get("numa.dms.media")->addFillablePdfFromFile($pdf, $state);
        }
        die();
    }

    public function parseAllFillablePdf(){
        $em = $this->getContainer()->get('numa.dms.media')->parseAllFillablePdf();
    }



}