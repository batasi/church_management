<style>
    .img-banner-list{
        width:25%;
        height:18vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Search Result</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="list-group">
                <?php 
                $page= isset($_GET['page'])? $_GET['page']: 0;
                $limit = 10; 
                $offset = $page > 0 ? ($page * $limit) : $page;
                $count_all = $conn->query("SELECT b.*,concat(u.firstname,' ',u.lastname) as author FROM `blogs` b inner join `users` u on b.author_id = u.id where b.`status` =1 and (b.`title` LIKE '%{$_GET['search']}%' OR b.`meta_description` LIKE '%{$_GET['search']}%' OR b.`keywords` LIKE '%{$_GET['search']}%' OR b.`content` LIKE '%{$_GET['search']}%' )")->num_rows;
                $blogs = $conn->query("SELECT b.*,concat(u.firstname,' ',u.lastname) as author FROM `blogs` b inner join `users` u on b.author_id = u.id where b.`status` =1 and (b.`title` LIKE '%{$_GET['search']}%' OR b.`meta_description` LIKE '%{$_GET['search']}%' OR b.`keywords` LIKE '%{$_GET['search']}%' OR b.`content` LIKE '%{$_GET['search']}%' ) order by unix_timestamp(b.date_created) desc limit $limit offset $offset");
                while($row=$blogs->fetch_assoc()):
                    ?>
                        <a class="list-group-item list-group-item-action my-2 border" href="<?php echo base_url.$row['blog_url'] ?>">
                            <div class="w-100">
                                <img src="<?php echo validate_image($row['banner_path']) ?>" alt="<?php echo addslashes($row['title']) ?>" align="left" class="bg-dark img-banner-list img-thumbnail m-2">
                                <p class="truncate-5 pt-3"><?php echo strip_tags(stripslashes(html_entity_decode($row['content']))) ?></p><br>
                            </div>
                            <div class="w 100 d-flex justify-content-end">
                                <span class="text-muted">Published: <?php echo date("M d, Y h:i A", strtotime($row['date_created'])) ?></span><br>
                                <span class="text-muted">By: <?php echo ucwords($row['author']) ?></span>
                            </div>
                        </a>
                <?php endwhile; ?>
                </div>
                <?php if($count_all <= 0): ?>
                    <h4 class="text-center">No Article with "<?php echo $_GET['search'] ?>" keyword found.</h4>
                    <?php else:  ?>
                <div class="btn-group">
                    <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $page - 1 ?>" class="btn btn-default border <?php echo $page == 0 ? 'disabled': '' ?>"><i class="fa fa-step-backward"></i></a>
                        <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>" class="btn btn-default border <?php echo $page == 0 ? 'bg-primary': '' ?>">1</a>
                        <?php for($i = 1; $i < ceil(intval($count_all) / intval($limit)); $i++): ?>
                        <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $i ?>" class="btn btn-default border <?php echo $page == $i ? 'bg-primary': '' ?>""><?php echo $i + 1; ?></a>
                        <?php endfor; ?>

                    <a href="<?php echo base_url ?>?p=search&search=<?php echo $_GET['search'] ?>&page=<?php echo $page + 1 ?>" class="btn btn-default border <?php echo $page == (ceil($count_all/$limit) - 1) || $count_all == 0 ? 'disabled': '' ?>"><i class="fa fa-step-forward"></i></a>

                    </div>
                    <?php endif;  ?>

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
</section>