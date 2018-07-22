<?php

namespace Appointment\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;

use Zend\Validator\StringLength;

 class Appointment implements InputFilterAwareInterface
 {
     /**
      * $id int - unique id of the record
      */
     public $id;

     /**
      * $username string - name of the patient
      */
     public $username;

     /**
      * $reason string - reason of visit
      */
     public $reason;

     /**
      * $start_time string - start time
      */
     public $start_time;

     /**
      * $end_time string - end time
      */
     public $end_time;

     /**
      * $inputFilter - InputFilter holder
      */
     protected $inputFilter;


    /**
     * make sure the parameters exists before assigning
     */
    public function exchangeArray($data)
    {
        $this->id              = (!empty($data['id'])) ? $data['id'] : null;
        $this->username        = (!empty($data['username'])) ? $data['username'] : null;
        $this->reason          = (!empty($data['reason'])) ? $data['reason'] : null;
        $this->start_time      = (!empty($data['start_time'])) ? $data['start_time'] : null;
        $this->end_time        = (!empty($data['end_time'])) ? $data['end_time'] : null;
    }

    /**
     * Return the the parameters values
     */
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'username' => $this->username,
            'reason'  => $this->reason,
            'start_time'  => $this->start_time,
            'end_time'  => $this->end_time
        ];
    }

    /**
     * Sets the input filter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    /**
     * returns the Input filters
     */
    public function getInputFilter()
    {
        //If input filter is already defined, use it
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        //Define validation for each of the parameters

        $inputFilter->add(array(
            'name'     => 'id',
            'required' => true,
            'filters'  => array(
                array('name' => ToInt::class),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'username',
            'required' => true,
            'filters'  => array(
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ),
            'validators' => array(
                array(
                    'name'    => StringLength::class,
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
            'name'     => 'reason',
            'required' => true,
            'filters'  => array(
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ),
            'validators' => array(
                array(
                    'name'    => StringLength::class,
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 1,
                        'max'      => 100,
                    ),
                ),
            ),
        ));

        $inputFilter->add(array(
           'name'     => 'start_time',
           'required' => true,
           'filters'  => array(
            ['name' => StripTags::class],
            ['name' => StringTrim::class]
           ),
           'validators' => array(
               array(
                   'name'    => StringLength::class,
                   'options' => array(
                       'encoding' => 'UTF-8',
                       'min'      => 1,
                       'max'      => 7,
                   ),
               ),
           ),
       ));

       $inputFilter->add(array(
           'name'     => 'end_time',
           'required' => true,
           'filters'  => array(
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
           ),
           'validators' => array(
               array(
                   'name'    => StringLength::class,
                   'options' => array(
                       'encoding' => 'UTF-8',
                       'min'      => 1,
                       'max'      => 7,
                   ),
               ),
           ),
       ));

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
 }