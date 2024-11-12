<!-- views/admin/ManageSchedules.php -->

<?php
$title = 'Manage Schedules'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content p-4">
            <h1 style="color: white;" class="d-flex justify-content-between align-items-center">
                Manage Schedules
                <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#addScheduleModal">Add New Schedule</button>
            </h1>

            <div class="card">
                <div class="card-body">
                    <table id="scheduleTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Departure</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Bus</th>
                                <th>Driver</th>
                                <th>Fare</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?= htmlspecialchars($schedule['departure_terminal']) ?></td>
                                    <td><?= htmlspecialchars($schedule['destination_terminal']) ?></td>
                                    <td><?= htmlspecialchars($schedule['date']) ?></td>
                                    <td><?= htmlspecialchars($schedule['time']) ?></td>
                                    <td><?= htmlspecialchars($schedule['bus_name']) ?></td>
                                    <td><?= htmlspecialchars($schedule['driver_name']) ?></td>
                                    <td><?= htmlspecialchars($schedule['fare']) ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal" onclick="populateEditModal(<?= htmlspecialchars(json_encode($schedule)) ?>)">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="#"
                                            class="btn btn-danger"
                                            data-id="<?= $schedule['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            title="Delete Schedule">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add New Schedule Modal -->
            <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addScheduleModalLabel">Add New Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addScheduleForm">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="time" class="form-label">Time</label>
                                    <input type="time" class="form-control" name="time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="departure_terminal_id" class="form-label">Departure</label>
                                    <select class="form-select" name="departure_terminal_id" required>
                                        <option value="">Select Terminal</option>
                                        <?php foreach ($terminals as $terminal): ?>
                                            <option value="<?= htmlspecialchars($terminal['id']) ?>">
                                                <?= htmlspecialchars($terminal['terminal_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="destination_terminal_id" class="form-label">Destination</label>
                                    <select class="form-select" name="destination_terminal_id" required>
                                        <option value="">Select Terminal</option>
                                        <?php foreach ($terminals as $terminal): ?>
                                            <option value="<?= htmlspecialchars($terminal['id']) ?>">
                                                <?= htmlspecialchars($terminal['terminal_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="bus_id" class="form-label">Bus</label>
                                    <select class="form-select" name="bus_id" required>
                                        <option value="">Select Bus</option>
                                        <?php foreach ($buses as $bus): ?>
                                            <option value="<?= htmlspecialchars($bus['id']) ?>">
                                                <?= htmlspecialchars($bus['bus_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="driver_id" class="form-label">Driver</label>
                                    <select class="form-select" name="driver_id" required>
                                        <option value="">Select Driver</option>
                                        <?php foreach ($drivers as $driver): ?>
                                            <option value="<?= htmlspecialchars($driver['id']) ?>">
                                                <?= htmlspecialchars($driver['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="fare" class="form-label">Fare</label>
                                    <input type="number" step="0.01" class="form-control" name="fare" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Schedule</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Schedule Modal -->
            <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editScheduleForm">
                                <input type="hidden" name="id" id="editScheduleId">
                                <div class="mb-3">
                                    <label for="editDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="editDate" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editTime" class="form-label">Time</label>
                                    <input type="time" class="form-control" id="editTime" name="time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editDeparture" class="form-label">Departure</label>
                                    <select class="form-select" id="editDeparture" name="departure_terminal_id" required>
                                        <option value="">Select Terminal</option>
                                        <?php foreach ($terminals as $terminal): ?>
                                            <option value="<?= htmlspecialchars($terminal['id']) ?>">
                                                <?= htmlspecialchars($terminal['terminal_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editDestination" class="form-label">Destination</label>
                                    <select class="form-select" id="editDestination" name="destination_terminal_id" required>
                                        <option value="">Select Terminal</option>
                                        <?php foreach ($terminals as $terminal): ?>
                                            <option value="<?= htmlspecialchars($terminal['id']) ?>">
                                                <?= htmlspecialchars($terminal['terminal_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editBusId" class="form-label">Bus</label>
                                    <select class="form-select" id="editBusId" name="bus_id" required>
                                        <option value="">Select Bus</option>
                                        <?php foreach ($buses as $bus): ?>
                                            <option value="<?= htmlspecialchars($bus['id']) ?>">
                                                <?= htmlspecialchars($bus['bus_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editDriverId" class="form-label">Driver</label>
                                    <select class="form-select" id="editDriverId" name="driver_id" required>
                                        <option value="">Select Driver</option>
                                        <?php foreach ($drivers as $driver): ?>
                                            <option value="<?= htmlspecialchars($driver['id']) ?>">
                                                <?= htmlspecialchars($driver['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editFare" class="form-label">Fare</label>
                                    <input type="number" step="0.01" class="form-control" id="editFare" name="fare" required>
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
    function populateEditModal(schedule) {
        $('#editScheduleId').val(schedule.id);
        $('#editDate').val(schedule.date);
        $('#editTime').val(schedule.time);
        $('#editDeparture').val(schedule.departure_terminal_id);
        $('#editDestination').val(schedule.destination_terminal_id);
        $('#editBusId').val(schedule.bus_id);
        $('#editDriverId').val(schedule.driver_id);
        $('#editFare').val(schedule.fare);
    }

    $(document).ready(function() {
        function deleteSchedule(id) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    type: 'POST',
                    url: 'index.php?url=ManageSchedules/delete&id=' + id,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            refreshScheduleList();
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

        $('#scheduleTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });

        $('#addScheduleForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'index.php?url=ManageSchedules/add',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#addScheduleModal').modal('hide');
                    toastr.success(response.message, 'Success');
                    refreshScheduleList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        $('#editScheduleForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'index.php?url=ManageSchedules/update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editScheduleModal').modal('hide');
                    toastr.success(response.message, 'Success');
                    refreshScheduleList();
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + xhr.responseText, 'Error');
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.btn-danger', function() {
            const id = $(this).data('id');
            deleteSchedule(id);
        });
    });

    function refreshScheduleList() {
        $.ajax({
            url: 'index.php?url=ManageSchedules/list',
            success: function(data) {
                console.log(data);
                if ($.fn.DataTable.isDataTable('#scheduleTable')) {
                    $('#scheduleTable').DataTable().clear().destroy();
                }

                $('#scheduleTable tbody').html(data);

                $('#scheduleTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching schedule list:', error);
            }
        });
    }
</script>