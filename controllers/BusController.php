<?php
// controllers/BusController.php

require_once __DIR__ . '/../models/Bus.php'; // Include the Bus model

class BusController
{
    private $busModel;

    public function __construct()
    {
        $this->busModel = new Bus();
    }

    public function index()
    {
        $buses = $this->busModel->getAllBuses();
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/ManageBus.php';
    }

    public function list()
    {
        $buses = $this->busModel->getAllBuses(); // Fetch all buses
        $output = '';

        foreach ($buses as $bus) {
            $busJson = htmlspecialchars(json_encode($bus), ENT_QUOTES, 'UTF-8');

            $output .= '<tr>
                        <td>' . htmlspecialchars($bus['bus_name']) . '</td>
                        <td>' . htmlspecialchars($bus['license_plate']) . '</td>
                        <td>' . htmlspecialchars($bus['capacity']) . '</td>
                        <td>' . htmlspecialchars($bus['status']) . '</td>
                        <td>
                            <button class="btn btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editBusModal"
                                onclick="populateEditModal(' . $busJson . ')"
                                data-bs-toggle="tooltip"
                                title="Edit Bus">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <a href="index.php?url=ManageBuses/delete&id=<?= $bus[\'id\'] ?>"
                                onclick="return confirm(\'Are you sure?\')"
                                class="btn btn-danger"
                                data-bs-toggle="tooltip"
                                title="Delete Bus">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </td>
                    </tr>';
        }

        echo $output; // Send the generated HTML back to the AJAX call
    }


    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busData = [
                'bus_name' => $_POST['bus_name'],
                'license_plate' => $_POST['license_plate'],
                'capacity' => $_POST['capacity'],
                'status' => $_POST['status']
            ];

            // Add the bus using the model
            $this->busModel->addBus($busData);

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Bus added successfully.']);
            exit;
        }
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busData = [
                'id' => $_POST['id'],
                'bus_name' => $_POST['bus_name'],
                'license_plate' => $_POST['license_plate'],
                'capacity' => $_POST['capacity'],
                'status' => $_POST['status']
            ];

            $updateSuccess = $this->busModel->updateBus($busData);
            header('Content-Type: application/json');
            if ($updateSuccess) {
                echo json_encode(['success' => true, 'message' => 'Terminal Update Successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update terminal.']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        }
        exit;
    }

    public function delete($id)
    {
        $this->busModel->deleteBus($id); // Use the passed id
        header("Location: index.php?url=ManageBuses");
    }
}
