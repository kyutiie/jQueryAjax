<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>jQuery</title>
    <style>
        .bg{
            background-color: pink;
        }
        .container{
            margin-top: 100px;
        }
        #toggle-records h2{
            font-family: 'elephant';
            font-weight: 900;
            color: #860832;
            cursor: pointer;
        }
        .search{
            width: 40%;
            margin-bottom: 20px;
            border: 2px solid #860832;
            border-radius: 10px;
        }
        .btn{
            font-weight: 800;
        }
    
       
    </style>
</head>
<body class="bg">
<div id="dynamic-content" class="mt-3">

<div class="container ">
    <div id="toggle-records" class="container   text-start p-3 mb-3">
        <h2>Records</h2>
    </div>

    <!-- Search Bar -->
    <div class="search mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search Users" />
    </div>

    <div id="user-data" >
        <!-- Placeholder for AJAX data -->
    </div>

    <center>
        <nav  id="pagination-controls" class="mt-3">
            <!-- Pagination controls will be injected here -->
        </nav>
    </center>

    <a id="register-btn" class="btn btn-primary mt-3 ">Add User</a>
    </div>
    </div>
    <script>
$(document).ready(function () {
    function loadPage(page = 1, searchTerm = '') {
        $.ajax({
            url: `/users/home/${page}`,
            type: 'GET',
            dataType: 'json',
            data: { search: searchTerm },
            success: function (response) {
                let userHtml = '';
                let users = response.users;

                if (users.length > 0) {
                    users.forEach(user => {
                        userHtml += `
                        <div class="row border p-3 mb-3" data-id="${user.id}">
                            <div class="col-1">${user.id}</div>
                            <div class="col-2">${user.rmgc_first_name}</div>
                            <div class="col-1">${user.rmgc_last_name}</div>
                            <div class="col-3">${user.rmgc_email}</div>
                            <div class="col-1">${user.rmgc_gender}</div>
                            <div class="col-2">${user.rmgc_address}</div>
                            <div class="col">
                                <button class="btn btn-primary edit-btn m-1" data-id="${user.id}">Edit</button>
                                <button class="btn btn-danger delete-btn m-1" data-id="${user.id}">Delete</button>
                            </div>
                        </div>`;
                    });
                } else {
                    userHtml = '<div class="row border p-3"><div class="col text-center">No Records Found.</div></div>';
                }

                $('#user-data').html(userHtml);

                let paginationHtml = '';
                for (let i = 1; i <= response.total_pages; i++) {
                    paginationHtml += `
                        <button style="background:white;border:1px solid #860832;color:black;" class="btn mx-1 pagination-btn ${i === response.current_page ? 'active' : ''}" data-page="${i}">
                            ${i}
                        </button>`;
                }
                $('#pagination-controls').html(paginationHtml);
            },
            error: function () {
                alert('Failed to load data. Please try again.');
            }
        });
    }

    // Toggle button functionality
    $('#toggle-records').click(function () {
    const userData = $('#user-data');
    const toggleText = userData.is(':visible') ? 'Records' : 'Records';
    userData.slideToggle();
    $(this).find('h2').text(toggleText); // Update the text of the <h2> inside
   });

    // Event delegation for delete button
    $(document).on('click', '.delete-btn', function () {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `/users/delete/${userId}`,
                type: 'POST',
                success: function () {
                    $(`.row[data-id="${userId}"]`).remove();
                    alert('User deleted successfully.');
                },
                error: function () {
                    alert('Failed to delete the user. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '.pagination-btn', function () {
        const page = $(this).data('page');
        const searchTerm = $('#search').val();
        loadPage(page, searchTerm);
    });

    $('#search').on('input', function () {
        const searchTerm = $(this).val();
        loadPage(1, searchTerm);
    });

    $(document).on('click', '#register-btn', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/users/register',
            type: 'GET',
            success: function (response) {
                $('#dynamic-content').html(response);
            },
            error: function () {
                alert('Failed to load the register page.');
            }
        });
    });

    $(document).on('click', '.edit-btn', function (e) {
        e.preventDefault();
        const userId = $(this).data('id');
        $.ajax({
            url: `/users/edit/${userId}`,
            type: 'GET',
            success: function (response) {
                $('#dynamic-content').html(response);
            },
            error: function () {
                alert('Failed to load the edit page.');
            }
        });
    });

    loadPage();
});
</script>


</body>
</html>
