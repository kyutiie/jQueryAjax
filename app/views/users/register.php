<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .register-form{
            margin-top: 150px;
            border-radius: 20px;
            background-color: white;
        }
        h3{
            font-family: 'elephant';
            font-weight: 900;
            color: #860832;
            padding: 20px 50px;

        }
    </style>
</head>

<body class="bg-secondary">
<div id="dynamic-content">
    <div class="container  border rounded bg-white">
        <div class="card-body">
            <h3 class="text-center mb-3">Registration Form</h3>
            
            <!-- Form -->
            <form id="register-form">
                <div class="row">
                    <!-- First Name -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input class="form-control" type="text" name="firstname" placeholder="Enter Firstname" required>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastname" placeholder="Enter Lastname" required>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="" selected hidden>Select Gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="LGBTQIA+">LGBTQIA+</option>
                            </select>  
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" name="address" placeholder="Enter Address" required>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter Email Address" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 d-flex justify-content-between">
                        <a id="cancel-btn" class="btn btn-outline-secondary mt-3">Cancel</a>
                        <input type="submit" value="Register" class="btn btn-info mt-3">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on('submit', '#register-form', function (e) {
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: '/users/register',
        type: 'POST',
        data: $(this).serialize(), // Serialize form data
        success: function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert('Registration successful!');
                // Dynamically load homepage content
                $.ajax({
                    url: '/', // The homepage route
                    type: 'GET',
                    success: function (homepageContent) {
                        $('#dynamic-content').html(homepageContent); // Load content dynamically
                    },
                    error: function () {
                        alert('Failed to load the home page.');
                    }
                });
            } else {
                alert('Registration failed. Please try again.');
            }
        },
        error: function () {
            alert('Registration failed. Please try again.');
        }
    });
});

$(document).on('click', '#cancel-btn', function (e) {
    e.preventDefault(); // Prevent default behavior
    $.ajax({
        url: '/', // Load the homepage directly
        type: 'GET',
        success: function (response) {
            $('#dynamic-content').html(response); // Replace content dynamically
        },
        error: function () {
            alert('Failed to load the home page.');
        }
    });
});


</script>

</body>
</html>
