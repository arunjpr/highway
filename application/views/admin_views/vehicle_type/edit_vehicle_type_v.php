<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        vehicles
        <small>Edit Vehicle </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/vehicle'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Vehicle </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Vehicle </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/vehicle/update_vehicle/' . $user_data['v_Id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Name">Vehicle Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_name" value="<?php echo $user_data['v_vehicle_name'];  ?>" class="form-control required" id="v_vehicle_name" placeholder="Enter vehicle name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_name'); ?></span>
                        </div>
                    </div>
                    <!-- /.col -->
                   
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Driver">Driver</label>
                            <select name="v_vehicle_driver_id" class="form-control required" id="v_vehicle_driver_id">
                                
                                <option value="" selected="" disabled="">Select driver</option>
                                <option value="1">as</option>
                                <option value="0">ds</option>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_driver_id'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Color">Vehicle Color </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_Color" value="<?php echo $user_data['v_vehicle_Color'];  ?>" class="form-control required" id="v_vehicle_Color" placeholder="Enter vehicle color">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_Color'); ?></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Details">Vehicle Detail</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_detail" value="<?php echo $user_data['v_vehicle_detail'];  ?>" class="form-control required" id="v_vehicle_detail" placeholder="Enter vehicle details">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_detail'); ?></span>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Number">Vehicle Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_number" value="<?php echo $user_data['v_vehicle_number'];  ?>" class="form-control required" id="v_vehicle_number" placeholder="Enter vehicle number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_number'); ?></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Model Number">Vehicle Model Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="v_vehicle_model_no" value="<?php echo $user_data['v_vehicle_model_no']; ?>" class="form-control required" id="v_vehicle_model_no" placeholder="Enter vehicle model number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('v_vehicle_model_no'); ?></span>
                        </div>
                    </div>
                    
                  
                </div>
                <!-- /.row -->
            </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/vehicle'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
    </div>
</section>
<script type="text/javascript">
    document.forms['edit_form'].elements['Status'].value = '<?php echo $user_data['Status']; ?>';
    document.forms['edit_form'].elements['Gender'].value = '<?php echo $user_data['Gender']; ?>';
</script>