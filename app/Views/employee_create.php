<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="container card-container">
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="mt-4">Add Employee</h2>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger" id="errorAlert">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?php echo esc($error) ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <form id="employeeForm" action="<?php echo base_url('employee/store'); ?>" method="post">
                <div id="stepper">
                    <!-- Step 1: Personal Information -->
                    <div class="step">
                        <h3>Personal Information</h3>
                        <div id="personalForm">
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
                                <input type="text" name="phone" class="form-control" required pattern="\d{10}" title="Phone number must be 10 digits" placeholder="Phone number must be 10 digits">
                            </div>
                            <button type="button" class="btn btn-primary next">Next</button>
                        </div>
                    </div>
                    <!-- Step 2: Address Information -->
                    <div class="step" style="display:none;">
                        <h3>Address Information</h3>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country" id="country" class="form-control" required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select name="state" id="state" class="form-control" required>
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <select name="city" id="city" class="form-control" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-secondary prev">Previous</button>
                        <button type="button" class="btn btn-primary next">Next</button>
                    </div>
                    <!-- Step 3: Additional Information -->
                    <div class="step" style="display:none;">
                        <h3>Additional Information</h3>
                        <div id="additionalForm">
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
                            <button type="button" class="btn btn-secondary prev">Previous</button>
                            <button type="submit" id="submitBtn" class="btn btn-primary">Add Employee</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var currentStep = 0;
        var steps = $('.step');

        // Hide all steps except the first one
        steps.hide().eq(currentStep).show();

        // Button click handlers
        $('#stepper .next').click(function() {
            if (validateStep(currentStep)) {
                steps.eq(currentStep).hide();
                currentStep++;
                steps.eq(currentStep).show();
            }
        });

        $('#stepper .prev').click(function() {
            steps.eq(currentStep).hide();
            currentStep--;
            steps.eq(currentStep).show();
        });

        // Form submission handler
        $('#employeeForm').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            if (validateForm()) {
                // If the form is valid, submit it via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        console.log('Form submitted successfully');
                        alert('Employee added successfully!');
                        window.location.href = '/'; 
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error('Error:', error);
                        showErrorAlert('There was an error submitting the form. Please try again.');
                    }
                });
            } else {
                // If the form is invalid, display an error message
                showErrorAlert('Please fill in all required fields.');
            }
        });

        // Step validation function
        function validateStep(step) {
            var isValid = true;
            steps.eq(step).find('input, select, textarea').each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

        // Form validation function
        function validateForm() {
            var isValid = true;
            $('#employeeForm')[0].checkValidity();
            $('#employeeForm').find('input, select, textarea').each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    $(this).addClass('is-invalid');

                    var step = $(this).closest('.step');
                    if (step.length && step.is(':hidden')) {
                        steps.hide();
                        step.show();
                    }
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            return isValid;
        }

        $('#country').change(function() {
            var country_id = $(this).val();
            if (country_id != '') {
                $.ajax({
                    url: "<?php echo base_url('employee/get_states'); ?>",
                    method: "POST",
                    data: { country_id: country_id },
                    success: function(data) {
                        var states = JSON.parse(data);
                        $('#state').empty().append('<option value="">Select State</option>');
                        $.each(states, function(index, state) {
                            $('#state').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });
                    }
                });
            }
        });

        $('#state').change(function() {
            var state_id = $(this).val();
            if (state_id != '') {
                $.ajax({
                    url: "<?php echo base_url('employee/get_cities'); ?>",
                    method: "POST",
                    data: { state_id: state_id },
                    success: function(data) {
                        var cities = JSON.parse(data);
                        $('#city').empty().append('<option value="">Select City</option>');
                        $.each(cities, function(index, city) {
                            $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            }
        });

        function showErrorAlert(message) {
            var errorAlert = $('<div class="alert alert-danger">' + message + '</div>');
            $('#errorAlert').empty().append(errorAlert);
            setTimeout(function() {
                errorAlert.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
</script>
</body>
</html>