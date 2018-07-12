<style>
  .modal-info .modal-body {
    background-color: #00c0ef00 !important;
    color:#000 !important;
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
                                  <?php foreach($query->result() as $option):?>
                                    <option value="<?php echo $option->code?>"><?php echo $option->description?></option>
                                  <?php endforeach;?>
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
              <table id="all" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Company</th>
                  <th>Section</th>
                  <th>PIC Name</th>
                  <!-- <th>Total Warning Vehicle</th> -->
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
    $('#all').DataTable({
      "processing": true,
      "serverSide":true,
      "ajax": {
        url : "<?php echo site_url("pages/posts") ?>",
        dataType : "json",
		    type : "POST",
        data :{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
      },
      "columns": [
		          { "data": "id" },
		          { "data": "title" },
		          { "data": "body" },
		          { "data": "created_at" },
		       ]	 

	    });
    });
</script>