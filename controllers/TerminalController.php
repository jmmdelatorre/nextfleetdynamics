<?php
// controllers/TerminalController.php

require_once __DIR__ . '/../models/Terminal.php'; // Include the Terminal model

class TerminalController
{
    private $terminalModel;

    public function __construct()
    {
        $this->terminalModel = new Terminal();
    }

    public function index()
    {
        $terminals = $this->terminalModel->getAllTerminals();
        $navigations = getNavigations();
        require __DIR__ . '/../views/admin/ManageTerminals.php';
    }

    public function list()
    {
        $terminals = $this->terminalModel->getAllTerminals(); // Fetch all terminals
        $output = '';

        foreach ($terminals as $terminal) {
            $terminalJson = htmlspecialchars(json_encode($terminal), ENT_QUOTES, 'UTF-8');
            $output .= '<tr>
                    <td>' . htmlspecialchars($terminal['terminal_name']) . '</td>
                    <td>' . htmlspecialchars($terminal['location']) . '</td>
                    <td>' . htmlspecialchars($terminal['status']) . '</td>
                    <td>
                        <button class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editTerminalModal"
                            onclick="populateEditModal(' . $terminalJson . ')"
                            data-bs-toggle="tooltip"
                            title="Edit Terminal">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <a href="#"
                            class="btn btn-danger"
                            data-id="' . $terminal['id'] . '"
                            data-bs-toggle="tooltip"
                            title="Delete Terminal">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>';
        }

        echo $output; // Send the generated HTML back to the AJAX call
    }


    public function add()
    {
        $terminalData = [
            'terminal_name' => $_POST['terminal_name'],
            'location' => $_POST['location'],
            'status' => $_POST['status']
        ];
        $this->terminalModel->addTerminal($terminalData);
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Terminal added successfully.']);
        exit;
    }

    public function update()
    {
        if (isset($_POST['id'], $_POST['terminal_name'], $_POST['location'], $_POST['status'])) {
            $terminalData = [
                'id' => $_POST['id'],
                'terminal_name' => $_POST['terminal_name'],
                'location' => $_POST['location'],
                'status' => $_POST['status']
            ];

            $updateSuccess = $this->terminalModel->updateTerminal($terminalData);
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
        $deleteSuccess = $this->terminalModel->deleteTerminal($id);
        header('Content-Type: application/json');
        if ($deleteSuccess) {
            echo json_encode(['success' => true, 'message' => 'Terminal deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete terminal.']);
        }
        exit;
    }
}
