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
        //set_error_handler( array( $this, 'myErrorHandler' ) );
        $this
            ->setName('numa:image')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');

        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($command == 'resize') {
            $this->resize($param1);
        }
    }

    public function resize($period)
    {
        $image_path = $this->getContainer()->getParameter("web_path");
        $dir = $image_path . '/upload/itemsimages'; // path from top
        $scanedFiles = scandir($dir);

        $files = array_diff($scanedFiles, array('.', '..'));

        foreach ($files as $file) {
            $filename = $dir . "/" . $file;
            if (is_file($filename) && file_exists($filename)) {

                dump($filename);
                $this->getContainer()->get("numa.dms.images")->downsizeImage($filename, "downscale_resize");
            }
        }

        die();

    }

}