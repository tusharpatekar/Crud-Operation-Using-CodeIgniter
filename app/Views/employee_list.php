<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    <h2 style="margin-bottom: 20px;">Employee List</h2>
        <a href="<?php echo base_url('employee/create'); ?>" class="btn btn-primary mb-3">Add Employee</a>
        
        <div class="table-responsive  mt-3">
            <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                <thead class="bg-light sticky-top">
                    <tr>
                        <th>SrNo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Gender</th>
                        <th>Education</th>
                        <th>Hobbies</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sr = 0; ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo ++$sr; ?></td>
                            <td><?php echo $employee['name']; ?></td>
                            <td><?php echo $employee['email']; ?></td>
                            <td><?php echo $employee['phone']; ?></td>
                            <td><?php echo $employee['country_name']; ?></td>
                            <td><?php echo $employee['state_name']; ?></td>
                            <td><?php echo $employee['city_name']; ?></td>
                            <td><?php echo $employee['gender']; ?></td>
                            <td><?php echo $employee['education']; ?></td>
                            <td><?php echo $employee['hobbies']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick="editEmployee(<?php echo $employee['id']; ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm"
                                    onclick="deleteEmployee(<?php echo $employee['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm" method="post">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="step step-1">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>
                        <div class="step step-2" style="display: none;">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" id="modal_country" class="form-control" required>
                                    <option value="">Select Country</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select name="state" id="modal_state" class="form-control" required>
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <select name="city" id="modal_city" class="form-control" required>
                                    <option value="">Select City</option>
                                  
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>
                        <div class="step step-3" style="display: none;">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Education</label>
                                <input type="text" name="education" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Hobbies</label>
                                <textarea name="hobbies" class="form-control" required></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button type="submit" class="btn btn-primary">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateProgressBar(step) {
            var percent = (step / 4) * 100;
            $('.progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
        }

        function loadStates(countryId, selectedStateId = null) {
            if (countryId) {
                $.ajax({
                    url: "<?php echo base_url('employee/get_states'); ?>",
                    method: "POST",
                    data: { country_id: countryId },
                    success: function (data) {
                        var states = JSON.parse(data);
                        $('#modal_state').empty();
                        $.each(states, function (index, state) {
                            var selected = (state.id == selectedStateId) ? 'selected' : '';
                            $('#modal_state').append('<option value="' + state.id + '" ' + selected + '>' + state.name + '</option>');
                        });
                    }
                });
            }
        }

        function loadCities(stateId, selectedCityId = null) {
            if (stateId) {
                $.ajax({
                    url: "<?php echo base_url('employee/get_cities'); ?>",
                    method: "POST",
                    data: { state_id: stateId },
                    success: function (data) {
                        var cities = JSON.parse(data);
                        $('#modal_city').empty();
                        $.each(cities, function (index, city) {
                            var selected = (city.id == selectedCityId) ? 'selected' : '';
                            $('#modal_city').append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                        });
                    }
                });
            }
        }

        function editEmployee(id) {
            $.ajax({
                url: "<?php echo base_url('employee/edit/'); ?>" + id,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var employee = data;

                    $('#editEmployeeForm').attr('action', "<?php echo base_url('employee/update/'); ?>" + employee.id);
                    $('#editEmployeeForm [name="name"]').val(employee.name);
                    $('#editEmployeeForm [name="email"]').val(employee.email);
                    $('#editEmployeeForm [name="phone"]').val(employee.phone);
                    $('#editEmployeeForm [name="country"]').val(employee.country_id);
                    $('#editEmployeeForm [name="gender"]').val(employee.gender);
                    $('#editEmployeeForm [name="education"]').val(employee.education);
                    $('#editEmployeeForm [name="hobbies"]').val(employee.hobbies);

                    loadStates(employee.country_id, employee.state_id);
                    loadCities(employee.state_id, employee.city_id);

                    $('.step').hide();
                    $('.step-1').show();
                    updateProgressBar(1);

                    $('#editEmployeeModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("An error occurred:", xhr.responseText);
                    alert("An error occurred while fetching the employee data. Please try again.");
                }
            });
        }

        $(document).ready(function () {
            $('.next-step').click(function () {
                var currentStep = $(this).closest('.step');
                var nextStep = currentStep.next('.step');

                if (nextStep.length) {
                    currentStep.hide();
                    nextStep.show();
                    updateProgressBar(nextStep.index() + 1);
                }
            });

            $('.prev-step').click(function () {
                var currentStep = $(this).closest('.step');
                var prevStep = currentStep.prev('.step');

                if (prevStep.length) {
                    currentStep.hide();
                    prevStep.show();
                    updateProgressBar(prevStep.index() + 1);
                }
            });

            $('#modal_country').change(function () {
                var countryId = $(this).val();
                loadStates(countryId);
            });

            $('#modal_state').change(function () {
                var stateId = $(this).val();
                loadCities(stateId);
            });
        });

        function deleteEmployee(id) {
            if (confirm("Are you sure you want to delete this employee?")) {
                $.ajax({
                    url: "<?php echo base_url('employee/delete/'); ?>" + id,
                    method: "POST",
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>

</html>