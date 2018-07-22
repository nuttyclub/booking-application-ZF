<?php

namespace Appointment\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Appointment\Model\Appointment;          
 use Appointment\Form\AppointmentForm;
 use Appointment\Model\AppointmentTable;

 class AppointmentController extends AbstractActionController
 {

    /**
     * Holder for the table
     */
    protected $appointmentTable;

    /**
     * Appointment Controller Constructor
     */
    public function __construct(AppointmentTable $table)
    {
        //Assign AppointmentTable to the table holder variable so you can reuse it in this class.
        $this->appointmentTable = $table;
    }

    /**
     * Called on initial load
     */
    public function indexAction()
    {
        //sends the model to the view with all the appointments in the table.
        return new ViewModel(array(
            'appointments' => $this->appointmentTable->fetchAll(),
        ));
    }

    /**
     * This function is called when someone wants to add a new appointment
     */
    public function addAction()
    {
        //initialize the form
        $form = new AppointmentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        //Only allow GET. if not fail fast.
        if (! $request->isPost()) {
            return ['form' => $form];
        }

        //initialize model
        $appointment = new Appointment();
        $form->setInputFilter($appointment->getInputFilter());
        $form->setData($request->getPost());

        //if form has errors, don't do update.
        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $appointment->exchangeArray($form->getData());
        //save to table
        $this->appointmentTable->saveAppointment($appointment);
        return $this->redirect()->toRoute('appointment');
    }

    /**
     * This function edits an existing appointment in the table
     */
    public function editAction()
    {
        //grab the id of the record that you want to edit.
        $id = (int) $this->params()->fromRoute('id', 0);

        //ID cannot be 0, fail fast
        if ($id === 0) {
            return $this->redirect()->toRoute('appointment', ['action' => 'add']);
        }

        try {
            //lookup the record
            $appointment = $this->appointmentTable->getAppointment($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('appointment', ['action' => 'index']);
        }

        //initialize form
        $form = new AppointmentForm();
        $form->bind($appointment);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        //Only allow GET. if not fail fast.
        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($appointment->getInputFilter());
        $form->setData($request->getPost());

         //if form has errors, don't do update.
        if (! $form->isValid()) {
            return $viewData;
        }

        //Save the appointment to the table
        $this->appointmentTable->saveAppointment($appointment);

        return $this->redirect()->toRoute('appointment', ['action' => 'index']);
    }

    /**
     * This function deletes a specific record
     */
    public function deleteAction()
    {
        //grab the id of the record that you want to edit.
        $id = (int) $this->params()->fromRoute('id', 0);

        //ID cannot be 0, fail fast
        if (!$id) {
            return $this->redirect()->toRoute('appointment');
        }

        $request = $this->getRequest();

        //Only allow POST. if not fail fast.
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            //Make sure user is certain to delete the record
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->appointmentTable->deleteAppointment($id);
            }

            return $this->redirect()->toRoute('appointment');
        }

        return array(
            'id'    => $id,
            'appointment' => $this->appointmentTable->getAppointment($id)
        );
    }
 }