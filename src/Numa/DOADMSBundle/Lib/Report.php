<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


class Report
{
    protected $phpExcelObject;
    protected $container;
    protected $entities;
    public $mapFields;
    public $creator = "";
    public $title = "";
    public $subject = "";
    public $desc = "";
    public $row=1;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Creates php excel object for the reports
     * @param string $creator
     * @param string $title
     * @param string $subject
     * @param string $desc
     * @return mixed phpexcelobject
     */
    public function createPHPExcelObject()
    {
        $rendererName = \PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibraryPath = (dirname(__FILE__) . '/../../../../vendor/mpdf/mpdf'); //works

        if (!\PHPExcel_Settings::setPdfRenderer(
            $rendererName, $rendererLibraryPath
        )
        ) {
            die(
                'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
                '<br />' .
                'at the top of this script as appropriate for your directory structure'
            );
        }

        $this->phpExcelObject = $this->container->get('phpexcel')->createPHPExcelObject();
        $this->phpExcelObject->getProperties()->setCreator($this->creator)
            ->setLastModifiedBy($this->creator)
            ->setTitle($this->title)
            ->setSubject($this->subject)
            ->setDescription($this->desc);
        $this->phpExcelObject->setActiveSheetIndex(0);
        return $this->phpExcelObject;
    }

    /**
     * creates excel response from the given phpexcelobject
     * @param $filename response file name
     * @return Response
     */
    public function createExcelResponse($filename)
    {
        $this->createPHPExcelObject();
        $this->createExcelContent();

        $download_path = $this->container->getParameter('upload_dealer');

        $writer = $this->container->get('phpexcel')->createWriter($this->phpExcelObject, 'Excel5');
        // create the response
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $filename);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $writer = $this->container->get('phpexcel')->createWriter($this->phpExcelObject, 'Excel5');
        $writer->save($download_path . $filename);

        return $response;
    }

    /**
     * Creates excel headers from the map array
     * @return $phpExcelObject
     */
    public function createExcelHeaders()
    {
        foreach ($this->mapFields as $key => $field) {
            $this->phpExcelObject->getActiveSheet()->setCellValue($key . "1", $field[1]);
            $this->createExcelHeadersStyle($key, $this->phpExcelObject);
        }
        return $this->phpExcelObject;
    }

    /**
     * Creates excel headers style
     * @return $phpExcelObject
     */
    public function createExcelHeadersStyle($key, $phpExcelObject)
    {
        $phpExcelObject->getActiveSheet()->getColumnDimension($key)->setAutoSize(true);
        $phpExcelObject->getActiveSheet()->getStyle($key . "1")->getFont()->setBold(true);
        return $phpExcelObject;
    }

    /**
     * Creates excel content from the map array and entities
     * @param $entities Collection
     */
    public function createExcelContent()
    {
        $this->createExcelHeaders();
        foreach ($this->mapFields as $key => $field) {
            $this->row = 2;
            foreach ($this->entities as $entity) {
                //dump($entity);die();
                $this->setCellValue($this->row, $key, $entity, $field);
                $this->row++;
            }
        }

    }

    /**
     * @param $letter
     * @param $number
     * @param $entity
     * @param $field
     */
    public function setCellValue($letter, $number, $entity, $field)
    {
        if ($entity instanceof Item) {
            $this->phpExcelObject->getActiveSheet()->setCellValue($letter . $number, $entity->get($field[0]));
        } elseif (is_array($entity)) {
            $this->phpExcelObject->getActiveSheet()->setCellValue($letter . $number, $entity->get($field[0]));
        }
    }

    // public abstract function
}