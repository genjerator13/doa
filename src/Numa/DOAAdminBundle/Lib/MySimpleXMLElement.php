<?php
namespace Numa\DOAAdminBundle\Lib;

use Symfony\Component\DependencyInjection\SimpleXMLElement;

class MySimpleXMLElement extends SimpleXMLElement
{
    /**
     * @param SimpleXMLElement $element
     */
    public function replace(SimpleXMLElement $element)
    {
        $dom = dom_import_simplexml($this);
        $import = $dom->ownerDocument->importNode(
            dom_import_simplexml($element),
            TRUE
        );
        $dom->parentNode->replaceChild($import, $dom);
    }
}

?>