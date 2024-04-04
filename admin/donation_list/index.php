<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php require_once('../config.php'); ?>
<?php 
    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List Of Donations</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<form action="" id="filter-data">
				<div class="row align-items-end">
					<div class="col-md-8">
						<div class="form-group">
							<div class="row justify-content-center pt-4">
								<label for="" class="mt-2">Month</label>
								<div class="col-sm-3">
									<input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
								</div>
							</div>
						</div>
					</div>		
					<div class="col-md-4">
						<div class="form-group">
							<button class="btn btn-success btn-flat" type="button" id="print"><i class="fa fa-print"></i> Print</button>
								<a href="?page=donation_list/manage_donations" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
					</div></div>
					
				</div>
			</form>
        <div id="outprint">
			<table class="table table-hover table-striped">
				
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>DateTime</th>
						<th>Contact</th>
						<th>Name</th>
						<th>Project Donated For</th>
						<th>Amount</th>
						<th>Action</th>

					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$total = 0;
						$qry = $conn->query("SELECT p.*, d.title as dname, concat(p.firstname, p.lastname, p.organizationname) as firstname FROM enrollee_list p
						 inner join donation d on d.id = p.package_id
						  where date_format(p.date_created,'%Y-%m') = '$month' order by unix_timestamp(p.date_created) asc ");
						if($qry->num_rows > 0):
						while($row = $qry->fetch_assoc()):
				    	$total += $row['cost'];

						
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ($row['contact']) ?></td>
							<td><?php echo ucwords($row['firstname']) ?></td>
							<td><?php echo $row['dname'] ?></td>
							<td class="text-right"><?php echo number_format($row['cost'],2) ?></td>
							<td class="text-center">	
								<a href="?page=donation_list/manage_donations&id=<?php echo $row['id'] ?>" class="btn btn-sm btn-outline-primary" type="button" data-id="<?php echo $row['id'] ?>">Edit</a>
								<button class="btn btn-sm btn-outline-danger delete_donations" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>									
							</td>
						</tr>
					<?php endwhile;
					 else:
					?>
					<tr>
                            <th class="text-center" colspan="7">No Data.</th>
                    </tr>
                    <?php 
                        endif;
                    ?>
				</tbody>
				<tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th class="text-right"><?php echo number_format($total,2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
			</table>
		</div>
		</div>
	</div>
</div>

<script>
		$('#new_donation').click(function(){
		uni_modal("New Donation ","manage_donations.php","mid-large")
	})

	$('.view_donations').click(function(){
		uni_modal("Expenses Details","view_donations.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
	})
	
	$('.edit_donations').click(function(){
		uni_modal("Manage Donations","manage_donations.php?id="+$(this).attr('data-id'),"mid-large")
	})
	
	$('.delete_donations').click(function(){
		_conf("Are you sure to delete this donation ?","delete_donations",[$(this).attr('data-id')])
	})
	
	function delete_donations($id){
		start_loader();
		$.ajax({
			url:"../classes/Master.php?f=delete_enrollment",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	$(document).ready(function(){
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('#print').click(function(){
            var _h = $("head").clone()
            var _p = $('#outprint').clone()
            var el = $("<div>")
            start_loader()
            $('script').each(function(){
                if(_h.find('script[src="'+$(this).attr('src')+'"]').length <= 0){
                    _h.append($(this).clone())
                }
            })
			var ao = "";
			
            _h.find('title').text("Payment Report - Print View")
            _p.prepend("<hr class='border-navy bg-navy'>")
            _p.prepend("<div class='mx-5 py-4'><h1 class='text-center'><?= $_settings->info("name") ?></h1>"
                        +"<h5 class='text-center'>' Donations Report of <?php echo date("F, Y",strtotime($month)) ?></h5><h5 class='text-center'>"+ao+"</h5></div>")
            el.append(_h)
            el.append(_p)

            var nw = window.open("","_blank","height=800,width=1200,left=200")
                nw.document.write(el.html())
                nw.document.close()
                setTimeout(()=>{
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                },300)
        })
	})
</script>
<script>
$('#month').change(function(){
    location.replace('..//../admin/?page=donation_list&month='+$(this).val())
})

</script>