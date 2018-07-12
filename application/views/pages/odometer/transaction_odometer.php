<style>
td.highlight {
        font-weight: bold;
        color: blue;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Vehicle</a></li>
        <li class="active">Odometer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>

              <div class="btn-group pull-right">
              <!-- <a class="btn pull-right" target="_blank" href="<?php echo site_url('assets/PHPJasperXML2-master/examples/sample1.php') ?>"><i class="fa fa-print"></i></a> -->
                <a class="btn btn-primary btn-flat" target="_blank" href="<?php echo base_url('reports/phpwordtemplate') ?>"><i class="fa fa-file-word-o"></i></a>
                <a class="btn btn-primary btn-flat" target="_blank" href="<?php echo base_url('reports/index') ?>"><i class="fa fa-print"></i></a>
                <a class="btn btn-primary btn-flat" onclick="refresh_table()"><i class="fa fa-car"></i></a>
                <a class="btn btn-default btn-flat"><i class="icon-cog fa fa-plus" style="color:#3c8dbc"></i></a>
                <form method="post" id="import_form" enctype="multipart/form-data">
                  <input type="file" name="file" id="file" required accept=".xls, .xlsx, .csv" /></p>
                  <input type="submit" name="import" value="Import" id="import" class="btn btn-info" />
                  </form>
              </div>
            </div>

            <div class="content">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="col-md-12">
                  <div id="collapsed" class="col-xs-9 col-md-12 m-t-xs m-b-sm">
                    <div id="filter" class="collapse in">
                      <div class="row">
                        <?php echo form_open('', 'class="email" id="myform"'); ?>
                          <div class="col-md-6 col-xs-12">
                            <div class="row form-group form-group-sm">
                              <label class="control-label">Company</label>
                                <select name="company_name" id="company_name" class="form-control selectpicker" data-live-search="true">
                                  <option value="">Choose Company</option>
                                </select>	
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>

            <div class="box-body">
              <table id="transaction_list" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Vehicle</th>
                  <th>Section</th>
                  <th>Date</th>
                  <th>Odometer</th>
                  <th>Variance</th>
                  <th>Remark</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Custom js -->
<script src="<?php echo base_url('assets/') ?>build/myserv.datatable.min.js"></script>
<script>

  $(document).ready(function () {
    var transaction_tb = $('#transaction_list').DataTable({
      "processing": true,
      "serverSide":true,
      "ajax": {
        url : "<?php echo site_url("pages/data_transaction_odometer") ?>",
        dataType : "json",
        type : "POST",
        data :{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
      },
      "fnRowCallback": function ( row, data ) {
            if ( data[5]>0 ) {
                $('td', row).eq(5).addClass('highlight');
            }
        },
      "columns": [
              { "data": "id" },
              { "data": "vehicle_no" },
              { "data": "transaction_type" },
              { "data": "date" },
              { "data": "odometer" },
              { "data": "variance" },
              { "data": "remark" },
            ]	 

      });
  });
  
  refresh_table = function() {
    $('#transaction_list').DataTable().ajax.reload();
  };

  $('#import_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"<?php echo base_url(); ?>pages/import_data_csv",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import_csv_btn').html('Importing...');
      },
      success:function(data)
      {
        table_trans.ajax.reload();
      }
    });

 });
</script>