<?php
// controllers/DriversController.php

require_once __DIR__ . '/../models/Driver.php'; // Include the Driver model

class DriversController
{
    private $driverModel;

    public function __construct()
    {
        $this->driverModel = new Driver();
    }

    public function index()
    {
        $drivers = $this->driverModel->getAllDrivers();
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/ManageDrivers.php';
    }

    public function list()
    {
        $drivers = $this->driverModel->getAllDrivers(); // Fetch all drivers
        $output = '';

        foreach ($drivers as $driver) {
            $driverJson = htmlspecialchars(json_encode($driver), ENT_QUOTES, 'UTF-8');
            $output .= '<tr>
                    <td>' . htmlspecialchars($driver['name']) . '</td>
                    <td>' . htmlspecialchars($driver['license_number']) . '</td>
                    <td>' . htmlspecialchars($driver['status']) . '</td>
                    <td>
                        <button class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editDriverModal"
                            onclick="populateEditModal(' . $driverJson . ')"
                            data-bs-toggle="tooltip"
                            title="Edit Driver">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <a href="#"
                            class="btn btn-danger"
                            data-id="' . $driver['id'] . '"
                            data-bs-toggle="tooltip"
                            title="Delete Driver">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>';
        }

        echo $output; // Send the generated HTML back to the AJAX call
    }

    public function add()
    {
        $driverData = [
            'name' => $_POST['name'],
            'license_number' => $_POST['license_number'],
            'status' => $_POST['status']
        ];

        $addSuccess = $this->driverModel->addDriver($driverData);
        header('Content-Type: application/json');
        if ($addSuccess) {
            echo json_encode(['success' => true, 'message' => 'Driver added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add driver.']);
        }
        exit;
    }

    public function update()
    {
        if (isset($_POST['id'], $_POST['name'], $_POST['license_number'], $_POST['status'])) {
            $driverData = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'license_number' => $_POST['license_number'],
                'status' => $_POST['status']
            ];

            $updateSuccess = $this->driverModel->updateDriver($driverData);
            header('Content-Type: application/json');
            if ($updateSuccess) {
                echo json_encode(['success' => true, 'message' => 'Driver updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update driver.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        }
        exit;
    }

    public function delete($id)
    {
        $deleteSuccess = $this->driverModel->deleteDriver($id);
        header('Content-Type: application/json');
        if ($deleteSuccess) {
            echo json_encode(['success' => true, 'message' => 'Driver deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete driver.']);
        }
        exit;
    }
}
