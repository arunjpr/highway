<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        coupans
        <small>Edit Coupan </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/coupan/coupan'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Coupan </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Coupan </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/coupan/update_coupan/' . $user_data['c_id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Coupan Code</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="c_coupan_code" value="<?php echo $user_data['c_coupan_code'];  ?>" class="form-control required" id="c_coupan_code" placeholder="Enter coupan code">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('c_coupan_code'); ?></span>
                        </div>
                    </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="Coupan Value">Coupan Value</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="c_coupan_value" value="<?php echo $user_data['c_coupan_value'];  ?>" class="form-control required" id="c_coupan_value" placeholder="Enter coupan value">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('c_coupan_value'); ?></span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/coupan'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
    </div>
</section>