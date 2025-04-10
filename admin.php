<?php
session_start();

// Check if user is already logged in
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

// Handle login form submission
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            
            // Redirect to prevent form resubmission
            header("Location: admin.php");
            exit;
        } else {
            $loginError = "Invalid password";
        }
    } else {
        $loginError = "User not found";
    }
}

// Handle blog post form submission
$postSuccess = '';
$postError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post']) && $isAdmin) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO blog_posts (title, content, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $date);
    
    if ($stmt->execute()) {
        $postSuccess = "Blog post created successfully!";
    } else {
        $postError = "Error: " . $stmt->error;
    }
}

// Handle blog post deletion
if (isset($_GET['delete_post']) && $isAdmin) {
    $post_id = $_GET['delete_post'];
    
    $sql = "DELETE FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    
    if ($stmt->execute()) {
        $postSuccess = "Blog post deleted successfully!";
        // Redirect to prevent refresh issues
        header("Location: admin.php");
        exit;
    } else {
        $postError = "Error deleting post: " . $stmt->error;
    }
}

// Fetch blog posts if logged in
$posts = [];
if ($isAdmin) {
    $sql = "SELECT * FROM blog_posts ORDER BY date DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <div class="container">
            <div style="display: flex; justify-content: flex-end; padding: 1rem 0;">
                <a href="index.php" class="admin-btn">Back to Site</a>
                <?php if ($isAdmin): ?>
                    <a href="logout.php" class="admin-btn">Logout</a>
                <?php endif; ?>
                <div class="theme-toggle">
                    <button id="theme-toggle-btn">
                        <i id="sun-icon" class="fas fa-sun"></i>
                        <i id="moon-icon" class="fas fa-moon"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="container">
            <?php if (!$isAdmin): ?>
                <div class="admin-login-section">
                    <h2>Admin Login</h2>
                    <?php if ($loginError): ?>
                        <div class="error-message"><?php echo $loginError; ?></div>
                    <?php endif; ?>
                    <form method="post" class="admin-login-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" name="login" class="submit-button">Login</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="admin-dashboard">
                    <h2>Welcome, Noorjahan!</h2>
                    
                    <div class="admin-tabs">
                        <button class="tab-btn active" data-tab="posts">Blog Posts</button>
                        <button class="tab-btn" data-tab="add-post">Add New Post</button>
                    </div>
                    
                    <div id="posts" class="tab-content active">
                        <div class="admin-section">
                            <h3>Manage Blog Posts</h3>
                            <?php if ($postSuccess): ?>
                                <div class="success-message"><?php echo $postSuccess; ?></div>
                            <?php endif; ?>
                            <?php if ($postError): ?>
                                <div class="error-message"><?php echo $postError; ?></div>
                            <?php endif; ?>
                            
                            <div class="admin-table-container">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($posts) > 0): ?>
                                            <?php foreach ($posts as $post): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                                                    <td><?php echo date('F j, Y', strtotime($post['date'])); ?></td>
                                                    <td>
                                                        <a href="admin.php?delete_post=<?php echo $post['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">No blog posts found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div id="add-post" class="tab-content">
                        <div class="admin-section">
                            <h3>Add New Blog Post</h3>
                            <form method="post" class="admin-form">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea id="content" name="content" rows="10" required></textarea>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="submit_post" class="submit-button">Publish Post</button>
                                    <button type="reset" class="cancel-btn">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Theme toggle functionality
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            // Check for saved theme preference or use default
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
            } else {
                if (sunIcon) sunIcon.style.display = 'block';
                if (moonIcon) moonIcon.style.display = 'none';
            }
            
            // Toggle theme when button is clicked
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    document.body.classList.toggle('dark-theme');
                    
                    if (document.body.classList.contains('dark-theme')) {
                        if (sunIcon) sunIcon.style.display = 'none';
                        if (moonIcon) moonIcon.style.display = 'block';
                        localStorage.setItem('theme', 'dark');
                    } else {
                        if (sunIcon) sunIcon.style.display = 'block';
                        if (moonIcon) moonIcon.style.display = 'none';
                        localStorage.setItem('theme', 'light');
                    }
                });
            }
        });
    </script>
</body>
</html>

