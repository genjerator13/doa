<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),            
            //new Bc\Bundle\BootstrapBundle\BcBootstrapBundle(),
            new APY\DataGridBundle\APYDataGridBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Numa\DOASiteBundle\NumaDOASiteBundle(),
            new Numa\DOAAdminBundle\NumaDOAAdminBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Gregwar\ImageBundle\GregwarImageBundle(),
            new Endroid\Bundle\QrCodeBundle\EndroidQrCodeBundle(),
            new Lsw\MemcacheBundle\LswMemcacheBundle(),
            #new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Symfony\Bundle\DebugBundle\DebugBundle(),
            new Lsw\GuzzleBundle\LswGuzzleBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
