<?php 
$qry = $conn->query("SELECT * FROM `daily_verses` where `display_date` = '".date('Y-m-d')."' ");
if($qry->num_rows>0){
    foreach($qry->fetch_array() as $k => $v){
        if(!is_numeric($k))
            $dv[$k] = $v;
    }
}

?>

<style>
    #main-header:before{
        background-image:url("<?php echo validate_image((isset($dv['image_path']) && !empty($dv['image_path']))? $dv['image_path'] : $_settings->info('cover')) ?>");
    }
    #main-header {
        height: 83vh;
        font-family: Brush Script MT, Brush Script Std, cursive;
        text-shadow: 5px 5px #9e73734d;
    }
</style>
<!-- Header-->
 <header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5 w-100">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo isset($dv['verse']) ? '"'.$dv['verse'].'"' : $_settings->info('home_quote') ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo isset($dv['verse_from']) ? $dv['verse_from'] : "" ?></p>
        </div>
    </div>
</header>
<!-- Section-->
<style>
   
</style>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
       <div class="col-12">
           <div class="row">
               <div class="col-md-8">
                   <h2><b>Welcome to <?php echo $_settings->info('name') ?></b></h2>
                   <hr>
                   <?php include('welcome_content.html') ?>
               </div>
               <div class="col-md-4 border-left">
                   <h4><b>Recent Blogs</b></h4>
                   <hr>
                   <?php 
                    $qry_blogs =$conn->query("SELECT * FROM `blogs` where `status` = 1 order by unix_timestamp(`date_created`) desc Limit 10");
                    while($row = $qry_blogs->fetch_assoc()):
                   ?>
                   <a href="<?php echo base_url.$row['blog_url'] ?>" class="w-100 d-flex pl-0 row-cols-2 text-decoration-none bg-light bg-gradient rounded-1 border-light border recent-item mb-1">
                       <div class="col-auto w-25 ml-0 p-0">
                           <img src="<?php echo validate_image($row['banner_path']) ?>" alt="Title" class="img-thumbnail recent-blog-img border-0 rounded-0  ml-0">
                       </div>
                       <div class="col-auto flex-grow-1 w-75">
                           <p class="truncate-1 m-0 "><b><?php echo $row['title'] ?></b></p>
                           <small class="truncate-1"><?php echo $row['meta_description'] ?></small>
                       </div>
                   </a>
                   <?php
                   endwhile;
                    ?>
                    <?php if($qry_blogs->num_rows <=0): ?>
                        <center><small><i>No data listed yet.</i></small></center>
                    <?php endif; ?>
               </div>
           </div>
       </div>
    </div>
</section>
<hr>
<!-- <?php
    $API_key = 'AIzaSyC2DO4xkI5XO7LKWWxDqXneCJ7MvP8L8Hp';
    $channelID = 'UC2GiTzYiq67dIioduTtO8QA';
    $maxResults = 20;

    $apiError = 'video not found!';
    try{
        $apidata = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelID.'&eventType=completed&type=video&maxResults='.$maxResults.'&key='.$API_key.'');
        if($apidata){
            $videoList = json_decode($apidata);

        }
        else{
            throw new Exception('Invalid API key or Channel ID');
        }
    } 
    catch(Exception $e){
        $apiError = $e->getMessage();
        }

?> -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-md">
                <h2><b>Preachings of <?php echo $_settings->info('name') ?></b></h2>
                <hr>
                <div id="videoContainer" class="d-flex flex-wrap">

                    <?php
                        echo '<div class="mr-2 mb-3">';
                        $qry_live = $conn->query("SELECT live_url FROM `live` ORDER BY date_created DESC LIMIT 1");
                        if ($qry_live->num_rows > 0) {
                            while ($row = $qry_live->fetch_assoc()) {
                            
                            echo' <iframe width="260"  height="180" src="https://www.youtube.com/embed/'. $row["live_url"] .'" title="'.$_settings->info('name').'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                            echo '<h6 class="text-red text-center"> LIVE</h6>';
                            }
                        } else {
                            echo '<p class="text-danger "style="width:200px;">No Live found.</p>';
                            

                        }
                        echo '</div>';
                        $qry_videos = $conn->query("SELECT * FROM `videos` ORDER BY date_created DESC LIMIT 3");

                        // Check if there are any rows returned from the query
                        if ($qry_videos->num_rows > 0) {
                            while ($row = $qry_videos->fetch_assoc()) {
                                $live_title = mb_substr($row['title'], 0, 25, 'UTF-8');
                                echo '<div class="mr-2 mb-3">';
                                echo '<iframe width="250" height="180" src="https://www.youtube.com/embed/'. $row["video_url"] .'" frameborder="0" allowfullscreen></iframe>';
                                echo '<h6>'.$live_title.'...</h6>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>No videos found.</p>';
                        }
                    ?>
            </div>
            <button id="loadMoreBtn" class="btn btn-primary mt-3">See More</button>                 

        </div>
    </div>
</section>
<script>
var lastVideoId = null;

document.getElementById('loadMoreBtn').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'load_more_videos.php?load_more=true');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            var container = document.getElementById('videoContainer');
            container.innerHTML += this.responseText;
            document.getElementById('loadMoreBtn').style.display = 'none'; // Hide the button
        }
    };
    xhr.send();
});

</script>