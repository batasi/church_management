<?php
require_once('config.php');

// Check if the request parameter 'load_more' is set
if (isset($_GET['load_more']) && $_GET['load_more'] === 'true') {
    // Retrieve more videos from your database or any other source
    // Example: Fetch the next 20 videos from the database, starting from the 4th record (OFFSET 3)
    $qry_more_videos = $conn->query("SELECT * FROM `videos` ORDER BY date_created DESC LIMIT 16 OFFSET 3");

    // Check if there are any rows returned from the query
    if ($qry_more_videos->num_rows > 0) {
        while ($row = $qry_more_videos->fetch_assoc()) {
            // Output HTML code for each additional video
            $live_title = mb_substr($row['title'], 0, 25, 'UTF-8');
            echo '<div class="mr-3 mb-3">';
            echo '<iframe width="280" height="180" src="https://www.youtube.com/embed/'. $row["video_url"] .'" frameborder="0" allowfullscreen></iframe>';
            echo '<h6>'.$live_title.'...</h6>';
            echo '</div>';
        }
    } else {
        // If no more videos are found, you can output a message or leave it empty
        echo '<p>No more videos found.</p>';
    }
} else {
    // If 'load_more' parameter is not set or not equal to 'true', you can output a message or leave it empty
    echo '<p>No more videos requested.</p>';
}
?>
