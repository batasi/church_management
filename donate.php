<!-- Header-->
<header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5 w-100">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Donate</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container">
        <div class="col-12">
            <div class="row">
            <div class="col-lg-8">
                    <?php include "donate.html" ?>
                </div>
                <div class="col-lg-4 border-left py-5">
                  
                <h4><b>Giving Opportunities</b></h4>
                   <hr>
                   <?php 
                    $qry_blogs =$conn->query("SELECT * FROM `donation` where `status` = 1 order by unix_timestamp(`date_created`) desc Limit 10");
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

            <style>
    #service-list tbody tr{
        cursor: pointer;
    }
    #package-details{
        display:none
    }
    .about .row{
   display: flex;
   flex-wrap: wrap;
   gap: 1.5rem;
   align-items: flex-start;
}

.about .row .image{
   flex: 1 1 40rem;
}

.about .row .image img{
   width: 100%;
   border-radius: 10px;
}

.about .row .content{
   flex: 1 1 40rem;
   text-align: flex-start;
}

.about .row .content h3{
   margin-bottom: .5rem;
   text-transform: capitalize;
}

.about .row .content p{
   padding: 1rem 0;
}

.about .row .content .tab-tittles{
   display:flex;
   margin: 10px 10px 10px;  
}
.about .row .content .tab-links{
   margin-right: 50px;
   cursor: pointer;
   position: relative;
}
.about .row .content .tab-links::after{
   content: '';
   width: 0; 
   height: 3px;
   background: blue;
   position: absolute;
   left: 0;
   bottom: 10px;
   transition: 0.5s;
}
.about .row .content .tab-links.active-link::after{
   width: 50%;
}
.about .row .content .tab-contents ul{
    display: inline-block;
}
.about .row .content .tab-contents ul li{
   list-style: none;
   margin: 0 20px 20px 0 ;  
   
}
.about .row .content .tab-contents ul li span{
   color: blue;
   display: block;

}
.about .row .content .tab-contents{
   display: none;
}
.about .row .content .tab-contents.active-tab{
   display: block;
}

</style>
<hr>
<section class="about">

<div class="row">
   <div class="image">
   </div>
   <div class="content">
      
         <h3 >How To Donate?</h3>
         <p>
         <span class="text-primary"><?php echo $_settings->info('name') ?></span> supports different payment methods.
         Navigate through and select the one you are comfortable with. Also fill the form below after donating
         
         </p>

         <div class="tab-tittles">
            <p class="tab-links active-link text-green" onclick="opentab('skills')"><b>M-Pesa</b></p>  
            <p class="tab-links text-red" onclick="opentab('experiences')"><b>Equity Bank</b></p>  
            <p class="tab-links" onclick="opentab('education')"><b>Other</b></p>  
         </div>

         <div class="tab-contents active-tab" id="skills">
            <ul>
               <img src="images/mpesa.avif" width="250" height="150" alt=""><br>
               <li><span>Paybill No</span><?php echo $_settings->info('name') ?></li>
               <li><span>Acc No</span><?php echo $_settings->info('name') ?></li>
               <li><span>Acc Name</span><?php echo $_settings->info('name') ?></li>
            </ul>
         </div>

         <div class="tab-contents" id="experiences">
            <ul>
               <img src="images/equity.png" width="250" height="150" alt=""><br>
               <li><span>Acc Name</span><?php echo $_settings->info('name') ?></li>
               <li><span>Acc No</span><?php echo $_settings->info('name') ?></li>
            </ul>
         </div>

         <div class="tab-contents" id="education">
            <ul>
               <li><span>Co-operative Bank</span></li>
               
            </ul>
         </div>
   </div>
</div>

