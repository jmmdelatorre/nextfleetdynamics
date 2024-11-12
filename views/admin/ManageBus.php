<!-- views/admin/ManageBus.php -->

<?php
$title = 'Manage Buses'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content p-4">
            <h1 style="color: white;" class="d-flex justify-content-between align-items-center">
                Manage Buses
                <!-- Add New Bus Button -->
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addBusModal">Add New Bus</button>
            </h1>


            <div class="card">
                <div class="card-body">
                    <!-- Display the buses in a table -->
                    <table id="busTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bus Name</th>
                                <th>License Plate</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($buses as $bus): ?>
                                <tr>
                                    <td><?= htmlspecialchars($bus['bus_name']) ?></td>
                                    <td><?= htmlspecialchars($bus['license_plate']) ?></td>
                                    <td><?= htmlspecialchars($bus['capacity']) ?></td>
                                    <td><?= htmlspecialchars($bus['status']) ?></td>
                                    <td>
                                        <button class="btn btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBusModal"
                                            onclick="populateEditModal(<?= htmlspecialchars(json_encode($bus)) ?>)"
                                            data-bs-toggle="tooltip"
                                            title="Edit Bus">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="index.php?url=ManageBuses/delete&id=<?= $bus['id'] ?>"
                                            onclick="return confirm('Are you sure?')"
                                            class="btn btn-danger"
                                            data-bs-toggle="tooltip"
                                            title="Delete Bus">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Add New Bus Modal -->
            <div class="modal fade" id="addBusModal" tabindex="-1" aria-labelledby="addBusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBusModalLabel">Add New Bus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addBusForm">
                                <div class="mb-3">
                                    <label for="bus_name" class="form-label">Bus Number</label>
                                    <input type="text" class="form-control" name="bus_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="license_plate" class="form-label">License Plate</label>
                                    <input type="text" class="form-control" name="license_plate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" name="capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Bus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Bus Modal -->
            <div class="modal fade" id="editBusModal" tabindex="-1" aria-labelledby="editBusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBusModalLabel">Edit Bus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editBusForm">
                                <input type="hidden" name="id" id="editBusId">
                                <div class="mb-3">
                                    <label for="editBusName" class="form-label">Bus Number</label>
                                    <input type="text" class="form-control" id="editBusName" name="bus_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editLicensePlate" class="form-label">License Plate</label>
                                    <input type="text" class="form-control" id="editLicensePlate" name="license_plate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editCapacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="editCapacity" name="capacity" required>
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

<!-- AJAX Script to submit the form -->
<script>
    function populateEditModal(bus) {
        $('#editBusId').val(bus.id);
        $('#editBusName').val(bus.bus_name);
        $('#editLicensePlate').val(bus.license_plate);
        $('#editCapacity').val(bus.capacity);
        $('#editStatus').val(bus.status);
    }
    $(document).ready(function() {
        // Initialize the DataTable
        $('#busTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });

        // Handle form submission
        $('#addBusForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                type: 'POST',
                url: 'index.php?url=ManageBuses/add', // Ensure this matches your URL
                data: $(this).serialize(),
                success: function(response) {
                    $('#addBusModal').modal('hide');
                    toastr.success(response.message, 'Success');
                    refreshBusList();
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error(error);
                }
            });
        });

        $('#editBusForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: 'index.php?url=ManageBuses/update',
                method: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    console.log(response);
                    $('#editBusModal').modal('hide');
                    if (response && response.message) {
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error('Unexpected response format.', 'Error');
                    }
                    refreshBusList();
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error(error);
                    alert('An error occurred while editing the bus. Please try again.');
                }
            });
        });

        function refreshBusList() {
            $.ajax({
                url: 'index.php?url=ManageBuses/list', // Ensure this is the correct URL
                success: function(data) {

                    // Destroy the existing DataTable instance
                    if ($.fn.DataTable.isDataTable('#busTable')) {
                        $('#busTable').DataTable().clear().destroy(); // Clear and destroy if already initialized
                    }

                    // Update the bus table with the new data
                    $('#busTable tbody').html(data); // Set the new rows

                    // Reinitialize the DataTable to account for new rows
                    $('#busTable').DataTable({
                        // You can add DataTable options here if needed
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching bus list:', error); // Log any error
                }
            });
        }
    });
</script>