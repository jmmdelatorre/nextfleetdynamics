<!-- views/admin/ManageTerminals.php -->

<?php
$title = 'Manage Terminals'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->


        <!-- Main content area -->
        <div class=" main-content p-4">
            <h1 style="color: white;" class="d-flex justify-content-between align-items-center">
                Manage Terminals
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addTerminalModal">Add New Terminal</button>
            </h1>

            <div class="card">
                <div class="card-body">
                    <table id="terminalTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Terminal Name</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($terminals as $terminal): ?>
                                <tr>
                                    <td><?= htmlspecialchars($terminal['terminal_name']) ?></td>
                                    <td><?= htmlspecialchars($terminal['location']) ?></td>
                                    <td><?= htmlspecialchars($terminal['status']) ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTerminalModal" onclick="populateEditModal(<?= htmlspecialchars(json_encode($terminal)) ?>)">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="#"
                                            class="btn btn-danger"
                                            data-id="<?= $terminal['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            title="Delete Terminal">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add New Terminal Modal -->
            <div class="modal fade" id="addTerminalModal" tabindex="-1" aria-labelledby="addTerminalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTerminalModalLabel">Add New Terminal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addTerminalForm">
                                <div class="mb-3">
                                    <label for="terminal_name" class="form-label">Terminal Name</label>
                                    <input type="text" class="form-control" name="terminal_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Terminal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Terminal Modal -->
            <div class="modal fade" id="editTerminalModal" tabindex="-1" aria-labelledby="editTerminalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTerminalModalLabel">Edit Terminal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editTerminalForm">
                                <input type="hidden" name="id" id="editTerminalId">
                                <div class="mb-3">
                                    <label for="editTerminalName" class="form-label">Terminal Name</label>
                                    <input type="text" class="form-control" id="editTerminalName" name="terminal_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="editLocation" name="location" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status</label>
                                    <select class="form-select" id="editStatus" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function populateEditModal(terminal) {
        $('#editTerminalId').val(terminal.id);
        $('#editTerminalName').val(terminal.terminal_name);
        $('#editLocation').val(terminal.location);
        $('#editStatus').val(terminal.status);
    }
    $(document).ready(function() {

        function deleteTerminal(id) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    type: 'POST',
                    url: 'index.php?url=ManageTerminals/delete&id=' + id,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            refreshTerminalList();
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                    }
                });
            }
        }

        $('#terminalTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });


        $('#addTerminalForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'index.php?url=ManageTerminals/add',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addTerminalModal').modal('hide');
                    toastr.success(response.message, 'Success');
                    refreshTerminalList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        $('#editTerminalForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'index.php?url=ManageTerminals/update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#editTerminalModal').modal('hide');
                    // Check if response has a message
                    if (response && response.message) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error('Unexpected response format.', 'Error');
                    }
                    refreshTerminalList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        function refreshTerminalList() {
            $.ajax({
                url: 'index.php?url=ManageTerminals/list',
                success: function(data) {
                    console.log(data);
                    if ($.fn.DataTable.isDataTable('#terminalTable')) {
                        $('#terminalTable').DataTable().clear().destroy();
                    }

                    $('#terminalTable tbody').html(data);

                    $('#terminalTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching terminal list:', error);
                }
            });
        }

        // Modify delete button to call deleteTerminal function
        $('#terminalTable').on('click', '.btn-danger', function(e) {
            e.preventDefault();
            const terminalId = $(this).data('id');
            deleteTerminal(terminalId);
        });
    });
</script>