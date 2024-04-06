<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Group Information</title>
        <link rel="stylesheet" href="styles/styles.css" />
    </head>
    <body>
    <header id="header">
        <?php include 'navbar.inc'; ?>
    </header>
        <main class="about-us">
            <h1>About us</h1>

            <h2>Group Details:</h2>
            <dl>
                <dt>Group Name:</dt>
                <dd>Outsiders</dd>
    
                <dt>Group ID:</dt>
                <dd>COS10026.1 - G9</dd>
    
                <dt>Tutor's Name:</dt>
                <dd>Dennis Nguyen</dd>
    
                <dt>Course ID:</dt>
                <dd>COS10026</dd>
            </dl>
    
            <figure>
                <img src="images/about/group.jpg" alt="Group Photo" />
                <figcaption>Group Photo</figcaption>
            </figure>
    
            <div class="person-info">
                <div class="person">
                    <img src="images/about/hieu.jpg" alt="Person 1 Photo" />
                    <h3>Hoang The Hieu</h3>
                    <p><strong>Hometown:</strong> Hanoi</p>
                    <p>
                        <strong>Favourite Books:</strong> White Noise, American
                        Psycho
                    </p>
                    <p><strong>Favourite Films:</strong> The Mask of Zorro, Ted</p>
                    <p><strong>Favourite Music Artists:</strong> Drake, Lil Pump</p>
                </div>
    
                <div class="person">
                    <img src="images/about/long.jpg" alt="Person 2 Photo" />
                    <h3>Do Duy Long</h3>
                    <p><strong>Hometown:</strong> Hanoi</p>
                    <p>
                        <strong>Favourite Books:</strong> Americanah, A Little Life
                    </p>
                    <p>
                        <strong>Favourite Films:</strong> Badland Hunters, Deep Trap
                    </p>
                    <p>
                        <strong>Favourite Music Artists:</strong> Lil Nas X, Binh
                        Gold
                    </p>
                </div>
    
                <div class="person">
                    <img src="images/about/vanh.jpg" alt="Person 3 Photo" />
                    <h3>Nguyen Tu Viet Anh</h3>
                    <p><strong>Hometown:</strong> Hanoi</p>
                    <p>
                        <strong>Favourite Books:</strong> Les Misérables, Better
                        Call Saul
                    </p>
                    <p>
                        <strong>Favourite Films:</strong> Reunited Worlds, Taxi
                        Driver
                    </p>
                    <p>
                        <strong>Favourite Music Artists:</strong> Thai Hoang,
                        Phillip Lee
                    </p>
                </div>
            </div>
    
            <h2>Timetable:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Add timetable data here -->
                    <tr>
                        <td>Study</td>
                        <td>Study</td>
                        <td>Study</td>
                        <td>Study</td>
                        <td>Study</td>
                        <td>Study</td>
                        <td>Relaxing</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
    
            <p>
                Contact us via email:
                <a href="mailto:doduylong0302@gmail.com">doduylong0302@gmail.com</a>
            </p>
        </main>
        <?php include 'footer.inc'; ?>
    </body>
</html>
