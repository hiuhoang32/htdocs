<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1060e2c82b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <title>SwinCloud - Managing</title>
</head>

<body>
    <?php include 'navbar.inc'; ?>
    <?php
        function sanitise_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
    ?>
    <main class="managing">
        <form method="post" action="manage.php" class="manage-form">
            <select name="action">
                <option value="list_all">List all EOIs</option>
                <option value="list_by_position">List EOIs by position</option>
                <option value="list_by_applicant">List EOIs by applicant</option>
                <option value="delete_by_position">Delete EOIs by position</option>
                <option value="change_status">Change EOI status</option>
            </select>
            <input type="text" name="job_reference" placeholder="Job Reference Number">
            <input type="text" name="first_name" placeholder="First Name">
            <input type="text" name="last_name" placeholder="Last Name">
            <input type="text" name="eoi_number" placeholder="EOI Number">
            <select name="status">
                <option value="New">New</option>
                <option value="Current">Current</option>
                <option value="Final">Final</option>
            </select>
            <input type="submit" value="Submit">
        </form>
        <?php
        include('functions.php');
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST['action'];

            switch ($action) {
                case 'list_all':
                    $sql = "SELECT * FROM eoi";
                    break;
                case 'list_by_position':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    };
                    if (isset($job_reference)) {
                        $sql = "SELECT * FROM eoi WHERE Job_Reference_Number = '$job_reference'";
                    }
                    break;
                case 'list_by_applicant':
                    if (!isset($_POST['first_name']) || empty($_POST['first_name'])) {
                        $errors[] = "Please enter the first name";
                    } else {
                        $first_name = sanitise_input($_POST['first_name']);
                    }
                    if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
                        $errors[] = "Please enter the last name";
                    } else {
                        $first_name = sanitise_input($_POST['last_name']);
                    }
                    if (isset($first_name) && isset($last_name)) {
                        $sql = "SELECT * FROM eoi WHERE First_Name = '$first_name' AND Last_Name = '$last_name'";
                    }
                    break;
                case 'delete_by_position':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference that you want to delete such as SD1";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference that you want to delete such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    };
                    if (isset($job_reference)) {
                        $sql = "DELETE FROM eoi WHERE Job_Reference_Number = '$job_reference'";
                    }
                    break;
                case 'change_status':
                    if (!isset($_POST['eoi_number']) || empty($_POST['eoi_number'])) {
                        $errors[] = "Please enter the EOI number that you want to change state of";
                    } else {
                        $eoi_number = sanitise_input($_POST['eoi_number']);
                    }
                    if (!isset($_POST['status']) || empty($_POST['status'])) {
                        $errors[] = "Please select the status that you want to change to";
                    } else {
                        $status = sanitise_input($_POST['status']);
                    }
                    if (isset($eoi_number) && isset($status)) {
                        $sql = "UPDATE eoi SET Status = '$status' WHERE EOInumber = '$eoi_number'";
                    };
                    break;
            }
        }
        echo "<div class=\"congrats-container\">";
        if (!empty($errors)) {
            echo "<h1 class=\"failed\">Form Error</h1>";
            foreach ($errors as $error) {
                echo "<p>$error.<br></p>";
            }
        } else if (isset($sql) && !empty($sql)) {

            $conn = connectMySQL();
            $eoi_table_result = $conn->query("SHOW TABLES LIKE 'eoi'");
            $eoi_table_exists = $eoi_table_result->num_rows > 0;

            if (!$eoi_table_exists) {
                $eoi_create_table = "CREATE TABLE eoi (
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
            
                if ($conn->query($eoi_create_table) !== TRUE) {
                    echo "<h1 class=\"failed\">There was an error when creating the table. Please try again later.</h1>";
                    echo "<p>$sql</p>";
                    return;
                };
            };
            $result = $conn->query($sql);
            if ($conn->error) {
                echo "<h1 class=\"failed\">There was an error with the query. Please try again later.</h1>";
                echo "<p>$sql</p>";
            };
            if (isset($result)) {
                if ($action == 'delete_by_position' || $action == 'change_status') {
                    echo "<h1 class=\"success\">Query Successful</h1>";
                    echo "<p>Please select <strong>List all EOI</strong> to see changed table</p>";
                } else if ($result->num_rows > 0) {
                    echo "<table class=\"result-table\">";
                    $firstRow = $result->fetch_assoc();
                    echo "<tr>";
                    foreach ($firstRow as $field => $value) {
                        echo "<th>" . htmlspecialchars($field) . "</th>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    foreach ($firstRow as $field => $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $field => $value) {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h1 class=\"failed\">Empty Result</h1>";
                    echo "<p>The result is empty. Please use another query.</p>";
                }
            };
            echo "</div>";
        };
        ?>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>