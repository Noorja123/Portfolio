<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "portfolioN";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        
        $response = [
            'title' => htmlspecialchars($post['title']),
            'content' => nl2br(htmlspecialchars($post['content'])),
            'date' => date("F j, Y", strtotime($post['date']))
        ];
        
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Post not found']);
    }
} else {
    echo json_encode(['error' => 'No post ID provided']);
}

$conn->close();
?>

