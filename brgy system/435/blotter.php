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
$query = "SELECT * FROM residents ";
$result = executeQuery($query);


$user_data = check_login($conn);

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
        position: relative;
        width: 100px;
    }

    .sidebar {
        position: fixed;
        width: 300px;
        height: 100%;
        background: linear-gradient(90deg, #0097b2, #7ed957);
        overflow-x: hidden;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
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

   

    form {
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
    }

    .profile {
        float: right;
        margin-right: 100px;
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


    }

    h3 {
        background-color: #dddddd;
        text-align: center;
        margin: auto;
        margin-top: 10px;
        margin-bottom: 2px;
        width: 90%;

    }

    .pagination {
        margin-top: 20px;
        margin-left: 50px;
        margin-top: 80px;



    }

    .label-entries {
        color: white;
    }

    #entries {
        width: 60px;

    }

    #prev-page {
        width: 50px;
        height: 30px;
        font-size: 20px;
        font-weight: 600;
    }

    #next-page {
        width: 50px;
        height: 30px;
        font-size: 20px;
        font-weight: 600;
    }




    .table-container {
        overflow: auto;
        /* Allow horizontal scrolling on small screens */
    }

    table {

        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 90%;
        background-color: white;
        margin: auto;
    }

    td,
    th {
        border: 4px solid #8a8787;
        text-align: left;
        padding: 10px;
    }

    th {
        padding: 25px;
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

    @media(max-width:1090px) {

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




}

@media(max-width:530px) {
.cards {
    grid-template-columns: 1fr;
}

.sidebar-header h1 {
    display: none;
}

.profile {    
        margin-right: 10px;
    }
    .pagination {
        margin-left: 10px;
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
                    <a href="residents.php">
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
                    <a href="blotter.php"  <?php if ($current_page == "blotter.php") echo 'class="active"'; ?>>
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
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Search...">
            <button class="search" type="submit">Search</button>
        </form>

        <div class="profile">
            <button> New Blotter</button>
        </div>

        <div class="pagination">
            <div class="first">
                <label class="label-entries" for="entries">Show Entries:</label>
                <input type="number" id="entries" min="1">
                <button id="prev-page">
                    < </button>
                        <button id="next-page"> ></button>
            </div>

        </div>

        <h3>Blotters</h3>
        <div class="table-container">
            <table>
                <tr>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Victim</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Paula Rivera</td>
                    <td>Jane </td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Scheduled</td>
                    <td>
                        <div class="table-button">
                            <i class="far fa-eye"></i>
                            <i class="fa-solid fa-pen"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Centro comercial Moctezuma</td>
                    <td>Jane </td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Scheduled</td>
                    <td>
                        <i class="fa-solid fa-eye"></i>
                        <i class="fa-solid fa-pen"></i>
                        <i class="fa-solid fa-trash"></i>

                    </td>
                </tr>
                <tr>
                    <td>Ernst Handel</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Settled</td>
                    <td>
                        <div class="table-button">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-pen"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Island Trading</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Settled</td>
                    <td>
                        <div class="table-button">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-pen"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Laughing Bacchus Winecellars</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Active</td>
                    <td>
                        <div class="table-button">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-pen"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Magazzini Alimentari Riuniti</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>Kwento mo yan eh</td>
                    <td>Active</td>
                    <td>
                        <div class="table-button">
                            <i class="fa-solid fa-eye"></i>
                            <i class="fa-solid fa-pen"></i>
                            <i class="fa-solid fa-trash"></i>
                        </div>
                    </td>
                </tr>

            </table>

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

</html>