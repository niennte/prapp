<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;

/**
 * Class TimeReportForm
 * Form for uploading the CSV report.
 *
 * @package Application\Form
 */
class TimeReportForm extends Form
{
    const CSV_UPLOAD = 'report';
    const LABEL = 'Upload Time Report';

    public function __construct($name = null)
    {
        parent::__construct('time_report');

        $this->add([
            'type'  => 'file',
            'name' => self::CSV_UPLOAD,
            'attributes' => [
                'id' => 'file'
            ],
            'options' => [
                'label' => self::LABEL,
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);

        $this->addInputFilter();
    }

    /**
     * Validation
     * Set reasonable constraints on file size and MIME types
     */
    public function addInputFilter()
    {
        $inputFilter = new InputFilter();

        $fileInput = new FileInput(self::CSV_UPLOAD);

        $fileInput->setRequired(true);

        $fileInput->getValidatorChain()
            ->attachByName('filesize',      ['max' => 204800])
            ->attachByName('filemimetype',  ['mimeType' => 'text/plain,text/csv']);

        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }
}