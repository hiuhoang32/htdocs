<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="recruit" content="recruit Talents" />
    <title>SwinCloud - Job Description</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <header id="header">
        <?php include 'navbar.inc'; ?>
        <a>
            <img width="1500" height="250" src="images/jobs/banner.jpg" alt="" title=" " /></a>
        <h1 class="recruit-talents">SwinCloud Recruit Talents</h1>
        <?php
            include('settings.php');
            $conn = new mysqli($host, $user, $password, $database);

            if ($conn->connect_error) {
                echo "<div class=\"congrats-container\">";
                echo "<h1 class=\"failed\">Database Error</h1>";
                echo "<p>There was an error trying to connect to the database. Please try again later.</p>";
                echo "</div>";
                die("Connection failed: " . $conn->connect_error);

            };
            $fetched_result = [];
            $job_table_result = $conn->query("SHOW TABLES LIKE 'jobs'");
            $job_table_exists = $job_table_result->num_rows > 0;
            if ($job_table_exists) {
                $sql = "SELECT * FROM jobs";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<nav class=\"jobs-list\">";
                    while($row = $result->fetch_assoc()) {
                        $fetched_result[] = $row; 
                        echo "<a " . "href=\"#" . $row["Job_Reference_Number"] . "\">";
                        echo $row["Job_Title"];
                        echo "</a>";
                    };
                    echo "</nav>";
                };
            };

        ?>
    </header>
    <?php
        if (count($fetched_result) > 0) {
            foreach ($fetched_result as $row) {
                $key_responsibilities_array = explode("@split", $row["Job_Key_Responsibilities"]);
                $required_qualifications_array = explode("@split", $row["Job_Required_Qualifications"]);
                $preferable_qualifications_array = explode("@split", $row["Job_Preferable_Qualifications"]);
                echo "<section class='job' id=\"" . $row["Job_Reference_Number"] . "\">";
                echo "<h2 id=\"" . $row["Job_Reference_Number"] . "\">". $row["Job_Title"]. " (Job Reference: ". $row["Job_Reference_Number"]. ")</h2>";
                echo "<p>". $row["Job_Description"]. "</p>";
                echo "<p>Position Reference Number:". $row["Job_Title"]. "</p>";
                echo "<p>Position Title:". $row["Job_Reference_Number"]. "</p>";
                echo "<p>Reports to:". $row["Job_Reports_To"]. "</p>";
                echo "<h3>Key Responsibilities:</h3><ul>";
                foreach ($key_responsibilities_array as $key_responsibility) {
                    echo "<li>". $key_responsibility. "</li>";
                }
                echo "</ul>";
                echo "<h3>Key Responsibilities:</h3><ul>";
                foreach ($key_responsibilities_array as $key_responsibility) {
                    echo "<li>". $key_responsibility. "</li>";
                }
                echo "</ul>";
                echo "<h3>Required Qualifications, Skills, Knowledge, and Attributes:</h3>";
                echo "<h4>Essential:</h4><ul>";
                foreach ($required_qualifications_array as $required_qualification) {
                    echo "<li>". $required_qualification. "</li>";
                }
                echo "</ul>";
                echo "<h4>Preferable:</h4><ul>";
                foreach ($preferable_qualifications_array as $preferable_qualification) {
                    echo "<li>". $preferable_qualification. "</li>";
                }
                echo "</ul>";
                echo "</section>";
                echo "<hr>";
            }
        } else {
            echo "<div class=\"congrats-container\">";
            echo "<h1 class=\"failed\">Job Empty</h1>";
            echo "<p>Currently there is no jobs for you to apply. Please check the <a href=\"jobs.php\">Jobs</a> page frequently</p>";
            echo "</div>";
        }
?>
    <p class="ending-words">
            If you are passionate about building scalable and reliable
            infrastructure using automation and want to be part of a
            collaborative team, we would love to hear from you! Please send
            your resume and cover letter to <a href="mailto:doduylong@gmail.com">doduylong@gmail.com</a>.
    </p>
    <?php include 'footer.inc'; ?>
</body>

</html>