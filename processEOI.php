<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1060e2c82b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <title>SwinCloud - Apply for Jobs</title>
</head>

<body>
    <header id="header">
        <?php include 'navbar.inc'; ?>
    </header>
    <main class="congrats">
        <div class="congrats-container">
        <?php
    include('functions.php');

    function sanitise_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    ;

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST['job_reference']) || empty(trim($_POST['job_reference']))) {
            $errors[] = "Please enter a correct job reference such as SD1";
        } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
            $errors[] = "Please enter the job reference such as SD1";
        } else {
            $job_reference = sanitise_input($_POST['job_reference']);
        };

        if (!isset($_POST['first_name']) || empty(trim($_POST['first_name']))) {    
            $errors[] = "Please enter your first name";
        } else {
            $first_name = sanitise_input($_POST['first_name']);
        };

        if (!isset($_POST['last_name']) || empty(trim($_POST['last_name']))) {
            $errors[] = "Please enter your last name";
        } else {
            $last_name = sanitise_input($_POST['last_name']);
        };


        if (!isset($_POST['dob']) || empty(trim($_POST['dob']))) {
            $errors[] = "Please enter your date of birth";
        } else {
            $dob_input = sanitise_input($_POST['dob']);
            $dob_parts = explode('/', $dob_input);
            if (count($dob_parts) != 3 || !checkdate($dob_parts[1], $dob_parts[0], $dob_parts[2])) {
                $errors[] = "Please enter a valid date of birth in the format dd/mm/yyyy";
            } else {
                $dob_date = $dob_parts[0];
                $dob_month = $dob_parts[1];
                $dob_year = $dob_parts[2];
                $dob = "$dob_year-$dob_month-$dob_date";
            };
        };

        if (!isset($_POST['gender']) || empty(trim($_POST['gender']))) {
            $errors[] = "Please select your gender";
        } else {
            $gender = sanitise_input($_POST['gender']);
        };


        if (!isset($_POST['address']) || empty(trim($_POST['address']))) {  
            $errors[] = "Please enter your street address";
        } else {
            $address = sanitise_input($_POST['address']);
        };


        if (!isset($_POST['suburb']) || empty(trim($_POST['suburb']))) {  
            $errors[] = "Please enter your suburb/town";
        } else {
            $suburb = sanitise_input($_POST['suburb']);
        };


        if (!isset($_POST['state']) || empty(trim($_POST['state']))) {
            $errors[] = "Please select your state";
        } else {
            $state = sanitise_input($_POST['state']);
        };



        if (!isset($_POST['postcode']) || empty(trim($_POST['postcode']))) {
            $errors[] = "Please enter your postcode";
        } else if (!preg_match("/^\d{4}$/", $_POST['postcode'])) {
            $errors[] = "Please enter a valid 4-digit postcode";
        } else {
            $postcode = sanitise_input($_POST['postcode']);
        };




        if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
            $errors[] = "Please enter your email address";
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address";
        } else {
            $email = sanitise_input($_POST['email']);
        };



        if (!isset($_POST['phone']) || empty(trim($_POST['phone']))) { 
            $errors[] = "Please enter your phone number";
        } else if (!preg_match("/^\d{8,12}$/", $_POST['phone'])) {
            $errors[] = "Please enter a valid phone number (8 to 12 digits)";
        } else {
            $phone = sanitise_input($_POST['phone']);
        };



        if (!isset($_POST['skills'])) {
            $errors[] = "Please select at least one skill";
        } else {
            $skills = $_POST['skills'];
            $other_skills = "";
            if (in_array('other', $_POST['skills'])) {
                if (!empty(trim($_POST['other_skills']))) {
                    $other_skills = sanitise_input($_POST['other_skills']);
                    $skills[] = $other_skills;
    
                    $final_skills = implode(',', $skills);
                } else {
                    $errors[] = "Please enter your other skills";
                }
                
            } else {
                $final_skills = implode(',', $skills);
            }
        };
        


        if (empty($errors)) {
            $conn = connectMySQL();

            $table_name = "eoi"; // Table name
            $result = $conn->query("SHOW TABLES LIKE '$table_name'");
            $table_exists = $result->num_rows > 0;

            if (!$table_exists) {
                $sql = "CREATE TABLE eoi (
                    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
                    Job_Reference_Number VARCHAR(5) NOT NULL,
                    First_Name VARCHAR(20) NOT NULL,
                    Last_Name VARCHAR(20) NOT NULL,
                    Date_of_Birth DATE NOT NULL,
                    Gender ENUM('Male', 'Female', 'Other') NOT NULL,
                    Street_Address VARCHAR(40) NOT NULL,
                    Suburb_Town VARCHAR(40) NOT NULL,
                    State ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
                    Postcode VARCHAR(4) NOT NULL,
                    Email_Address VARCHAR(100) NOT NULL,
                    Phone_Number VARCHAR(12) NOT NULL,
                    Skills TEXT,
                    Status ENUM('New', 'Current', 'Final') DEFAULT 'New'
                )";
            
                if ($conn->query($sql) !== TRUE) {
                    echo "<h1 class=\"failed\">Form Error</h1>";
                    foreach ($errors as $error) {
                        echo "<p>Error creating table. Please try again later.</p>";
                    }
                };
            }


            $sql = "INSERT INTO eoi (Job_Reference_Number, First_Name, Last_Name, Date_of_Birth, Gender, Street_Address, Suburb_Town, State, Postcode, Email_Address, Phone_Number, Skills, Status) VALUES ('$job_reference', '$first_name', '$last_name', '$dob', '$gender', '$address', '$suburb', '$state', '$postcode', '$email', '$phone', '$final_skills', 'New');";

            if ($conn->query($sql) === TRUE) {
                $eoi_number = $conn->insert_id;
                echo "<h1 class=\"success\">Congratulation</h1><p>Your unique EOI number is: <strong>$eoi_number</strong></p>";
            } else {
                echo "<h1 class=\"failed\">Form Error</h1>" + "<p>Error: " . $sql . "<br>" . $conn->error + "</p>";
            }


            $conn->close();
        } else {
            echo "<h1 class=\"failed\">Form Error</h1>";
            foreach ($errors as $error) {
                echo "<p>$error.<br></p>";
            }
        }
    } else {
        header("Location: apply.php");
        exit;
    }
    ?>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>