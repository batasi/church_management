<?php
if(isset($_GET['id']) && $_GET['id'] > 0){

    $qry = $conn->query("SELECT * from `live` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<style>
	img#cimg{
		height: 20vh;
		width: 15vw;
		object-fit: cover;
		object-position: center top;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?>Live Youtube Video</h3>
	</div>
	<div class="card-body">
		<form action="" id="event-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<p class="text-primary"><i><b>Insert a live url from youtube below</b></i></p>
            <div class="form-group">
				<label for="live_url" class="control-label">Live Video Url</label>
                <input type="text" class="form-control form" required name="live_url" value="<?php echo isset($live_url) ? $live_url : '' ?>">
            </div>
			
			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="event-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=youtube">Cancel</a>
	</div>
</div>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		$('#event-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_live",
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
						location.href = "./?page=youtube";
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
	})
</script>