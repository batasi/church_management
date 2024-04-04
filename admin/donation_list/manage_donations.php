<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `enrollee_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<style>
    .note-group-select-from-files {
        display: none;
    }
    .uploaded_img{
        width:150px;
        height:135px;
        object-fit:scale-down;
        object-position:center center;
    }
    .img-panel{
        width:170px; 
    }
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Donation</h3>
	</div>
	<div class="card-body">
		<form action="" id="blog-form">
			
			<div class="form-group">
				<label for="firatname" class="control-label">Firstname</label>
                <input type="text" name="firstname" id="firstname"  class="form-control form no-resize" value="<?php echo isset($firstname) ? $firstname : ''; ?>"></input>
			</div>
          
            <div class="form-group">
				<label for="" class="control-label">Lastname</label>
	            <input type="text" class="form-control form no-resize" id="lastname" name="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>"></input>
			</div>
           
            <div class="form-group">
				<label for="organizationname" class="control-label">Organization Name</label>
                <input type="organizationname" name="organizationname" id="organizationname" class="form-control form no-resize" placeholder="Only church/other organization" value="<?php echo isset($organizationname) ? $organizationname : ''; ?>"></input>
			</div>
            
            <div class="form-group">
				<label for="contact" class="control-label">Contact</label>
                <input type="text" name="contact" id="contact"  class="form-control form " value="<?php echo isset($contact) ? $contact : ''; ?>"></input>
			</div>
            <div class="form-group">
				<label for="address" class="control-label">Address</label>
                <input type="text" name="address" id="address" class="form-control form " value="<?php echo isset($address) ? $address : ''; ?>"></input>
			</div>
            <div class="form-group">
				<label for="package_id" class="control-label">Select Giving Opportunity</label>
                <select name="package_id" id="package_id" class="custom-select select2" required>
                <option value=""></option>
                <?php
                    $qry = $conn->query("SELECT * FROM `donation` WHERE `status` = 1 order by `date_created` desc");
                    while($row= $qry->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($package_id) && $package_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['title'] ?></option>
                <?php endwhile; ?>
                </select>
			</div>
            <div class="form-group">
				<label for="cost" class="control-label">Amount</label>
	            <input type="text" class="form-control form" id="cost" name="cost" value="<?php echo isset($cost) ? $cost : ''; ?>"></input>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="blog-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=donation_list">Cancel</a>
	</div>
</div>
<div class="d-none" id="upload_clone">
<div class="d-flex w-100 align-items-center img-item">
    <span>
        <img src="" class="img-thumbnail uploaded_img" alt="blog_uploads"> <br>
        <a href="" target="_blank" class="upload_link"></a>
    </span>
    <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="" onclick="rem_img($(this))"><i class="fa fa-trash"></i></button></span>
</div>
</div>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
            _this.siblings('.custom-file-label').html(input.files[0].name)
	        reader.onload = function (e) {
	        	$('#banner_img').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
    function delete_img($path){
        start_loader()
        
        $.ajax({
            url: _base_url_+'classes/Master.php?f=delete_img',
            data:{path:$path},
            method:'POST',
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured while deleting an Image","error");
                end_loader()
            },
            success:function(resp){
                $('.modal').modal('hide')
                if(typeof resp =='object' && resp.status == 'success'){
                    $('[data-path="'+$path+'"]').closest('.img-item').hide('slow',function(){
                        $('[data-path="'+$path+'"]').closest('.img-item').remove()
                    })
                    alert_toast("Image Successfully Deleted","success");
                }else{
                    console.log(resp)
                    alert_toast("An error occured while deleting an Image","error");
                }
                end_loader()
            }
        })
    }
    function upload_images(input,_this){
			start_loader();
            $.ajax({
				url:_base_url_+"classes/Master.php?f=upload_files",
				data: new FormData($('#blog-form')[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
					console.log(err)
					alert_toast("An error occured while uploadinf the images",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        $('[name="upload_code"]').val(resp.upload_code)
                        Object.keys(resp.images).map(k=>{
                            var el = $('#upload_clone>div').clone()
                            el.find('img').attr('src','<?php echo base_url ?>'+resp.images[k])
                            el.find('.upload_link').attr('href','<?php echo base_url ?>'+resp.images[k])
                            el.find('.upload_link').attr('alt',resp.images[k])
                            el.find('.upload_link').text('<?php echo base_url ?>'+resp.images[k])
                            el.find('.rem_img').attr('data-path',resp.images[k])
                            $('#uploaded-holder').append(el)
                        })
                    }else{
                        console.log(resp)
					    alert_toast("An error occured while uploadinf the images",'error');
                    }
					end_loader();
                }
            })
        }
        function rem_img(_this){
            _conf("Are sure to delete this image permanently?",'delete_img',["'"+_this.attr('data-path')+"'"])
        }
	$(document).ready(function(){
        
       
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
       
		$('#blog-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_enrollment",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=donation_list";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
                    ['insert', ['picture','link']],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>