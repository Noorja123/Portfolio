<?php
session_start();
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

// Database connection
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "portfolioN";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blog posts
$sql = "SELECT * FROM blog_posts ORDER BY date DESC";
$result = $conn->query($sql);
$blogPosts = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $blogPosts[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noorjahan Charania - Web Developer</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <div class="theme-toggle">
        <button id="theme-toggle-btn" aria-label="Toggle theme">
            <i class="fas fa-sun" id="sun-icon"></i>
            <i class="fas fa-moon" id="moon-icon"></i>
        </button>
        <!-- Admin Login Button -->
        <?php if ($isAdmin): ?>
            <a href="admin.php" class="admin-btn">Admin Dashboard</a>
            <a href="logout.php" class="admin-btn">Logout</a>
        <?php else: ?>
            <a href="admin.php" class="admin-btn">Admin Login</a>
        <?php endif; ?>
        
    </div>

    <!-- Floating Navigation -->
    <div class="floating-nav">
        <div class="nav-dots">
            <button class="nav-dot active" data-section="hero" aria-label="Scroll to Home" data-target="hero">
                <span class="tooltip">Home</span>
            </button>
            <button class="nav-dot" data-section="about" aria-label="Scroll to About" data-target="about">
                <span class="tooltip">About</span>
            </button>
            <button class="nav-dot" data-section="experience" aria-label="Scroll to Experience" data-target="experience">
                <span class="tooltip">Experience</span>
            </button>
            <button class="nav-dot" data-section="skills" aria-label="Scroll to Skills" data-target="skills">
                <span class="tooltip">Skills</span>
            </button>
            <button class="nav-dot" data-section="education" aria-label="Scroll to Education" data-target="education">
                <span class="tooltip">Education</span>
            </button>
            <button class="nav-dot" data-section="blog" aria-label="Scroll to Blog" data-target="blog">
                <span class="tooltip">Blog</span>
            </button>
            <button class="nav-dot" data-section="contact" aria-label="Scroll to Contact" data-target="contact">
                <span class="tooltip">Contact</span>
            </button>
        </div>
    </div>

    <main>
        <!-- Hero Section -->
        <section id="hero" class="section">
            <div class="code-pattern"></div>
            <div class="animated-gradient"></div>
            
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text fade-in">
                        <h1 class="gradient-text">Noorjahan Charania</h1>
                        <h2>Web Developer</h2>
                        <p>Crafting exceptional digital experiences with modern web technologies. Specialized in building scalable full-stack applications using Angular,RxJS,MySQL, React, and Node.js.</p>
                        <div class="social-links">
                            <a href="https://github.com/Noorja123" aria-label="GitHub Profile">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/noorjahan-charania-95bb8631a" aria-label="LinkedIn Profile">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="mailto:noorjahan@example.com" aria-label="Email Contact">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                        <button class="cta-button" onclick="document.getElementById('about').scrollIntoView({behavior: 'smooth'})">
                            Learn More
                            <i class="fas fa-arrow-down"></i>
                        </button>
                    </div>
                    <div class="hero-image fade-in">
                        <div class="image-container">
                            <div class="image-bg-1"></div>
                            <div class="image-bg-2"></div>
                            <div class="profile-image">
                                <img src="portfolioimg.JPG" alt="noor-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="scroll-indicator">
                <div class="scroll-line"></div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="section">
            <div class="container">
                <h2 class="section-title">About Me</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>As a passionate Web Developer, I specialize in building robust and scalable web applications. With a strong foundation in Angular,MySQL, React, and Node.js, I create seamless full-stack solutions that deliver exceptional user experiences.</p>
                        <p>My expertise extends to modern frameworks like Angular. I'm committed to writing clean, efficient code and staying up-to-date with the latest industry trends to deliver cutting-edge solutions for my clients.</p>
                    </div>
                    <div class="skills-grid">
                        <div class="skill-card">
                            <i class="fas fa-code"></i>
                            <h3>Frontend</h3>
                            <p>Angular,React, Next.js</p>
                        </div>
                        <div class="skill-card">
                            <i class="fas fa-server"></i>
                            <h3>Backend</h3>
                            <p>Python,Java,PHP,C,C++</p>
                        </div>
                        <div class="skill-card">
                            <i class="fas fa-database"></i>
                            <h3>Database</h3>
                            <p>SQl,MySQL</p>
                        </div>
                        <div class="skill-card">
                            <i class="fas fa-bolt"></i>
                            <h3>Performance</h3>
                            <p>Optimization, Caching</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience Section -->
        <section id="experience" class="section">
            <div class="container">
                <h2 class="section-title">Professional Experience</h2>
                <div class="timeline">
                    <div class="experience-card">
                        <div class="experience-header">
                            <h3>EruTech Solutions Pvt. Ltd</h3>
                            <div class="experience-meta">
                                <p><i class="fas fa-map-marker-alt"></i>Marol,Andheri(E)</p>
                                <p><i class="fas fa-calendar"></i>Present</p>
                            </div>
                            <p class="experience-role"><i class="fas fa-briefcase"></i> Intern as an Angular Developer</p>
                        </div>
                        <ul class="experience-list">
                            <li>Developing custom web applications for clients</li>
                            <li>Building responsive and scalable frontend interfaces with Angular</li>
                            <li>Implementing secure backend systems with Node.js </li>
                            <li>Collaborating with clients to deliver high-quality solutions</li>
                        </ul>
                    </div>

                    <!-- Project -->
                    <h2 class="section-title">Projects</h2>
                    <div class="timeline">
                         <div class="experience-card">
                        <div class="experience-header">
                            <h3>Ecommerce Store</h3>
                            <div class="experience-meta">
                                <!-- <p><i class="fas fa-map-marker-alt"></i> </p> -->
                                <!-- <p><i class="fas fa-calendar"></i></p> -->
                            </div>
                            <p class="experience-role"><i class="fas fa-code"></i>Angular </p>
                        </div>
                        <ul class="experience-list">
                            <li>A clear and intuitive navigation system allows customers to easily find what they're looking for.</li>
                            <li>Ensuring the website functions seamlessly on all devices, especially mobile.</li>
                            <li>Shopping cart and checkout buttons</li>
                            <!-- <li></li> -->
                            <!-- <li></li> -->
                        </ul>
                    </div>

                    <div class="experience-card">
                        <div class="experience-header">
                            <h3>To-do List</h3>
                            <div class="experience-meta">
                                <!-- <p><i class="fas fa-map-marker-alt"></i> Lahore, Pakistan</p> -->
                                <!-- <p><i class="fas fa-calendar"></i> 2022 - 2024</p> -->
                            </div>
                            <p class="experience-role"><i class="fas fa-code"></i>Angular</p>
                        </div>
                        <ul class="experience-list">
                            <li>Task Creation & Editing</li>
                            <li>Task Deletion</li>
                            <li>Task Completion</li>
                            <li>Due Dates & Reminders</li>
                            <li>Categorization/Tags</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="section">
            <div class="container">
                <h2 class="section-title">Skills & Expertise</h2>
                <div class="skills-container">
                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="skill-info">
                            <h3>Frontend Development</h3>
                            <p class="skill-tech">Angular,React.js, Next.js</p>
                            <p class="skill-desc">Building responsive and interactive user interfaces with modern React features RxJS,and Next.js for optimal performance.</p>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="skill-info">
                            <h3>Backend Development</h3>
                            <p class="skill-tech">Node.js</p>
                            <p class="skill-desc">Creating robust server-side applications with focus on scalability and clean architecture.</p>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="skill-info">
                            <h3>Database Management</h3>
                            <p class="skill-tech">MySQL</p>
                            <p class="skill-desc">Designing and implementing efficient database schemas and queries for optimal data management.</p>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="skill-info">
                            <h3>UI/UX Design</h3>
                            <p class="skill-tech">Tailwind CSS, Material UI</p>
                            <p class="skill-desc">Crafting beautiful and intuitive user interfaces with modern design principles and frameworks.</p>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-code-branch"></i>
                        </div>
                        <div class="skill-info">
                            <h3>Version Control</h3>
                            <p class="skill-tech">Git, GitHub</p>
                            <p class="skill-desc">Managing code versions efficiently with Git and collaborating effectively through GitHub.</p>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="skill-icon">
                            <i class="fas fa-terminal"></i>
                        </div>
                        <div class="skill-info">
                            <h3>TypeScript</h3>
                            <p class="skill-tech">TypeScript, JavaScript</p>
                            <p class="skill-desc">Writing type-safe code for better maintainability and developer experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education Section -->
        <section id="education" class="section">
            <div class="container">
                <h2 class="section-title">Education</h2>
                <div class="education-card">
                    <div class="education-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="education-content">
                        <h3>Bachelor's Degree in Information Technology</h3>
                        <p class="education-institution">Chetana's H.S College (Mumbai University)</p>
                        <p class="education-period"><i class="fas fa-calendar"></i> 2023 – 2026</p>
                        <h4><i class="fas fa-award"></i> Key Achievements:</h4>
                        <ul class="education-achievements">
                            <li>Specialized in Web Technologies and Artificial Intelligence</li>
                            <li>Completed capstone project on 'Intelligent Web Application for Healthcare'</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section id="blog" class="section">
            <div class="container">
                <h2 class="section-title">Blog</h2>
                <div class="blog-container">
                    <?php if (empty($blogPosts)): ?>
                        <div class="no-posts">
                            <p>No blog posts available yet. Check back soon!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($blogPosts as $post): ?>
                            <div class="blog-card">
                                <div class="blog-content">
                                    <div class="blog-date">
                                        <span class="day"><?php echo date("d", strtotime($post['date'])); ?></span>
                                        <span class="month"><?php echo date("M", strtotime($post['date'])); ?></span>
                                    </div>
                                    <h3 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                    <p class="blog-excerpt"><?php echo htmlspecialchars(substr($post['content'], 0, 150) . '...'); ?></p>
                                    <button class="read-more" data-id="<?php echo $post['id']; ?>">Read More</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Blog Post Modal -->
                <div id="blogModal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <div id="modalContent"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section">
            <div class="container">
                <h2 class="section-title">Get in Touch</h2>
                <div class="contact-container">
                    <div class="contact-info">
                        <h3>Contact Information</h3>
                        <div class="contact-details">
                            <a href="mailto:noorjahan@example.com" class="contact-item">
                                <i class="fas fa-envelope"></i>
                                noorjahan@example.com
                            </a>
                            <a href="tel:+917875602156" class="contact-item">
                                <i class="fas fa-phone"></i>
                                +91-7875602156
                            </a>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                Andheri,Mumbai 
                            </div>
                        </div>
                    </div>
                    <div class="contact-form-container">
                        <form id="contact-form" class="contact-form" action="process_contact.php" method="POST">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" required>
                                    <span class="error-message" id="name-error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" required>
                                    <span class="error-message" id="email-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" required>
                                <span class="error-message" id="subject-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" rows="4" required></textarea>
                                <span class="error-message" id="message-error"></span>
                            </div>
                            <button type="submit" class="submit-button">
                                <i class="fas fa-paper-plane"></i>
                                Send Message
                            </button>
                            <div id="form-success" class="form-success">Message sent successfully!</div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>