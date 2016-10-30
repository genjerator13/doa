<?php
namespace Numa\DOASettingsBundle\Twig;
use Numa\DOASettingsBundle\Util\SettingsLib;
use Numa\DOASiteBundle\Services\ExtraListener;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsExtension extends \Twig_Extension {
    /**
     * @var string[]
     */
    protected $sectionOrder = array();
    /**
     * @var Config
     */
    protected $config;


    /**
     * @param Config $config
     */
    public function __construct(SettingsLib $config){
        $this->config = $config;

    }
    public function setConfig(SettingsLib $config) {
        $this->config = $config;
    }
    /**
     * {@inheritDoc}
     */
    public function getName() {
        return 'numa_settings_template';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions() {
        if (version_compare(\Twig_Environment::VERSION, '1.12', '<')) {
            return array(
                'numa_settings' => new \Twig_Function_Method($this, 'getSetting'),
            );
        }
        return array(
            new \Twig_SimpleFunction('numa_settings', array($this, 'getSetting')),
        );
    }
    /**
     * @param string[] $sections
     * @return string[]
     */

    /**
     * @param string $name Name of the setting.
     * @return string|null Value of the setting.
     * @throws \RuntimeException If the setting is not defined.
     */
    public function getSetting($name) {
        return $this->config->get($name);
    }
}