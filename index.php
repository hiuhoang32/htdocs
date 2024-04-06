<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Borel&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1060e2c82b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <title>SwinCloud</title>
</head>

<body>
    <header id="header">
        <?php include 'navbar.inc'; ?>
        <div class="banner">
            <div class="welcome">
                <h1>Start something that matters.</h1>
                <p>Start working with cloud computing in SwinCloud.</p>
                <a href="jobs.php" class="button">Learn more and start today</a>
            </div>
        </div>
    </header>

    </header>
    <main>
        <article class="about">
            <h2>What we offer</h2>
            <section class="features">
                <div class="key-features"> <i class="fa fa-desktop"></i>
                    <p class="large">Responsive</p>
                    <p>Our cloud service are powered by NASA and actively monitored to deliver the best performance</p>
                </div>
                <div class="key-features">
                    <i class="fa fa-heart"></i>
                    <p class="large">Passion</p>
                    <p>We consider our job as a passion, and the working environment is healthy to everybody.</p>
                </div>
                <div class="key-features">
                    <i class="fa fa-cog"></i>
                    <p class="large">Support</p>
                    <p>We provide 24/7 cloud support to help our customers.</p>
                </div>
            </section>
        </article>
        <article class="generic service">
            <h2>Our <strong>service</strong></h2>
            <div class="service-list">
                <section>
                    <i class="fa fa-cubes"></i>
                    <h3 class="large">Cloud Computing</h3>
                    <p>We offer advanced cloud computing solutions tailored to your business needs. From infrastructure
                        as a service (IaaS) to platform as a service (PaaS), we've got you covered.</p>
                    <span><img alt="Cloud Computing Image" src="images/index/cloud-computing.jpeg"></span>
                </section>
                <section>
                    <i class="fa fa-shield"></i>
                    <h3 class="large">Data Security</h3>
                    <p>Your data security is our top priority. With state-of-the-art encryption and security protocols,
                        you can trust us to keep your data safe and secure.</p>
                    <span><img alt="Data Security Image" src="images/index/security.webp"></span>
                </section>
                <section>
                    <i class="fa fa-sitemap"></i>
                    <h3 class="large">Scalability</h3>
                    <p>Scale your infrastructure seamlessly with our cloud solutions. Whether you're a startup or an
                        enterprise, we provide scalable solutions to meet your growing demands.</p>
                    <span><img alt="Scalability Image" src="images/index/scalability.jpg"></span>
                </section>
            </div>

        </article>

        <article class="generic testimonials">
            <h2>What Our Customers Say</h2>
            <section class="testimonial-list">
                <div class="testimonial">
                    <blockquote>
                        "SwinCloud's cloud computing services have transformed our business. We've experienced
                        significant cost savings and improved efficiency since switching to their platform."
                    </blockquote>
                    <cite>- John Smith, CEO of ABC Company</cite>
                </div>
                <div class="testimonial">
                    <blockquote>
                        "The level of support provided by SwinCloud is unmatched. Their team is responsive,
                        knowledgeable, and always goes above and beyond to resolve any issues we encounter."
                    </blockquote>
                    <cite>- Sarah Johnson, CTO of XYZ Inc.</cite>
                </div>
            </section>
        </article>
    </main>
    <?php include 'footer.inc'; ?>
</body>

</html>