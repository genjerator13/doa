<?php

namespace Numa\DOAAdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class ImageCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('numa:image')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');
        if ($command == 'resize') {
            $this->resize($param1);
        }
        if ($command == 'clearCacheDealer') {
            $this->clearCacheDealer($output,$param1);
        }
        if ($command == 'clearCacheItem') {

            $this->clearCacheItem($output,$param1);
        }
    }

    public function resize()
    {
        $image_path = $this->getContainer()->getParameter("web_path");
        $dir = $image_path . '/upload/itemsimages'; // path from top
        $scannedFiles = scandir($dir);

        $files = array_diff($scannedFiles, array('.', '..'));

        foreach ($files as $file) {
            $filename = $dir . "/" . $file;
            if (is_file($filename) && file_exists($filename)) {

                dump($filename);
                $this->getContainer()->get("numa.dms.images")->downsizeImage($filename, "downscale_resize");
            }
        }
    }

    public function clearCacheDealer($output,$dealerId){
        $total = $this->getContainer()->get('numa.dms.images')->clearCacheDealer($dealerId);
        $output->writeLn($total);
    }

    public function clearCacheItem($output,$itemId){

        $total = $this->getContainer()->get('numa.dms.images')->clearCacheImagesItemId($itemId);
        $output->writeLn($total);
    }

}