<?php
session_start();

include("connection.php");
include("functions.php");

function getfullName($first_name, $last_name)
{
    return "$first_name $last_name";
}

function getfullAddress($city, $province)
{
    return "$city $province";
}

$current_page = basename($_SERVER["PHP_SELF"]);

// Check if a search query is submitted
if (isset($_POST["search_query"])) {
    $search_query = $_POST["search_query"];

    // Use prepared statements to prevent SQL injection
    $search_query = '%' . $search_query . '%'; // Add wildcard characters for partial matching
    $search_query = mysqli_real_escape_string($conn, $search_query);

    $query = "SELECT * FROM residents WHERE first_name LIKE ? OR last_name LIKE ? OR CONCAT(first_name, ' ', last_name) LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // If no search query, fetch all residents
    $query = "SELECT * FROM residents";
    $result = executeQuery($query);
}

$user_data = check_login($conn);

if (isset($_POST["delete_id"])) {
    $delete_id = $_POST["delete_id"];

    // Use prepared statements to prevent SQL injection
    $deletequery = "DELETE FROM residents WHERE id=?";
    $stmt = $conn->prepare($deletequery);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to refresh the data
    header("Location: residents.php");
    exit();
}

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $age = $_POST['age'];
    $status = $_POST['status'];


    $insertquery = "INSERT INTO residents( first_name,last_name,contact,age,status) VALUES( '$first_name','$last_name', '$contact', '$age','$status')";

    if (executeQuery($insertquery)) {
        // Insertion successful
        header("Location: residents.php?insert_success");
        exit();
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <title>Ewan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@1,100&family=Roboto:wght@300;400&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    body {
        overflow-x: hidden;

    }


    .container {
        position: fixed;
        width: 300px;
        /* Adjust the width of the sidebar as needed */
        height: 100%;
        background: linear-gradient(90deg, #0097b2, #7ed957);
        overflow-x: hidden;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
        padding: 0 1px;
        font-size: 20px;
        left: 0;
    }

    .sidebar {
        position: fixed;
        width: 300px;
        height: 100%;
        background: linear-gradient(90deg, #0097b2, #7ed957);
        overflow-x: hidden;

        z-index: 2;
        padding: 0 10px;
        font-size: 20px;
    }

    .sidebar-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: none;
        margin-top: 30px;
        margin-bottom: 20px;
        border-bottom: 2px solid white;
        padding-bottom: 20px;
    }

    .sidebar-header img {
        height: 150px;
        /* Adjust the image size as needed */
        margin-bottom: 10px;
        /* Add spacing between the image and text */
    }

    .sidebar-header h1 {
        color: white;
        font-size: 18px;
    }

    .sidebar ul li {
        width: 100%;
        list-style: none;
    }

    .sidebar ul li:hover {
        background: #444;
        font-size: 22px;
    }

    .sidebar ul li a {
        width: 100%;
        text-decoration: none;
        color: white;
        height: 60px;
        display: flex;
        align-items: center;
    }

    .sidebar ul li a i {
        min-width: 60px;
        font-size: 24px;
        text-align: center;

    }

    .sidebar ul li a.active {
        background: #444;
        font-size: 22px;
    }

    .main {
        position: absolute;
        width: calc(100% - 300px);
        min-height: 100vh;
        left: 300px;
        background: #318F9A;
    }

    .top-bar {
        position: fixed;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: calc(100% - 300px);
        height: 60px;
        background: #318F9A;
        padding: 0 10px;
        padding-bottom: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .name {
        text-align: center;
        flex-grow: 1;
        color: #f5f5f5;
        margin-top: 10px;

    }

    h2 {
        font-size: 24px;
        font-weight: 600;
    }

    .user {
        flex-shrink: 0;
        margin-left: 1px;
        margin-right: 10px;
        color: #7ed957;
        font-size: 20px;
        cursor: pointer;
        background: #318F9A;
        background-color: #318F9A;

    }

    .user:hover {
        color: green;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        left: -100px;
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 8px 10px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: green;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }


    #search-form {
        margin-top: 100px;
        text-align: center;

    }

    input {
        width: 70%;
        padding: 10px;
        font-size: 16px;
        border-radius: 10px;


    }

    .search {
        width: 80px;
        height: 45px;
        border-radius: 10px;
        background: #ffff;
        font-size: 15px;
        outline: none;
    }

    .profile {
        float: right;
        margin-right: 50px;
        cursor: pointer;
        margin-top: 30px;

    }

    .profile button {
        font-size: 15px;
        cursor: pointer;
        padding: 10px;
        border-radius: 10px;
        background: #374F59;
        color: white;
        font-weight: 600;
        outline: none;


    }

    .pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        
        margin-left: 50px;
        margin-top: 110px;



    }

    h3 {
        background-color:#333333 ;
        text-align: center;
        margin: auto;
        margin-top: 10px;
        margin-bottom: 2px;
        width: 90%;
        font-size:20px;
        color:white;

    }

    



    .label-entries {
        color: white;
    }

    #entries {
        width: 60px;
        height: 30px;

    }

    .page {
        float: right;
        margin-right: 47px;
    }

    #prev-page {
        width: 64px;
        height: 30px;
        font-size: 15px;

    }

    #next-page {
        width: 64px;
        height: 30px;
        font-size: 15px;
    }


    #refresh {
        width: 70px;
        height: 30px;
        font-size: 20px;
        margin-right: 51px;
        
        float: right;
        



    }



    .table-container {
        overflow: auto;
        
        /* Set a maximum height for the table container */
        
        /* Allow horizontal scrolling on small screens */
    }

    table {

        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 90%;
        background-color: white;
        margin: auto;
        margin-bottom: 20px;
    }
    .fixed-header {
        position: sticky;
        top: 0;
       
    
        z-index: 1;
    }

    td {
        border: 2px solid #bfbfbf;
        text-align: left;
        padding: 10px;

    }

    th {
        position: sticky;
        top: 0;
        border: 2px solid #bfbfbf;
        text-align: center;
        background: #333333;
        color: white;
        padding: 18px;
        
    }

    tr:nth-child(even) {
        background-color: #ebebe0;
    }


    .search-form {
        align-items: center;
        position: absolute;
        top: 50%;
        right: 10px;
    }

    td i {
        padding: 7px;
        color: #fff;
        border-radius: 50%;
        cursor: pointer;
    }

    td i:hover {
        font-size: 20px;
    }


    .fa-eye {
        background: #32bea6;


    }

    .fa-pen {
        background: #63b4f4;
    }

    .fa-trash {
        background: #ed5564;
    }

    .delete-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .table-button {
        display: flex;
        align-items: center;
        /* Align icons vertically in the middle */
    }

    .table-button i {
        padding: 7px;
        color: #fff;
        border-radius: 50%;
        cursor: pointer;
        margin-right: 5px;
        /* Add some spacing between icons */
    }

    .table-button i:hover {
        font-size: 20px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 90%;
        background-color: rgba(0, 0, 0, 0.7);
        overflow-y: auto;
        /* Enable vertical scrolling for the modal */
    }

    .modal-content {
        background-color: #fff;
        margin: 15px auto;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        width: 50%;
        max-height: 90%;
        /* Limit the maximum height of the modal content */
        overflow-y: auto;
        /* Enable vertical scrolling for the modal content */
    }

    .popup {
        padding: 20px;
    }

    .btn {
        float: right;
        margin-top: 20px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
    }

    h6 {
        font-size: 30px;
        margin-bottom: 15px;
    }




    @media(max-width:1090px) {
        .container {
            width: 70px;
        }

        .sidebar {
            width: 70px;
        }

        .sidebar-header img {
            height: 60px;
        }

        .sidebar-header h1 {
            font-size: 10px;
        }

        .card-container img {
            font-size: 50px;

        }

        .main {
            width: calc(100% - 70px);
            left: 65px;
        }

        .top-bar {
            width: calc(100% - 70px);
        }

        .sidebar-header h1 {
            display: none;
        }

        .card-container img {
            font-size: 60px;
        }

        .card-title {
            font-size: 25px;
        }

        .value {
            font-size: 25px;
        }

        .user {
            font-size: 15px;
        }


    }

    @media(max-width:860px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .sidebar-header h1 {
            display: none;
        }

        h3 {
            width: 100%;
        }

        .profile {
            margin-right: 10px;
        }

        .pagination {
            margin-left: 20px;
        }

        table {
            margin-left: 10px;
        }
        .page {
        
        margin-right: 10px;
    }

    }

    @media(max-width:530px) {
        .cards {
            grid-template-columns: 1fr;
        }

        .sidebar-header h1 {
            display: none;
        }
        
    }
