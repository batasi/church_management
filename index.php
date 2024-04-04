<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="light-mode">
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php require_once('inc/topBarNav.php') ?>
<?php $page = isset($_GET['p']) ? $_GET['p'] : 'home';  ?>


<?php 
    if(!file_exists($page.".php") && !is_dir($page)){
        include '404.html';
    }else{
    if(is_dir($page))
        include $page.'/index.php';
    else
        include $page.'.php';

    }
?>
<hr>
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="col-12">
            <div class="row">
            <div class="col-lg-8">
                    <?php include "about.html" ?>
                </div>
                <div class="col-lg-4 border-left py-5">
                  
                    <h4><b>Reach Us </b></h4>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-phone-square"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('contact') ?></div>
                    </div>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-envelope-square"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('email') ?></div>
                    </div>
                    <div class="d-flex w-100">
                        <div class="col-1"><span class="fa fa-map-marked-alt"></span></div>
                        <div class="col-auto flex-grow-1"><?php echo $_settings->info('address') ?></div>
                    </div><hr>
                    <h4><b>Our Social Media</b></h4>
                    <div class="d-flex w-100">
                        <div class="col-1"><a href="https://www.facebook.com/EmpowermentMissions" target="_blank"> <span class="fab fa-facebook ml-2 text-blue"></span></a></div>
                        <div class="col-auto flex-grow-1"> FaceBook</div>
                    </div>
                    <div class="d-flex w-100">
                        <div class="col-1"><a href="https://www.youtube.com/@EmpowermentMissions" target="_blank"><span class="fab fa-youtube ml-2 text-red"></span></a></div>
                        <div class="col-auto flex-grow-1"> YouTube</div>
                    </div>

                    

                </div>
                
            </div>
        </div>
    </div>
</section>
<?php require_once('inc/footer.php') ?>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade bg-gradient" id="uni_modal" role='dialog'>
    <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered " role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>

</body>
</html>