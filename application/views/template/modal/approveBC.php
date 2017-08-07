<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Approve BC</h4>
      </div>
      <div class="modal-body">
        <label>Anda memilih <?php echo $jumlahdiapprove;?> BC untuk diapprove, apakah anda yakin?</label>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button id="btnApproveBC" onclick="ApproveBC()" type="button" class="btn btn-primary">Delete Role</button>
      </div>
  </div>
</div>
<script>
  function ApproveBC(id)
  {
    $.ajax({
        url: "<?php echo base_url();?>BC/approveBC",
        method:"POST",
        data : {'checked':<?php echo $json;?>},
        success: function (response) 
        {
          var table=$('#tblBC').DataTable();table.destroy();
          var table=$('#tblBCApproved').DataTable();table.destroy(); 
          getBC('<?php echo $jenisBC;?>');
          $('#myModal').modal('hide');
           operation='';
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Error: " + errorThrown); 
        }
    });
  }
</script>