</style>

<body>
    <div class="container"> <!-- wag nyong baguhin-->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="image/logus.png" alt="Profile Image"> <!-- Replace with the URL of your image -->
                <h1>ADMIN</h1>
            </div>
            <ul>

                <li>
                    <a href="index.php">
                        <i class="fa-solid fa-chart-line"></i>
                        <div class="title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="residents.php" <?php if ($current_page == "residents.php")
                        echo 'class="active"'; ?>>
                        <i class="fa-solid fa-person-walking"></i>
                        <div class="title">Residents</div>
                    </a>
                </li>
                <li>
                    <a href="clearance.php">
                        <i class="fas fa-mail-bulk"></i>
                        <div class="title">Clearances</div>
                    </a>
                </li>
                <li>
                    <a href="blotter.php">
                        <i class="far fa-list-alt"></i>
                        <div class="title">Blotter</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-list-check"></i>
                        <div class="title">Project</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-users-line"></i>
                        <div class="title">Barangay Officials</div>
                    </a>
                </li>
            </ul>
        </div>
    </div> <!--Wag-->

    <div class="main"> <!--wag-->
        <div class="top-bar">
            <div class="name">
                <h2>Barangay Boot Information Management System</h2>
            </div>
            <div class="dropdown"> <!-- Updated user icon with dropdown -->
                <div class="user">
                    <i class="fa-solid fa-user fa-lg"></i>
                    <i class="fas fa-sort-down"></i>
                </div>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Change Password</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <form id="search-form" method="POST">
            <input type="text" id="search-input" name="search_query" placeholder="Search...">
            <button class="search" type="submit">Search</button>
        </form>


        <div class="profile">
            <button id="show-popup"> Add Profile</button>
        </div>

        <div class="pagination">
            <div class="first">
                <label class="label-entries" for="entries">Show Entries:</label>
                <select id="entries">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>



                <a href="residents.php">
                    <button id="refresh">
                    <i class="fa-solid fa-arrows-rotate" style="color: #000000;"></i>
                    </button>
                </a>



        </div>


        <h3>RESIDENTS</h3>
        <div class="table-container">
        <div class="fixed-header">
        <table>
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Relationship Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            </div>

                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td>
                            <?php echo getfullName($row["first_name"], $row["last_name"]) ?>
                        </td>
                        <td>
                            <?php echo $row["contact"] ?>
                        </td>
                        <td>
                            <?php echo getfullName($row["city"], $row["province"]) ?>
                        </td>
                        <td>
                            <?php echo $row["age"] ?>
                        </td>
                        <td>
                            <?php echo $row["status"] ?>
                        </td>
                        <td>

                            <div class="table-button">
                                <i class="fa-solid fa-eye"></i>
                                <i class="fa-solid fa-pen"></i>
                                <form method="POST" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id'] ?>">
                                    <button type="submit" class="delete-button">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div id="profileModal" class="containerss mt-5 modal">
                                <div class="modal-content">
                                    <span class="close" id="closeModal">&times;</span>
                                    <h6 class="text-center">Resident Information</h6>
                                    <form method="post" class=popup>
                                        <div class=form-row>
                                            <div id="profileForm" class="form-group col-md-4">
                                                <label for="first_name">First Name:</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="last_name">Last Name:</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="middle">Middle Name:</label>
                                                <input type="text" class="form-control" id="middle" name="middle">
                                            </div>
                                        </div>

                                        <div class=form-row>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contact">Phone:</label>
                                                <input type="text" class="form-control" id="contact" name="contact"
                                                    required>
                                            </div>
                                        </div>
                                        <div class=form-row>
                                            <div class="form-group col-md-4">
                                                <label for="birthday">Birthday:</label>
                                                <input type="date" class="form-control" id="birthday" name="birthday"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="birthplace">Birthplace:</label>
                                                <input type="text" class="form-control" id="birthplace" name="birthplace"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="age">Age:</label>
                                                <input type="text" class="form-control" id="age" name="age" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="barangay">Barangay:</label>
                                                <input type="text" class="form-control" id="barangay" name="barangay"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="purok">Purok:</label>
                                                <select class="form-control" id="purok" name="purok" required>
                                                    <option value="">Select</option>
                                                    <option value="1">Purok 1</option>
                                                    <option value="2">Purok 2</option>
                                                    <option value="3">Purok 3</option>
                                                    <!-- Add more states here -->
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="household">Household no#:</label>
                                                <input type="text" class="form-control" id="household" name="household"
                                                    required>
                                            </div>
                                        </div>

                                        <div class=form-row>
                                            <div class="form-group col-md-3">
                                                <label for="sex">Sex:</label>
                                                <select class="form-control" id="sex" name="sex">
                                                    <option value="">Select </option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="blood">Blood Type:</label>
                                                <select class="form-control" id="blood" name="blood">
                                                    <option value="">Select </option>
                                                    <option value="a">A</option>
                                                    <option value="b">B</option>
                                                    <option value="ab">AB</option>
                                                    <option value="o">O</option>
                                                    <option value="na">N/A</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-5">
                                                <label for="status">Relationship Status:</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="">Select Relationship Status</option>
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="divorced">Divorced</option>
                                                    <option value="widowed">Widowed</option>
                                                    <!-- Add more options here -->
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <div class="page">
                <button id="prev-page">
                    Previous </button>
                <button id="next-page"> Next</button>
            </div>
        </div>
    </div>