</section>
<hr>
<div class="py-3">
    <div class="card card-outline card-navy rounded-0">
        <div class="card-header rounded-0">
            <h5 class="card-title">Contact Form</h5>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <form action="" id="enrollment-form" method="POST">
                    <input type="hidden" name="id">
                    <fieldset>
                        <legend class="text-navy">Contact Information</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">First Name</label>
                                    <input type="text" name="firstname" id="firstname" autofocus class="form-control form-control-border border-navy">
                                </div>
                            </div>
                           
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastname" class="control-label">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control form-control-border border-navy">
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="organizationname" class="control-label">Organization Name</label>
                                    <input type="text" name="organizationname" id="organizationname" placeholder="Only church/other organization" autofocus class="form-control form-control-border border-navy">
                                </div>
                            </div>
                           
                        
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact" class="control-label">Contact No</label>
                                    <input type="text" name="contact" id="contact" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="control-label">Address <small><span class="text-muted"></span></small></label>
                                    <input type="textarea" rows="1" name="address" id="address" class="form-control form-control-border border-navy" placeholder="Physical address" required></input>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <hr class="bg-navy border-navy">
                    <fieldset>
                        <legend class="text-navy">Donation Details</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="package_id" class="control-label">Would like to support</label>
                                    <select name="package_id" id="package_id" class="form-control form-control-border border-navy select2" required>
                                        <option value="" selected disabled></option>
                                        <?php 
                                            $package_arr = [];
                                            $packages = $conn->query("SELECT * FROM `donation` where `status` = 1 order by `date_created` desc");
                                            while($row = $packages->fetch_assoc()):
                                                $package_arr[$row['id']] = $row;
                                        ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div><br>
                        <div class="row" id="package-details" style="">
                            <div class="col-md-12">
                                <p id="description" class="text-primary">Thank you for your Donation</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost" class="control-label">Amount Donated</label>
                                    <input type="text" name="cost" id="cost" class="form-control form-control-border border-navy" required>
                                </div>
                            </div>
                        
                        </div>
                    </fieldset>
                    <hr class="bg-navy border-navy">
                    <div class="col-12 text-center">
                    <button  class="btn btn-primary btn-round" type="submit">Submit Form</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- Include jQuery -->
 <script src="plugins/select2/js/select2.js"></script>

 <script>
    var packageData = <?= json_encode($package_arr) ?>;
    function calc(){
        var total = 0;
        $('.service_id:checked').each(function(){
            var cost = $('input[name="cost['+$(this).val()+']"]').val();
            total += parseFloat(cost);
        });
        $('#total_amount').text(parseFloat(total).toLocaleString('en-US',{style:"decimal", minimumFractionDigits: 2, maximumFractionDigits: 2}));
        $('[name="total"]').val(parseFloat(total));
    }
    $(function(){
        $('#package_id').select2({
            placeholder: "Please Select giving opportunity Here.",
            width: "100%"
        });
        $('#package_id').change(function(){
            var id = $(this).val();
            if(packageData[id]){
                $("#description").text(packageData[id].description);
                $('#package-details').show('slow');
            }else{
                $('#package-details').hide('');
            }
        });
        $('#service-list tbody tr').click(function(){
            if($(this).find('.service_id').is(":checked") == true){
                $(this).find('.service_id').prop("checked",false).trigger("change");
            }else{
                $(this).find('.service_id').prop("checked",true).trigger("change");
            }
            calc();
        });
        $('#enrollment-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();
            $.ajax({
                url: "classes/Master.php?f=save_enrollment",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred",'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        uni_modal("Success","message.php");
                        $('#uni_modal').on('hide.bs.modal',function(e){
                            location.reload();
                        });
                        $('#uni_modal').on('shown.bs.modal',function(e){
                            end_loader();
                        });
                        _this[0].reset();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    }else{
                        el.addClass("alert-danger");
                        el.text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    end_loader();
                    $('html, body').animate({scrollTop:_this.offset().top},'fast');
                }
            });
        });
    });
    var tablinks = document.getElementsByClassName("tab-links");
    var tabcontents = document.getElementsByClassName("tab-contents");

    function opentab(tabname){
    for(tablink of tablinks){
        tablink.classList.remove("active-link");
    }
    for(tabcontent of tabcontents){
        tabcontent.classList.remove("active-tab");
    
    }
    event.currentTarget.classList.add("active-link");
    document.getElementById(tabname).classList.add("active-tab");
}
</script>

        </div>
    </div>
</section>
