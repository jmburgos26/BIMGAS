<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Read from the database
        $query = "select * from access where user_name = '$user_name' limit 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php");
                exit(); // Terminate script execution
            }
        }
    }

    $error_message = "Wrong username or password. Please try again!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Kanit:ital,wght@1,700&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,700;0,900;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="cssa/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
			margin: 0;
			padding: 0;
			bos-sizing: border-box;
		}

		body {
			background-image: url('image/brgyy.png');
			background-size: cover;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center center;
			background-color: rgba(0, 0, 0, 0.7);

		}

		.containerss {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 50px;
            flex-wrap: wrap;
			margin-right: 180px;
        }

        .containerss img {
            height: 200px; /* Adjust the width as needed */
            width: auto;
			margin-left: 20px;
			
        }

        .containerss h1 {
            color: white;
            font-weight: bolder;
            font-size: 50px;
            margin-top: 10px; /* Adjust the margin as needed */
			margin-left: 10px;
        }

        @media (max-width: 1044px) {
            .containerss {
                flex-direction: column;
				margin-right: 0px;
            }
			.containerss h1{
				font-size: 30px;
			}
			.containerss img {
            height: 150px;
        }
	}


		.container {
			max-width: 500px;
			padding: 0 20px;
			margin: 20px auto;
			

		}

		.wrapper {
			width: 100%;
			background: #209937;
			border-radius: 5px;
		}

		.wrapper .title {
			padding-top: 20px;
			line-height: 35px;
			background: #209937;
			text-align: center;
			border-radius: 5px 5px 0 0;
			font-size: 25px;
			font-weight: 600;
			color: white;

		}

		.wrapper form {
			padding: 30px 25px 25px 25px;
			text-align: center;

		}

		.wrapper form .row {
			height: 45px;
			margin-bottom: 15px;
			position: relative;
		}

		.wrapper form .row input {
			height: 100%;
			width: 100%;
			outline: none;
			padding-left: 60px;
			border-radius: 5px;
			border: 1px solid lightgray;
			font-size: 16px;
		}

		form .row input:focus {
			border-color: #3d6cb9;
			box-shadow: inset 0px 0px 2px 2px rgba(26, 188, 156, 0.25);
		}

		.wrapper form .row i {
			position: absolute;
			width: 47px;
			height: 100%;
			color: #fff;
			font-size: 18px;
			background: #2B651D;
			border: 1px solid #3d6cb9;
			border-radius: 5px 0 0 5px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.wrapper form .button input {
			width: 100px;
			height: 25px;
			color: black;
			font-size: 18px;
			font-weight: 400;
			padding-left: 0px;
			background: #fff;
			border: 1px solid #3d6cb9;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		form .button input:hover {
			background: #209937;
		}

        .wrapper form .signup-link {
			text-align: center;
			margin-top: 20px;
			font-size: 17px;

		}

		.wrapper form .signup-link a {
			color: #3d6cb9;

			text-decoration: none;
		}

		form .signup-link a:hover {
			text-decoration: underline;

		}
		
    </style>
</head>
<body>
    <div class="containerss">
        <img src="image/logus.png" alt="Image Description" class="img-fluid">
        <h1>Barangay Information <br> Management and Automated <br>Generated System</h1>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="title">
                <span> Admin Login</span>
            </div>
            <form method="post">
                <div class="row">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="email or username" name="user_name" required>
                </div>
                <div class="row">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="password" name="password" required>
                </div>
                <div class="row button">
                    <input type="submit" value="Login">
                </div>

                <!-- Add this section to display the error message -->
                <div class="error-message">
                    <?php if (isset($error_message)) : ?>
                        <p style="color: red; font-size: 16px; font-weight: bold; text-align: center;"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="signup-link"> Not a member? <a href="signup.php">Sign Up Now</a></div>
            </form>
        </div>
    </div>
</body>
</html>
