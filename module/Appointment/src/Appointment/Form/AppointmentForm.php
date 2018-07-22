<?php

namespace Appointment\Form;

 use Zend\Form\Form;

 class AppointmentForm extends Form
 {
     public function __construct($name = null)
     {
        //define the form parameters and their type

        parent::__construct('appointment');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'reason',
            'type' => 'Text',
            'options' => array(
                'label' => 'Reason',
            ),
        ));
        $this->add(array(
            'name' => 'start_time',
            'type' => 'Text',
            'options' => array(
                'label' => 'Start Time',
            ),
        ));
        $this->add(array(
            'name' => 'end_time',
            'type' => 'Text',
            'options' => array(
                'label' => 'End Time',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
     }
 }