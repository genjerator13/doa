<?php
// src/AppBundle/Form/Extension/ImageTypeExtension.php

namespace Numa\CCCAdminBundle\Form\Extension;

use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\CustomRate;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UploadTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return FileType::class;
    }
    /**
     * Add the file_path option
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('file_path'));
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['file_path'])) {
            $parentData = $form->getParent()->getData();

            $fileUrl = null;
            $fileName =null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();

                if($parentData instanceof Customers) {
                    $fileName = $parentData->getRatePdf();
                    $fileUrl = $accessor->getValue($parentData, $options['file_path']);
                }elseif($parentData instanceof CustomRate) {
                    $fileName = $parentData->getSrc();
                    $fileUrl = $accessor->getValue($parentData, $options['file_path']);
                }
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['file_url'] = $fileUrl;
            $view->vars['file_name'] = $fileName;
        }
    }
}