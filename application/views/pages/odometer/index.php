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
                <a class="btn btn-primary btn-flat" target="_blank" href="<?php echo base_url('reports/odometer') ?>"><i class="fa fa-print"></i></a>
              </div>
            </div>
            
            <!-- /.box-header -->
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Company</th>
                  <th>Section</th>
                  <th>PIC Name</th>
                  <th>Total Warning Vehicle</th>
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

<script>
  $(function () {
    $('#example1').DataTable({
        "ajax": {
            url : "<?php echo site_url("pages/odometer_page") ?>",
            type : 'GET'
        },
    })
  })
</script>
