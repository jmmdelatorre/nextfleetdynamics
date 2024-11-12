<?php
// controllers/SchedulesController.php

require_once __DIR__ . '/../models/Schedule.php'; // Include the Schedule model
require_once __DIR__ . '/../models/Terminal.php'; // Include the Terminal model
require_once __DIR__ . '/../models/Bus.php'; // Include the Bus model
require_once __DIR__ . '/../models/Driver.php'; // Include the Driver model

class SchedulesController
{
    private $scheduleModel;
    private $terminalModel;
    private $busModel;
    private $driverModel;

    public function __construct()
    {
        $this->scheduleModel = new Schedule();
        $this->terminalModel = new Terminal();
        $this->busModel = new Bus();
        $this->driverModel = new Driver();
    }

    public function index()
    {
        $schedules = $this->scheduleModel->getAllSchedules();
        $terminals = $this->terminalModel->getAllTerminals();
        $buses = $this->busModel->getAllBuses();
        $drivers = $this->driverModel->getAllDrivers();
        $navigations = getNavigations(); 
        require __DIR__ . '/../views/admin/ManageSchedules.php';
    }

    public function list()
    {
        $schedules = $this->scheduleModel->getAllSchedules(); // Fetch all schedules
        $output = '';

        foreach ($schedules as $schedule) {
            $scheduleJson = htmlspecialchars(json_encode($schedule), ENT_QUOTES, 'UTF-8');
            $output .= '<tr>
                    <td>' . htmlspecialchars($schedule['departure_terminal']) . '</td>
                    <td>' . htmlspecialchars($schedule['destination_terminal']) . '</td>
                    <td>' . htmlspecialchars($schedule['date']) . '</td>
                    <td>' . htmlspecialchars($schedule['time']) . '</td>
                    <td>' . htmlspecialchars($schedule['bus_name']) . '</td>
                    <td>' . htmlspecialchars($schedule['driver_name']) . '</td>
                    <td>' . htmlspecialchars($schedule['fare']) . '</td>
                    <td>
                        <button class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editScheduleModal"
                            onclick="populateEditModal(' . $scheduleJson . ')"
                            data-bs-toggle="tooltip"
                            title="Edit Schedule">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <a href="#"
                            class="btn btn-danger"
                            data-id="' . $schedule['id'] . '"
                            data-bs-toggle="tooltip"
                            title="Delete Schedule">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>';
        }

        echo $output; // Send the generated HTML back to the AJAX call
    }

    public function add()
    {
        $scheduleData = [
            'date' => $_POST['date'],
            'time' => $_POST['time'],
            'departure_terminal_id' => $_POST['departure_terminal_id'],
            'destination_terminal_id' => $_POST['destination_terminal_id'],
            'bus_id' => $_POST['bus_id'],
            'driver_id' => $_POST['driver_id'],
            'fare' => $_POST['fare']
        ];

        $addSuccess = $this->scheduleModel->addSchedule($scheduleData);
        header('Content-Type: application/json');
        if ($addSuccess) {
            echo json_encode(['success' => true, 'message' => 'Schedule added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add schedule.']);
        }
        exit;
    }

    public function update()
    {
        if (isset($_POST['id'], $_POST['date'], $_POST['time'], $_POST['departure_terminal_id'], $_POST['destination_terminal_id'], $_POST['bus_id'], $_POST['driver_id'], $_POST['fare'])) {
            $scheduleData = [
                'id' => $_POST['id'],
                'date' => $_POST['date'],
                'time' => $_POST['time'],
                'departure_terminal_id' => $_POST['departure_terminal_id'],
                'destination_terminal_id' => $_POST['destination_terminal_id'],
                'bus_id' => $_POST['bus_id'],
                'driver_id' => $_POST['driver_id'],
                'fare' => $_POST['fare'],
            ];

            $updateSuccess = $this->scheduleModel->updateSchedule($scheduleData);
            header('Content-Type: application/json');
            if ($updateSuccess) {
                echo json_encode(['success' => true, 'message' => 'Schedule updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update schedule.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        }
        exit;
    }

    public function delete($id)
    {
        $deleteSuccess = $this->scheduleModel->deleteSchedule($id);
        header('Content-Type: application/json');
        if ($deleteSuccess) {
            echo json_encode(['success' => true, 'message' => 'Schedule deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete schedule.']);
        }
        exit;
    }
}
