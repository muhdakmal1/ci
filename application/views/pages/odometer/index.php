<style>
  .modal-info .modal-body {
    background-color: #00c0ef00 !important;
    color:#000 !important;
  }

  .card {
    font-size: 1em;
    overflow: hidden;
    padding: 0;
    border: none;
    border-radius: .28571429rem;
    box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
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
                <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-info"><i class="icon-cog fa fa-plus" style="color:#3c8dbc"></i></a>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
              <div class="card">
              <p class="card-block">
              <div class="col-md-12">
                <div id="collapsed" class="col-xs-9 col-md-12 m-t-xs m-b-sm">
                  <div id="demo" class="collapse in">
                    <div class="row">
                      <?php echo form_open('', 'class="email" id="myform"'); ?>
                        <div class="col-md-6 col-xs-12">
                          <div class="row form-group form-group-sm">
                            <label class="control-label form-control-static col-xs-3">Perolehan</label>
                            <div class="col-xs-9">
                              <select name="ser_perolehan" id="ser_perolehan" class="form-control selectpicker" data-live-search="true">
                                  <option value="">Pilih Perolehan</option>
                              </select>
                            </div>	
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
</p>
              </div>
            </div>

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
  });
</script>