</body>

<script>
    let entriesPerPage = 10; // Default number of entries per page
    let currentPage = 1;

    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    let numRows = rows.length;

    function showPage(page) {
        const start = (page - 1) * entriesPerPage;
        const end = page * entriesPerPage;

        for (let i = 0; i < numRows; i++) {
            if (i >= start && i < end) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function updatePagination() {
        numRows = rows.length; // Update the number of rows when the table changes
        const totalPages = Math.ceil(numRows / entriesPerPage);
        const entriesInput = document.getElementById('entries');

        // Update the input field to reflect the current number of entries per page
        entriesInput.value = entriesPerPage;

        // Update the "Next" button disabled state
        document.getElementById('next-page').disabled = currentPage >= totalPages;

        // Update the "Previous" button disabled state
        document.getElementById('prev-page').disabled = currentPage <= 1;
    }

    // Initial display
    showPage(currentPage);
    updatePagination();

    // Event listener for the "Previous" button
    document.getElementById('prev-page').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
            updatePagination();
        }
    });

    // Event listener for the "Next" button
    document.getElementById('next-page').addEventListener('click', () => {
        const totalPages = Math.ceil(numRows / entriesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
            updatePagination();
        }
    });

    // Event listener for the entries input
    document.getElementById('entries').addEventListener('input', (event) => {
        const newEntriesPerPage = parseInt(event.target.value);
        if (!isNaN(newEntriesPerPage) && newEntriesPerPage >= 1) {
            entriesPerPage = newEntriesPerPage;
            currentPage = 1; // Reset to the first page when changing entries per page
            showPage(currentPage);
            updatePagination();
        }
    });

</script>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
<script>
    const profileModal = document.getElementById('profileModal');
    const addProfileButton = document.getElementById('show-popup');
    const closeModalButton = document.getElementById('closeModal');

    // Show the modal when the "Add Profile" button is clicked
    addProfileButton.addEventListener('click', () => {
        profileModal.style.display = 'block';
    });

    // Hide the modal when the close button is clicked
    closeModalButton.addEventListener('click', () => {
        profileModal.style.display = 'none';
    });

    // Hide the modal if the user clicks outside of it
    window.addEventListener('click', (event) => {
        if (event.target === profileModal) {
            profileModal.style.display = 'none';
        }
    });

    // Prevent the form submission for now
    const profileForm = document.getElementById('profileForm');
    profileForm.addEventListener('submit', (event) => {
        event.preventDefault();
        // You can add form submission logic here
    });
</script>
<script>
        // JavaScript code to update the fixed header
        const table = document.querySelector('.table-container table');
        const fixedHeader = document.querySelector('.fixed-header table');

        // Update the fixed header when scrolling
        table.addEventListener('scroll', () => {
            fixedHeader.style.transform = `translateY(${table.scrollTop}px)`;
        });
    </script>





</html>