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
            include('functions.php');
            $conn = connectMySQL();
            $sql = "SELECT * FROM jobs";
            $result = $conn->query($sql);
            $fetched_result = [];
            
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
        ?>
    </header>
    <?php
        if (count($fetched_result) > 0) {
            foreach ($fetched_result as $row) {
                echo "<section class='job' id=\"" . $row["Job_Reference_Number"] . "\">";
                echo "h2 id=\"" . $row["Job_Reference_Number"] . ">". $row["Job_Title"]. " (Job Reference: ". $row["Job_Reference_Number"]. ")</h2>";
                echo $row["Job_Description"];
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
    <!-- <section class="job">
        <aside>

        </aside>
        <h2 id="devopsengineer">DevOps Engineer (Job Reference: DE1)</h2>
        <p>
            We are looking for a talented DevOps Engineer to join our IT
            team. The ideal candidate will have a strong background in
            software development, system administration, and automation,
            with a focus on improving efficiency and collaboration between
            development and operations teams.
        </p>
        <p>Position Reference Number: DO345</p>
        <p>Position Title: DevOps Engineer</p>
        <p>Salary Range: $80,000 - $100,000</p>
        <p>Reports to: Head of IT Operations</p>

        <h3>Key Responsibilities:</h3>
        <ul>
            <li>
                Design and implement continuous integration and continuous
                deployment (CI/CD) pipelines
            </li>
            <li>
                Automate infrastructure provisioning, configuration, and
                deployment using tools like Terraform, Ansible, or Chef
            </li>
            <li>
                Monitor and optimize system performance, reliability, and
                scalability
            </li>
            <li>
                Collaborate with development teams to streamline the
                software development lifecycle
            </li>
            <li>
                Implement and maintain monitoring, logging, and alerting
                solutions
            </li>
            <li>
                Troubleshoot and resolve issues in production environments
            </li>
            <li>
                Ensure compliance with security and regulatory requirements
            </li>
            <li>
                Stay up-to-date with industry best practices and emerging
                technologies
            </li>
        </ul>

        <h3>Required Qualifications, Skills, Knowledge, and Attributes:</h3>
        <h4>Essential:</h4>
        <ul>
            <li>
                Bachelor's degree in Computer Science, Engineering, or
                related field
            </li>
            <li>
                Proven experience as a DevOps Engineer or similar role, with
                at least 3 years of experience
            </li>
            <li>
                Strong proficiency in scripting and automation using
                languages like Python, Shell, or PowerShell
            </li>
            <li>
                Experience with cloud platforms such as AWS, Azure, or
                Google Cloud
            </li>
            <li>
                Proficiency with containerization technologies like Docker
                and container orchestration tools like Kubernetes
            </li>
            <li>
                Solid understanding of networking, security, and system
                administration concepts
            </li>
        </ul>
        <h4>Preferable:</h4>
        <ul>
            <li>Experience with agile methodologies</li>
            <li style>
                Knowledge of configuration management tools like Puppet or
                Chef
            </li>
            <li>
                Experience with monitoring and logging tools like
                Prometheus, ELK stack, or Splunk
            </li>
        </ul>


    </section> -->
    <p class="ending-words">
            If you are passionate about building scalable and reliable
            infrastructure using automation and want to be part of a
            collaborative team, we would love to hear from you! Please send
            your resume and cover letter to <a href="mailto:doduylong@gmail.com">doduylong@gmail.com</a>.
    </p>
    <?php include 'footer.inc'; ?>
</body>

</html>