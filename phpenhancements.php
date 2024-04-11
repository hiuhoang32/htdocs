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
        <form method="post" action="phpenhancements.php" class="manage-form" novalidate>
            <select name="action">
                <option value="list_all">List all jobs</option>
                <option value="add_job">Add a jobs</option>
                <option value="delete_job">Delete a jobs</option>
            </select>
            <input type="text" name="job_reference" placeholder="Job Reference Number">
            <input type="text" name="job_title" placeholder="Job Title">
            <br>
            <label for="job_description">Job Description:</label><br>
            <textarea type="text" id="job_description" name="job_description"></textarea>
            <br>
            <label for="salary_range">Salary Range:</label><br>
            <input type="text" id="salary_range" name="salary_range"><br><br>
            <br>
            <label for="reports_to">Reports To:</label><br>
            <input type="text" id="reports_to" name="reports_to"><br><br>
            <br>
            <label for="key_responsibilities">Key Responsibilities:</label><br>
            <textarea id="key_responsibilities" name="key_responsibilities" placeholder="Enter a new line to list"></textarea><br><br>
            <br>
            <label for="required_qualifications">Required Qualifications:</label><br>
            <textarea id="required_qualifications" name="required_qualifications" placeholder="Enter a new line to list"></textarea><br>
            <br>
            <label for="preferable_qualifications">Preferable Qualities:</label><br>
            <textarea type="text" id="preferable_qualities" name="preferable_qualities" placeholder="Enter a new line to list"></textarea><br>
            <input type="submit" value="Submit">
        </form>
        <?php
        include('settings.php');
        function sanitise_input($input)
        {
            $input = trim($input);
            $input = addslashes($input);
            $input = addcslashes($input, "'");
            $input = addcslashes($input, '"');
            $input = htmlspecialchars($input);
            return $input;
        }
        $errors = [];
        $passed = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $action = $_POST['action'];

            switch ($action) {
                case 'list_all':
                    $sql = "SELECT * FROM jobs";
                    break;
                case 'add_job':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    }
                    ;
                    if (!isset($_POST['job_title']) || empty($_POST['job_title'])) {
                        $errors[] = "Please enter the job title";
                    } else {
                        $job_title = sanitise_input($_POST['job_title']);
                    }
                    ;
                    if (!isset($_POST['job_description']) || empty($_POST['job_description'])) {
                        $errors[] = "Please enter the job description";
                    } else {
                        $job_description = sanitise_input($_POST['job_description']);
                    }
                
                    if (!isset($_POST['salary_range']) || empty($_POST['salary_range'])) {
                        $errors[] = "Please enter the salary range";
                    } else {
                        $salary_range = sanitise_input($_POST['salary_range']);
                    }
                
                    if (!isset($_POST['reports_to']) || empty($_POST['reports_to'])) {
                        $errors[] = "Please enter the 'Reports To' field";
                    } else {
                        $reports_to = sanitise_input($_POST['reports_to']);
                    }
                
                    if (!isset($_POST['key_responsibilities']) || empty($_POST['key_responsibilities'])) {
                        $errors[] = "Please enter the key responsibilities";
                    } else {
                        $key_responsibilities = sanitise_input($_POST['key_responsibilities']);
                        $key_responsibilities = preg_replace("/[\r\n]+/", "@split", $key_responsibilities);
                    }
                
                    if (!isset($_POST['required_qualifications']) || empty($_POST['required_qualifications'])) {
                        $errors[] = "Please enter the required qualifications";
                    } else {
                        $required_qualifications = sanitise_input($_POST['required_qualifications']);
                        $required_qualifications = preg_replace("/[\r\n]+/", "@split", $required_qualifications);
                    }
                
                    if (!isset($_POST['preferable_qualities']) || empty($_POST['preferable_qualities'])) {
                        $errors[] = "Please enter the preferable qualities";
                    } else {
                        $preferable_qualities = sanitise_input($_POST['preferable_qualities']);
                        $preferable_qualities = preg_replace("/[\r\n]+/", "@split", $preferable_qualities);
                    }
                    if (isset($job_reference) && isset($job_title) && isset($job_description) && isset($salary_range) && isset($reports_to) && isset($key_responsibilities) && isset($required_qualifications) && isset($preferable_qualities)) {
                        $sql = "INSERT INTO jobs (Job_Reference_Number, Job_Title, Job_Description, Job_Salary_Range, Job_Reports_To, Job_Key_Responsibilities, Job_Required_Qualifications, Job_Preferable_Qualifications) VALUES ('$job_reference', '$job_title', '$job_description', '$salary_range', '$reports_to', '$key_responsibilities', '$required_qualifications', '$preferable_qualities')";
                    }
                    break;
                case 'delete_job':
                    if (!isset($_POST['job_reference']) || empty($_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference";
                    } else if (!preg_match("/[A-Z]{2}\d/", $_POST['job_reference'])) {
                        $errors[] = "Please enter the job reference such as SD1";
                    } else {
                        $job_reference = sanitise_input($_POST['job_reference']);
                    }
                    ;
                    if (isset($job_reference)) {
                        $sql = "DELETE FROM jobs WHERE Job_Reference_Number = '$job_reference'";
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

            $conn = new mysqli($host, $user, $password, $database);

            if ($conn->connect_error) {
                echo "<h1 class=\"failed\">Database Error</h1>";
                echo "<p>There was an error trying to connect to the database. Please try again later.</p>";
                die("Connection failed: " . $conn->connect_error);
            };
            $table_name = "jobs";
            $table_result = $conn->query("SHOW TABLES LIKE '$table_name'");
            $table_exists = $table_result->num_rows > 0;

            if (!$table_exists) {
                $sql_create_table = "CREATE TABLE jobs (
                    Job_Reference_Number VARCHAR(3) NOT NULL,
                    Job_Title VARCHAR(255) NOT NULL,
                    Job_Description TEXT NOT NULL,
                    Job_Salary_Range VARCHAR(50),
                    Job_Reports_To VARCHAR(255),
                    Job_Key_Responsibilities TEXT,
                    Job_Required_Qualifications TEXT,
                    Job_Preferable_Qualifications TEXT
                )";

                if ($conn->query($sql_create_table) !== TRUE) {
                    echo "<h1 class=\"failed\">There was an error when creating the table. Please try again later.</h1>";
                    echo "<p>$sql</p>";
                    return;
                }
                ;
            }
            $result = $conn->query($sql);

            if ($conn->error) {
                echo "<h1 class=\"failed\">There was an error with the query. Please try again later.</h1>";
                echo "<p>$sql</p>";
            }
            ;
            if (isset($result) || empty($result)) {
                if ($action == 'add_job' || $action == 'delete_job') {
                    echo "<h1 class=\"success\">Query Successful</h1>";
                    echo "<p>Please select <strong>List all jobs</strong> to see changed table</p>";
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
                        echo "<td>" . str_replace("@split", "<br>", htmlspecialchars($value)) . "</td>";
                    }
                    echo "</tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $field => $value) {
                            echo "<td>" . str_replace("@split", "<br>", htmlspecialchars($value)) . "</td>";
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
            }
            ;
            echo "</div>";
        }
        ;
        ?>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>