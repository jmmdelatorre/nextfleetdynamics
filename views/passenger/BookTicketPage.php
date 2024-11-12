<!-- views/passenger/BookTicketPage.php -->

<?php
$title = 'Book a Ticket'; // Set the page title
require __DIR__ . '/../main.php'; // Include the main layout
?>

<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        

        <!-- Main content area -->
        <div class=" main-content">
            <div class="container mt-5">
                <header class="text-center">
                    <h1 style="color: white;">Book a Ticket</h1>
                </header>
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="departure">Departure Terminal:</label>
                                <select id="departure" class="form-select">
                                    <option value="">Select Departure Terminal</option>
                                    <?php foreach ($terminals as $terminal): ?>
                                        <option value="<?= htmlspecialchars($terminal['id']) ?>"><?= htmlspecialchars($terminal['terminal_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="destination">Destination Terminal:</label>
                                <select id="destination" class="form-select">
                                    <option value="">Select Destination Terminal</option>
                                    <?php foreach ($terminals as $terminal): ?>
                                        <option value="<?= htmlspecialchars($terminal['id']) ?>"><?= htmlspecialchars($terminal['terminal_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button id="searchSchedules" class="btn btn-primary">Search Schedules</button>
                        </div>
                    </div>
                </div>

                <div id="availableSchedules" class="mt-5" style="display: none;"> <!-- Initially hidden -->
                    <h3 style="color: white;">Available Schedules</h3>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered" id="schedulesTable">
                                <thead>
                                    <tr>
                                        <th>Departure</th>
                                        <th>Destination</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Bus Name</th>
                                        <th>Driver Name</th>
                                        <th>Fare</th>
                                        <th>Remaining Seats</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="schedulesList">
                                    <!-- Schedules will be populated here via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <input type="hidden" id="scheduleId" name="scheduleId">
                    <input type="hidden" id="farePerSeat" name="farePerSeat"> <!-- Hidden input to store fare per seat -->

                    <div class="mb-3">
                        <label for="seatQuantity" class="form-label">Number of Seats</label>
                        <input type="number" id="seatQuantity" name="seatQuantity" class="form-control" min="1" value="1" required>
                        <div id="seatError" class="text-danger mt-2" style="display: none;"></div>
                    </div>

                    <!-- Display total fare -->
                    <div class="mb-3">
                        <label class="form-label">Total Fare: PHP <span id="totalFare">0.00</span></label>
                    </div>

                    <div id="creditCardDetails">
                        <div class="mb-3">
                            <label for="cardholderName" class="form-label">Cardholder Name</label>
                            <input type="text" id="cardholderName" name="cardholderName" class="form-control">
                            <div id="cardholderNameError" class="text-danger mt-2" style="display: none;"></div>
                        </div>

                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" id="cardNumber" name="cardNumber" class="form-control" maxlength="16">
                            <div id="cardNumberError" class="text-danger mt-2" style="display: none;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                <input type="text" id="expiryDate" name="expiryDate" class="form-control" placeholder="MM/YY">
                                <div id="expiryDateError" class="text-danger mt-2" style="display: none;"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" maxlength="3">
                                <div id="cvvError" class="text-danger mt-2" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#searchSchedules').on('click', function() {
            const departure = $('#departure').val();
            const destination = $('#destination').val();

            if (departure && destination) {
                $.ajax({
                    url: 'index.php?url=BookTicket/search',
                    type: 'GET',
                    data: {
                        departure: departure,
                        destination: destination
                    },
                    dataType: 'json',
                    success: function(data) {
                        const schedulesList = $('#schedulesList');
                        schedulesList.empty(); // Clear previous results

                        if (data.length > 0) {
                            data.forEach(schedule => {
                                schedulesList.append(`
                                    <tr>
                                        <td>${schedule.departure_terminal}</td>
                                        <td>${schedule.destination_terminal}</td>
                                        <td>${schedule.date}</td>
                                        <td>${schedule.time}</td>
                                        <td>${schedule.bus_name}</td>
                                        <td>${schedule.driver_name}</td>
                                        <td>${schedule.fare}</td>
                                        <td>${schedule.remaining_seats}</td>
                                        <td>
                                            <button class="btn btn-success" onclick="bookTicket(${schedule.id}, ${schedule.remaining_seats}, ${schedule.fare})">Book</button>
                                        </td>
                                    </tr>
                                `);
                            });
                            $('#availableSchedules').show(); // Show the schedules only when there are results
                            $('#schedulesTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        }); // Initialize DataTable
                        } else {
                            $('#availableSchedules').show(); // Still show the section if no schedules found
                            $('#schedulesTable').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "responsive": true
        }); // Initialize DataTable even if no data
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching schedules:', textStatus, errorThrown);
                    }
                });
            } else {
                alert('Please select both Departure and Destination.');
            }
        });

        window.bookTicket = function(scheduleId, remainingSeats, farePerSeat) {
            $('#scheduleId').val(scheduleId);
            $('#seatQuantity').attr('max', remainingSeats);
            $('#seatError').hide();
            $('#farePerSeat').val(farePerSeat);
            $('#totalFare').text((farePerSeat * 1).toFixed(2)); // Default total fare for 1 seat
            $('#bookingModal').modal('show');
        };

        // Calculate total fare on seat quantity change
        $('#seatQuantity').on('input', function() {
            const seatQuantity = parseInt($(this).val());
            const farePerSeat = parseFloat($('#farePerSeat').val());

            if (!isNaN(seatQuantity) && seatQuantity > 0) {
                $('#totalFare').text((farePerSeat * seatQuantity).toFixed(2));
            } else {
                $('#totalFare').text('0.00');
            }
        });

        $('#bookingForm').on('submit', function(e) {
            e.preventDefault();
            let valid = true;

            const scheduleId = $('#scheduleId').val();
            const seatQuantity = parseInt($('#seatQuantity').val());
            const maxSeats = parseInt($('#seatQuantity').attr('max'));
            const totalFare = parseFloat($('#totalFare').text());
            const cardholderName = $('#cardholderName').val();
            const cardNumber = $('#cardNumber').val();
            const expiryDate = $('#expiryDate').val();
            const cvv = $('#cvv').val();

            // Validate Seat Quantity
            if (seatQuantity > maxSeats) {
                $('#seatError').text(`Only ${maxSeats} seats available`).show();
                valid = false;
            } else {
                $('#seatError').hide();
            }

            // Validate Cardholder Name (letters and spaces only)
            if (!/^[A-Za-z\s]+$/.test(cardholderName)) {
                $('#cardholderNameError').text('Invalid cardholder name. Only letters and spaces are allowed.').show();
                valid = false;
            } else {
                $('#cardholderNameError').hide();
            }

            // Validate Card Number (16 digits only)
            if (!/^\d{16}$/.test(cardNumber)) {
                $('#cardNumberError').text('Card number must be 16 digits.').show();
                valid = false;
            } else {
                $('#cardNumberError').hide();
            }

            // Validate Expiry Date (MM/YY format and must not be in the past)
            const expiryRegex = /^(0[1-9]|1[0-2])\/?([0-9]{2})$/;
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear() % 100;
            const currentMonth = currentDate.getMonth() + 1;

            if (!expiryRegex.test(expiryDate)) {
                $('#expiryDateError').text('Expiry date must be in MM/YY format.').show();
                valid = false;
            } else {
                const [_, month, year] = expiryDate.match(expiryRegex);
                if (year < currentYear || (year == currentYear && month < currentMonth)) {
                    $('#expiryDateError').text('Expiry date cannot be in the past.').show();
                    valid = false;
                } else {
                    $('#expiryDateError').hide();
                }
            }

            // Validate CVV (3 digits only)
            if (!/^\d{3}$/.test(cvv)) {
                $('#cvvError').text('CVV must be 3 digits.').show();
                valid = false;
            } else {
                $('#cvvError').hide();
            }

            // Proceed with AJAX form submission if all validations pass
            if (valid) {
                $.ajax({
                    url: 'index.php?url=BookTicket/confirmBooking',
                    type: 'POST',
                    data: {
                        scheduleId: scheduleId,
                        seatQuantity: seatQuantity,
                        totalFare: totalFare,
                        cardholderName: cardholderName,
                        cardNumber: cardNumber,
                        expiryDate: expiryDate,
                        cvv: cvv
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#bookingModal').modal('hide');
                            toastr.success('Booking successful!', 'Success');
                            window.location.href = 'index.php?url=BookTicket/bookingQRCode&reference=' + response.referenceNumber;
                        } else {
                            toastr.error('Booking failed: ' + response.message, 'Error');
                        }
                    },

                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error booking ticket:', textStatus, errorThrown);
                    }
                });
            }
        });
    });
</script>