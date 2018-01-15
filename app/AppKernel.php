<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
// For init()
use Symfony\Component\ClassLoader\DebugClassLoader;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

class AppKernel extends Kernel {

    public function registerBundles() {
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
            //new Lsw\MemcacheBundle\LswMemcacheBundle(),
            //#new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Symfony\Bundle\DebugBundle\DebugBundle(),
            new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            //#new Lsw\ApiCallerBundle\LswApiCallerBundle(),
            //new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            //new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            //new JMS\TranslationBundle\JMSTranslationBundle(),
            //new Comur\ImageBundle\ComurImageBundle(),

            new Numa\DOASettingsBundle\NumaDOASettingsBundle(),
            new Numa\DOAModuleBundle\NumaDOAModuleBundle(),
            //new Numa\DOAApiBundle\NumaDOAApiBundle(),
            //new Lsw\GuzzleBundle\LswGuzzleBundle(),
            new Numa\DOAApiBundle\NumaDOAApiBundle(),
            //new Lsw\GuzzleBundle\LswGuzzleBundle(),
            new Numa\DOADMSBundle\NumaDOADMSBundle(),
            //new PUGX\AutocompleterBundle\PUGXAutocompleterBundle(),
            //new Circle\RestClientBundle\CircleRestClientBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new Numa\DOAStatsBundle\NumaDOAStatsBundle(),
            new Liip\ThemeBundle\LiipThemeBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),
            new MediaFigaro\GoogleAnalyticsApi\GoogleAnalyticsApi(),
            new Numa\QBBundle\NumaQBBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

//    // Add this to app/AppKernel.php
//    public function init()
//    {
//        ini_set('display_errors', 0);
//    }




    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
