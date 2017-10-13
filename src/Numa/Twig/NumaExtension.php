<?php

// src/Rentabo/Twig/RentaboExtension.php

namespace Numa\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class NumaExtension extends \Twig_Extension {

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'file_exists' => new \Twig_SimpleFunction('file_exists', array($this, 'getName')),
        );
    }
 
    public function getName()
    {
        return 'twig_extension';
    }

}

?>
