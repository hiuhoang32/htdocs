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
    <main class="form">
        <h2>Job Application Form</h2>
        <form action="processEOI.php" method="post" novalidate>
            <label for="job_reference">Job Reference:</label>
            <input type="text" id="job_reference" name="job_reference" pattern="[A-Z]{2}\d" required
                title="Please enter correct job reference such as SD1">

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="20" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="20" required>

            <label for="dob">Date of Birth:</label>
            <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" pattern="\d{1,2}/\d{1,2}/\d{4}" required>

            <fieldset>
                <legend>Gender:</legend>
                <label><input type="radio" name="gender" value="Male"> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
                <label><input type="radio" name="gender" value="Other"> Other</label>
            </fieldset>

            <label for="address">Street Address:</label>
            <input type="text" id="address" name="address" maxlength="40" required>

            <label for="suburb">Suburb/Town:</label>
            <input type="text" id="suburb" name="suburb" maxlength="40" required>

            <label for="state">State:</label>
            <select id="state" name="state" required>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="NT">NT</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
            </select>

            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" pattern="[0-9]{4}" required title="Enter 4 digits" />

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9 ]{8,12}" required>

            <label for="skills">Skills:</label>
            <input type="checkbox" id="skills" name="skills[]" value="skill1"> Skill 1
            <input type="checkbox" name="skills[]" value="skill2"> Skill 2
            <input type="checkbox" name="skills[]" value="skill3"> Skill 3
            <input type="checkbox" name="skills[]" value="skill4"> Skill 4
            <input type="checkbox" name="skills[]" value="other"> Other skills...
            <br>
            <label for="other_skills">Other Skills:</label>
            <textarea id="other_skills" name="other_skills"></textarea>
            <div class="button-form">
                <input type="submit" value="Apply">
                <input type="reset" value="Reset">
            </div>

        </form>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>