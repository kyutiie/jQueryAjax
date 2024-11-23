<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-secondary">
<div id="dynamic-content">

    <div class="container mt-5 p-5 border rounded bg-white">
        <div class="card-body">
            <h3 class="text-center mb-3">Update Form</h3>
            <?php $id = $user['id']?>
            <form id="update-form">
                
                    <div class="row">
                        <div class="col-md-5 my-5">
                            <div class="form-group">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <label class="form-label">First Name</label>
                                <input class="form-control" type="text" name="firstname" placeholder="Enter Firstname" value="<?= $user['rmgc_first_name']?>" required>
                            </div>
                        </div>
                        <div class="col-md-5 my-5">
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input class="form-control" type="text" name="lastname" placeholder="Enter Lastname" value="<?= $user['rmgc_last_name']?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-2 my-5">
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender" required>
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Female" <?= ($user['rmgc_gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                    <option value="Male" <?= ($user['rmgc_gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="LGBTQIA+" <?= ($user['rmgc_gender'] == 'LGBTQIA+') ? 'selected' : '' ?>>LGBTQIA+</option>
                                </select>  
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input class="form-control" type="text" name="address" placeholder="Enter Address" value="<?= $user['rmgc_address']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input class="form-control" type="email" name="email" placeholder="Enter Email Address" value="<?= $user['rmgc_email']?>" required>
                            </div>
                        </div>

                        <div class="col-md-10">
                        <a id="cancel-btn" class="btn btn-outline-secondary mt-3 mx-3 mb-4">Cancel</a>
                        </div>   
                        <div class="col-md-2 text-end">
                        <input type="submit" value="Update" name="submit" class="btn btn-info my-3 mx-3">

                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
<script>

$(document).on('submit', '#update-form', function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
        url: '/users/edit/<?php echo $user['id']; ?>',
        type: 'POST',
        data: $(this).serialize(),
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
                        alert('Failed to Update Profile.');
                    }
                });
            } else {
                alert('Update failed. Please try again.');
            }
        },
        error: function () {
            alert('Update failed. Please try again.');
        }
    });
});


    $(document).on('click', '#cancel-btn', function(e) {
        e.preventDefault(); // Prevent default behavior

        // Load the homepage directly
        $.ajax({
            url: '/',
            type: 'GET',
            success: function(response) {
                $('#dynamic-content').html(response); // Replace content dynamically
            },
            error: function(xhr, status, error) {
                console.error('Cancel Error:', status, error, xhr.responseText);
                alert('Failed to load the home page.');
            }
        });
    });

</script>


</body>
</html>
