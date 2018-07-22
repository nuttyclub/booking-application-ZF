<?php

namespace Appointment\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGateway;

class AppointmentTable
{
    /**
     * TabelGateway holder
     */
    protected $tableGateway;

    /**
     * AppointmentTable Constructor
     */
    public function __construct(TableGateway $tableGateway)
    {
        //assign TableGateway to holder
        $this->tableGateway = $tableGateway;
    }

    /**
     * used to fetch all records in table
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Fetches a specific appointment
     */
    public function getAppointment($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }
        return $row;
    }

    /**
     * Updates an appointment
     */
    public function saveAppointment(Appointment $appointment)
    {
         $data = array(
             'username' => $appointment->username,
             'reason'  => $appointment->reason,
             'start_time'  => $appointment->start_time,
             'end_time'  => $appointment->end_time
         );

         $id = (int) $appointment->id;

         //ID cannot be 0
         if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
         }

         //if appointment does not exist, don't update
         if (! $this->getAppointment($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update appointment with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    /**
     * Delete a specific appointment record.
     */
    public function deleteAppointment($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
 }