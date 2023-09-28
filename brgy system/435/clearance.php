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
        margin-top: 10px;
        border-bottom: 1px solid #f5f5f5;
        padding-bottom: 3px;
    }

    .name {
        text-align: center;
        flex-grow: 1;
        color: #f5f5f5;
    }

    .user {
        flex-shrink: 0;
        margin-left: 5px;
        margin-right: 8px;
        color: #7ed957;
        font-size: 20px;
        cursor: pointer;

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

    .cert-box {
        height: 40px;
        max-width: 700px;
        border: none;
        background-color: #FFFFFF;
        text-align: center;
        margin: 0 auto;
        /* Center horizontally using margin */
        margin-top: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Center vertically using flexbox */
    }

    h6 {
        font-weight: bold;
        color: #000000;
        font-size: 20px;
        text-align: center;
        margin: auto;
    }

    .button-container {
        text-align: center;
        margin-top: 40px;
    }

    .button {
        padding: 12px 22px;
        margin: 10px;
        background-color: #FFFFFF;
        color: #000000;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: bold;
        font-size: 15px;
    }

    .active-button {
        background-color: #7ed957;
        color: #FFFFFF;
    }
    .button:hover {
        background-color: #7ed957;
        color: #FFFFFF;
    }

    .container-box {
        height: 250px;
        width:96%;
        border: none;
        background-color: #D3D3D3;
        margin-top: 60px;
        margin: auto;

    }

   .search-container {
    display: flex;
    align-items: center;
    
    width: 800px;
    margin: auto;
    margin-top: 20px;
    margin-bottom: 10px;
}

.search {
    font-weight: bold;
    margin-right: 10px;
    margin-top: 30px;
}


.search-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    flex-grow: 1; /* Allow the input field to grow and take available space */
    margin-top: 30px;
    
}

.search-button {
    padding: 10px 20px;
    background-color: #fff;
    color: #000000;
    font-weight: bold;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-left: 15px;
    height: 45px;
    width: 100px;
    margin-top: 30px;
    float: right;
    
}

.search-button:hover {
    background-color: #7ed957;
    color: #fff;
}

    

    .generate-button {
        padding: 10px 15px;
        background-color: #16A637;
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        height: 45px;
        width: 150px;
        float:right;
        margin-top: 20px;
    }

    .generate-button:hover {
        background-color: #fff;
        color: #000000;
    }

    .additional-options-container {

        align-items: center;
        position: absolute;
        width: 800px;
        
        margin-left: 80px;
        margin-bottom: 20px;
    }

    input[type="radio"] {
        margin: 0 10px 0 10px;
    }

    .additional-options {
        display: none;
        flex-direction: column;
    }

    .other-input {
        border-radius: 10px;
        padding: 8px 15px;
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

        .main {
            width: calc(100% - 70px);
            left: 65px;
        }

        .top-bar {
            width: calc(100% - 70px);
        }
        .search-button {
            margin-right: 300px;
        }
    }

    @media(max-width:860px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }
        .search-button {
            margin-right: 500px;
        }
        .additional-options-container {

        
        margin-left: 20px;
        }
        .generate-button {
            margin-left: 150px;
            float:none;
            
        }


       
    }

    @media(max-width:530px) {
        .cards {
            grid-template-columns: 1fr;
        }
        .search-button {
            margin-right: 900px;
        }
        .generate-button {
            float:none;
            
        }
        
    }
</style>

<body>
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
                    <a href="clearance.php" <?php if ($current_page == "clearance.php") echo 'class="active"'; ?> >
                        <i class="fas fa-mail-bulk"></i>
                        <div class="title">Clearances</div>
                    </a>
                </li>
                <li>
                    <a href="blotter.php"  >
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
        </div><!--wag-->
        <div class="cert-box">

<h6>Certificates</h6>
</div>

<div class="button-container" id="button-container">
<button class="button">Barangay Clearance</button>
<button class="button">Certificate of Residency</button>
<button class="button" id="certificate-button">Certificate of Indigency</button>
</div>

<div class="container-box">
<div class="search-container">
    <div class="search">
        <label for="search">Name:</label>
    </div>
    
        <input type="text" id="search" class="search-input" placeholder="Enter a resident's name">
    
    <button class="search-button">Search</button>
</div>

<div class="additional-options-container">
    <div class="additional-options" id="additional-options">
        <input type="radio" name="certificate-reason" value="financial">Financial<br>
        <input type="radio" name="certificate-reason" value="medical">Medical<br>
        <input type="radio" name="certificate-reason" value="scholar">Scholar<br>
        <input type="radio" name="certificate-reason" value="others">Others:
        <input type="text" id="other-reason" class="other-input" name="other-reason"
            placeholder="Specify other reason"><br>
    </div>

    <button class="generate-button">Generate</button>
</div>

</div>



</div>

</body>
<script>
document.getElementById('certificate-button').addEventListener('click', function () {
var additionalOptions = document.getElementById('additional-options');
additionalOptions.style.display = additionalOptions.style.display === 'block' ? 'none' : 'block';
});

const btnList = document.querySelectorAll('.button');

btnList.forEach(button => {
button.addEventListener('click', () => {
document.querySelector('.active-button')?.classList.remove('active-button');
button.classList.add('active-button');

// Check if the clicked button is "Certificate of Indigency"
if (button.id === 'certificate-button') {
    // Show the additional options
    document.getElementById('additional-options').style.display = 'block';
} else {
    // Hide the additional options for other buttons
    document.getElementById('additional-options').style.display = 'none';
}
});
});
</script>

</html>