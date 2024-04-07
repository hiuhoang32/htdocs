<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1060e2c82b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <title>SwinCloud - Manage Jobs</title>
</head>

<body>
    <?php include 'navbar.inc'; ?>
    <main class="managing">
        <form method="post" action="manage-jobs.php" class="manage-form" novalidate>
            <select name="action">
                <option value="list_all">List all jobs</option>
                <option value="add_job">Add a jobs</option>
                <option value="delete_job">Delete a jobs</option>
            </select>
            <input type="text" name="job_reference" placeholder="Job Reference Number">
            <input type="text" name="job_title" placeholder="Job Title">
            <br>
            <label for="job_description">Job Description:</label>
            <textarea id="job_description" name="job_description"></textarea>
            <input type="submit" value="Submit">
        </form>
        <?php
        function sanitise_input($input)
        {
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
        include('functions.php');
        $errors = [];
        $passed = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST['action'];

            switch ($action) {
                case 'list_all':
                    $sql = "SELECT * FROM jobs";
                    $passed = true;
                    break;
                case 'add_job':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    };
                    if (!isset($_POST['job_title']) || empty($_POST['job_title'])) {
                        $errors[] = "Please enter the job title";
                    } else {
                        $job_title = sanitise_input($_POST['job_title']);
                    };
                    if (!isset($_POST['job_description']) || empty($_POST['job_description'])) {
                        $errors[] = "Please enter the job description";
                    } else {
                        $job_description = sanitise_input($_POST['job_description']);
                    };
                    if (isset($job_reference) && isset($job_title) && isset($job_description)) {
                        $passed = true;
                    }
                    break;
                case 'delete_job':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    };
                    if (isset($job_reference)) {
                        $sql = "DELETE FROM jobs WHERE Job_Reference_Number = '$job_reference'";
                        $passed = true;
                    }
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
            $table_name = "jobs"; // Table name
            $table_result = $conn->query("SHOW TABLES LIKE '$table_name'");
            $table_exists = $table_result->num_rows > 0;

            if (!$table_exists) {
                $sql_create_table = "CREATE TABLE jobs (
                    Job_Reference_Number VARCHAR(3) NOT NULL,
                    Job_Title VARCHAR(255) NOT NULL,
                    Job_Description TEXT NOT NULL
                )";
            
                if ($conn->query($sql_create_table) !== TRUE) {
                    echo "<h1 class=\"failed\">There was an error when creating the table. Please try again later.</h1>";
                    echo "<p>$sql</p>";
                    return;
                };
            }
            if ($passed && $action == "add_job") {
                $stmt = $conn->prepare("INSERT INTO jobs (Job_Reference_Number, Job_Title, Job_Description) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $job_reference, $job_title, $job_description);
                
                $result = $stmt->execute();
            } else {
                $result = $conn->query($sql);
            };

            if ($conn->error) {
                echo "<h1 class=\"failed\">There was an error with the query. Please try again later.</h1>";
                echo "<p>$sql</p>";
            };
            if (isset($result)) {
                if ($action == 'add_job' || $action == 'delete_job') {
                    echo "<h1 class=\"success\">Query Successful</h1>";
                    echo "<p>Please select <strong>List all jobs</strong> to see changed table</p>";
                } else if ($result->num_rows > 0) {
                    echo "<table class=\"result-table\">";
                    $firstRow = $result->fetch_assoc();
                    echo "<tr>";
                    foreach ($firstRow as $field => $value) {
                        if ($field != 'Job_Description') {
                            echo "<th>" . htmlspecialchars($field) . "</th>";
                        }
                    }
                    echo "</tr>";
                    echo "<tr>";
                    foreach ($firstRow as $field => $value) {
                        if ($field != 'Job_Description') {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo "</tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $field => $value) {
                            if ($field != 'Job_Description') {
                                echo "<td>" . htmlspecialchars($value) . "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h1 class=\"failed\">Empty Result</h1>";
                    echo "<p>The result is empty. Please use another query.</p>";
                }
            } else {
                echo "<h1 class=\"failed\">Empty Result</h1>";
                echo "<p>The result is empty. Please use another query.</p>";
            };
            echo "</div>";
        };
        ?>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>