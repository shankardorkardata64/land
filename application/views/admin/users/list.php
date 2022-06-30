<style>
table.dataTable tbody tr {
    background-color: #014b84;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #fff;
}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  
<div class="card">
    
<div class="card-body">

<div class="table-responsive">
<table  class='dataTable1 table'>
    <thead>
    <tr>
        <td>Sr.No</td>
        <td>Name</td>
        <td>Username</td>
        <td>Email</td>
        <td>Country</td>
        <td>Status</td>
        <td>Action</td>
    </tr>    
    </thead>
  <tbody>
    <?php 
    $r=0;
    $status='Active';
    foreach($users as $u) {  
        if($u['status']==0) {
            $status='De-Active';
        }
        $enid=en($u['id']);
        ?>
   <tr>
    <td><?=++$r?></td>
   <td><?=$u['fname']?><?=$u['lname']?></td>
   <td><?=$u['username']?></td>
   <td><?=$u['email']?></td>
   <td><?=$u['county']?></td>
 <td><?=$status?></td>
 <td>
<a href='<?=base_url('userland')?>/<?=$enid?>' class='btn btn-info btn-sm'>View Purchased Land </a> 

 </td>
   </tr>
   <?php } ?>

   </tbody>
</table>


</div>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
       $.noConflict();
        $('.dataTable1').DataTable({
          
          dom: 'Blfrtip',
    buttons: [
      {
      extend: 'pdf',
      title: '<?=time()?>',
      //exportOptions: { columns: [1,2,3,4,5]},
      filename: '<?=time()?>'
    }, {
      extend: 'excel',      title: '<?=time()?>', // exportOptions: { columns: [1,2,3,4,5]},
      filename: '<?=time()?>'
    }, {
      extend: 'csv',
      title: '<?=time()?>',//  exportOptions: { columns: [1,2,3,4,5]},
      filename: '<?=time()?>'
    }],
        //   'processing': true,
        //   'serverSide': true,
        //   'serverMethod': 'post',
        //   'ajax': {
        //      'url':'<?=base_url('zonejson')?>'
        //   },
        //   'columns': [
             
        //      { data: 'name',bSortable: false },
        //      { data: 'status',bSortable: false },
        //      { data: 'link1',bSortable: false },                                   
        //   ]
        });
     });
</script>
