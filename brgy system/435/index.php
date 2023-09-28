<?php
session_start();

include("connection.php");
include("functions.php");

$current_page = basename($_SERVER["PHP_SELF"]);

$user_data = check_login($conn);

if (isset($_POST["delete"])) {
  $delete = $_POST["delete"];

  $deletequery = "DELETE FROM diary WHERE id=$delete";
  executeQuery($deletequery);
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
        background-color:white;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        left:-100px;
        z-index: 1;
    }

    .dropdown-content a {
        color:black;
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

    /* dito umpisa */

    .card-container {
        margin: auto;
        /* Center the card container horizontally */
        margin-top: 100px;
        width: 300px;
        /* Set the width of the card container */
        text-align: center;
        /* Center the content inside the card container */
        padding: 20px;
        /* Add some padding to the card */

    }

    .card-container img {
        height: 100px;
        margin-bottom: 10px;
        color: #444;
    }

    .card-title {
        font-size: 30px;
        font-weight: 600;
        color: white;
    }

    .value {
        font-size: 30px;
        font-weight: 600;
        color: white;
        margin-top: 20px;
    }

    .cards {
        margin-top: 1px;
        width: 100%;
        padding: 35px 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
    }

    .cards .card {
        background: linear-gradient(90deg, #0097b2, #7ed957);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
    }

    .number {
        font-size: 35px;
        font-weight: 500;
        color: white
    }

    .card-name {
        color: #444;
        font-weight: 600;
    }

    .icon-box i {
        font-size: 45px;
        color: #444;
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
                    <a href="index.php" <?php if ($current_page == "index.php") echo 'class="active"'; ?> >
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
        </div> <!--wag-->

        <div class="card-container"> <!--dito umpisa ang ayus -->
            <img src="image/residents.png" alt="Profile Image">
            <div class="card-title">Total Residents: <span>28</span></div>

        </div>

        <div class="cards">
            <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Male</div>
                </div>
                <div class="icon-box">
                    <i class="fas fa-male"></i>
                </div>
            </div>


            <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Female</div>
                </div>
                <div class="icon-box">
                    <i class="fas fa-female"></i>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Senior Citizens</div>
                </div>
                <div class="icon-box">
                    <i class="fas fa-wheelchair"></i>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Married</div>
                </div>
                <div class="icon-box">
                    <i class="fas fa-ring"></i>
                </div>
            </div>
             <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Voters</div>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-fingerprint"></i>
                </div>
            </div>
              <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Blotters</div>
                </div>
                <div class="icon-box">
                    <i class="far fa-list-alt"></i>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Projects</div>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
             <div class="card">
                <div class="card-content">
                    <div class="number">67</div>
                    <div class="card-name">Officials</div>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-users-line"></i>
                </div>
            </div>


        </div>


</body>

</html>