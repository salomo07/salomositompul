<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PSG IT Inventory</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('/template/link');?>
  <!-- <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css"> -->
  <link rel="stylesheet" href="assets/plugins/datatables/jquery-ui.css">
  <link rel="stylesheet" href="assets/plugins/datatables/dataTables.jqueryui.min.css">
  <link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <?php echo $header?>
  <?php echo $asideleft?>

  <div class="content-wrapper">
    <section class="content-header"><br>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>">PSG IT Inventory</a></li>
        <li class="active"><?php echo $this->router->fetch_class();?></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box" style="border-top-color: violet;"> <!-- Add & Edit BC -->
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Mutasi Barang</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body" style="overflow: auto;">
              <div class="col-md-12">
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Date Start:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" id="txtTanggalStart" class="form-control pull-right" onchange="getMutasi()">
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Date End:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" id="txtTanggalEnd" class="form-control pull-right" onchange="getMutasi()">
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Jenis Mutasi</label>
                    <select onchange="getMutasi()" id="selectJenis" class="form-control select2" style="width: 100%;">
                      <option value="MPK">Mutasi Mesin & Peralatan Kantor</option>
                      <option value="MBS">Mutasi Barang Sisa & Scrap</option>
                      <option value="MBJ">Mutasi Barang Jadi</option>
                      <option value="MBB">Mutasi Bahan Baku & Bahan Penolong</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="col-md-12">
                <div class="col-md-2">
                  <div class="form-group">
                    <button id="btnExportPDF" onclick="exportPDF()" style="background-color: violet" class="btn btn-block"><i class="glyphicon glyphicon-print"></i> Export to PDF</button>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <button id="btnExportExcel" onclick="exportExcel()" style="background-color: violet" class="btn btn-block"><i class="glyphicon glyphicon-floppy-save"></i> Export to Excel</button>
                  </div>
                </div>
              </div>
              <br><br><br><center><div id="txtMsg"></div></center>
              <div class="col-md-12">
                <table id="tblReportMutasi" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th><center>Kode Barang</center></th>
                          <th><center>Nama Barang</center></th>
                          <th><center>Saldo Awal</center></th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer">
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

  <footer class="main-footer">
    <center>Copyright &copy; PT. PSG 2016.</center>
  </footer>
  <div id="myModal" class="modal fade" tabindex="-1" role="dialog"></div>
  <?php $this->load->view('/template/asideright');?>
<div class="control-sidebar-bg"></div>
</div>
</body>
</html>
<?php $this->load->view('/template/script');?>
<style>
  .datepicker{z-index:1151 !important;}
</style>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
<script src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/moment.min.js"></script>
<script>
var start = moment().subtract(30, 'days').format('DD-MM-YYYY');
var end = moment().format('DD-MM-YYYY');
$('#txtTanggalStart').val(start);
$('#txtTanggalEnd').val(end);

$('#txtTanggalStart').datepicker(
{
  autoclose: true,format: 'dd-mm-yyyy'
});
$('#txtTanggalEnd').datepicker(
{
  autoclose: true,format: 'dd-mm-yyyy'
});

getMutasi();
function getMutasi()
{
  $.ajax({
        url: "<?php echo base_url();?>ReportMutasi/getMutasiByPriode",
        method:"POST",
        data : { start: $('#txtTanggalStart').val(),end:$('#txtTanggalEnd').val(),jenis:$('#selectJenis').val()},
        success: function (response)
        {console.log(response);
          var table=$('#tblReportMutasi').DataTable();table.destroy();
          $('#tblReportMutasi').html(response);
          $('#tblReportMutasi').DataTable( {
            "scrollY": 400,
            "scrollX": true,
            "paging":   false,
            "ordering": true,
            "info":     false,
            "columnDefs": [{ "width": "50%", "targets": 7 }]
          });
          // $('#tblReportMutasi').DataTable( {
          //   "paging":   false,
          //   "ordering": true,
          //   "info":     false
          // } );
          $('#txtMsg').html('');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
    });
}
function exportExcel()
{
  var mutasiTerpilih =[];
  $('#tblReportMutasi tbody tr').each(function()
  {
    $(this).find('input:checkbox:checked').each(function()
    {
      var Kode=$(this).closest('tr').find('td').eq(0).text(),Nama=$(this).closest('tr').find('td').eq(1).text(),Sat=$(this).closest('tr').find('td').eq(2).text(),SaldoAwal=$(this).closest('tr').find('td').eq(3).text(),Pemasukan=$(this).closest('tr').find('td').eq(4).text(),Pengeluaran=$(this).closest('tr').find('td').eq(5).text(),Penyesuaian=$(this).closest('tr').find('td').eq(6).text(),SaldoAkhir=$(this).closest('tr').find('td').eq(7).text(),StockOpname=$(this).closest('tr').find('td').eq(8).text(),Selisih=$(this).closest('tr').find('td').eq(9).text(),Ket=$(this).closest('tr').find('td').eq(10).text();

      var objectMutasiTerpilih={'IdMutasi':$(this).val(),Kode:Kode,Nama:Nama,Sat:Sat,SaldoAwal:SaldoAwal,Pemasukan:Pemasukan,Pengeluaran:Pengeluaran,Penyesuaian:Penyesuaian,SaldoAkhir:SaldoAkhir,StockOpname:StockOpname,Selisih:Selisih,Ket:Ket};
      mutasiTerpilih.push(objectMutasiTerpilih);
    });
  });

  if(mutasiTerpilih.length==0)
  {alert('Silahkan pilih transaksi Mutasi yang akan di export ke Excel.');}
  else
  {
    $.ajax({
        url: "<?php echo base_url();?>ExportExcel/exportReportMutasi",
        method:"POST",
        data : { jenis: $('#selectJenis').val(),start:$('#txtTanggalStart').val(),end:$('#txtTanggalEnd').val(),mutasiTerpilih:mutasiTerpilih},
        success: function (response)
        {
          window.location.href ='<?php echo base_url();?>ExportExcel/exportReportMutasi/';
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          alert("Error: " + errorThrown);
        }
    });
  }
}

function checkAll(ele)
{
  var checkboxes = document.getElementsByTagName('input');
  if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].type == 'checkbox') {
              checkboxes[i].checked = true;
          }
      }
  } else {
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].type == 'checkbox') {
              checkboxes[i].checked = false;
          }
      }
  }
}
</script>