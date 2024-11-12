<!-- views/admin/ManageDrivers.php -->

<?php
$title = 'Manage Drivers'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content p-4">
            <h1 style="color: white;" class="d-flex justify-content-between align-items-center">
                Manage Drivers
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addDriverModal">Add New Driver</button>
            </h1>

            <div class="card">
                <div class="card-body">
                    <table id="driverTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>License Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($drivers as $driver): ?>
                                <tr>
                                    <td><?= htmlspecialchars($driver['name']) ?></td>
                                    <td><?= htmlspecialchars($driver['license_number']) ?></td>
                                    <td><?= htmlspecialchars($driver['status']) ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDriverModal" onclick="populateEditModal(<?= htmlspecialchars(json_encode($driver)) ?>)">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="#"
                                            class="btn btn-danger"
                                            data-id="<?= $driver['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            title="Delete Driver">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add New Driver Modal -->
            <div class="modal fade" id="addDriverModal" tabindex="-1" aria-labelledby="addDriverModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDriverModalLabel">Add New Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addDriverForm">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Driver Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="license_number" class="form-label">License Number</label>
                                    <input type="text" class="form-control" name="license_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Driver</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Driver Modal -->
            <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDriverModalLabel">Edit Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editDriverForm">
                                <input type="hidden" name="id" id="editDriverId">
                                <div class="mb-3">
                                    <label for="editDriverName" class="form-label">Driver Name</label>
                                    <input type="text" class="form-control" id="editDriverName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editLicenseNumber" class="form-label">License Number</label>
                                    <input type="text" class="form-control" id="editLicenseNumber" name="license_number" required>
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
    function populateEditModal(driver) {
        $('#editDriverId').val(driver.id);
        $('#editDriverName').val(driver.name);
        $('#editLicenseNumber').val(driver.license_number);
        $('#editStatus').val(driver.status);
    }
    $(document).ready(function() {

        function deleteDriver(id) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    type: 'POST',
                    url: 'index.php?url=ManageDrivers/delete&id=' + id,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            refreshDriverList();
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

        $('#driverTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });

        $('#addDriverForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'index.php?url=ManageDrivers/add',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#addDriverModal').modal('hide');
                    toastr.success(response.message, 'Success');
                    refreshDriverList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        $('#editDriverForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'index.php?url=ManageDrivers/update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#editDriverModal').modal('hide');
                    if (response && response.message) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error('Unexpected response format.', 'Error');
                    }
                    refreshDriverList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        function refreshDriverList() {
            $.ajax({
                url: 'index.php?url=ManageDrivers/list',
                success: function(data) {
                    console.log(data);
                    if ($.fn.DataTable.isDataTable('#driverTable')) {
                        $('#driverTable').DataTable().clear().destroy();
                    }

                    $('#driverTable tbody').html(data);

                    $('#driverTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching driver list:', error);
                }
            });
        }

        $('#driverTable').on('click', '.btn-danger', function(e) {
            e.preventDefault();
            const driverId = $(this).data('id');
            deleteDriver(driverId);
        });
    });
</script>