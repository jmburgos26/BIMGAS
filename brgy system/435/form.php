<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Information</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<style>
    .modal {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h6 {
        font-size: 20px;
    }

    .container {
        max-width: 600px;

        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>


<body>
    <div id="profileModal" class="containerss mt-5 modal" >
    <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
        <h6 class="text-center">Resident Information</h6>
        <form action="residents.php" method="POST">
            <div class=form-row>
                <div id="profileForm" class="form-group col-md-4">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="lname" name="lname" required>
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
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            </div>
            <div class=form-row>
                <div class="form-group col-md-4">
                    <label for="birthday">Birthday:</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="birthplace">Birthplace:</label>
                    <input type="text" class="form-control" id="birthplace" name="birthplace" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="age">Age:</label>
                    <input type="text" class="form-control" id="age" name="age" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="barangay">Barangay:</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" required>
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
                    <input type="text" class="form-control" id="household" name="household" required>
                </div>
            </div>

            <div class=form-row>
                <div class="form-group col-md-3">
                    <label for="sex">Sex:</label>
                    <select class="form-control" id="relationship" name="relationship">
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
                    <label for="relationship">Relationship Status:</label>
                    <select class="form-control" id="relationship" name="relationship" required>
                        <option value="">Select Relationship Status</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                        <!-- Add more options here -->
                    </select>
                </div>
            </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</body>

</html>