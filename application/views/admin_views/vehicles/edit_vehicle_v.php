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
        <form role="form" name="edit_form" action="<?php echo base_url('admin/vehicle/update_vehicle/' . $user_data['v_Id'] . ''); ?>" method="post" class="form-validation" enctype="multipart/form-data" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle">Vehicle</label>
                            <select name="vehicle_type" class="form-control required" id="vehicle_type">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($vehicleData as $vdata) {
                                  
                                 echo '<option value ="'.$vdata['v_t_id'].'">'.$vdata['v_t_vehicle_name'].'</option>';
                                    
                                 
                                }
                                
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle_type'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle Name">Vehicle Name </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="vehicle_name" value="<?php echo $user_data['v_vehicle_name'];  ?>" class="form-control required" id="vehicle_name" placeholder="Enter vehicle name">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('vehicle_name'); ?></span>
                        </div>
                    </div>
                    
                    
                    </div>
                
                <div class="row">
                    
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Number">Vehicle Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="vehicle_number" value="<?php echo $user_data['v_vehicle_number'];  ?>" class="form-control required" id="vehicle_number" placeholder="Enter vehicle number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('vehicle_number'); ?></span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Model Number">Vehicle Model Number</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="vehicle_model_no" value="<?php echo $user_data['v_vehicle_model_no']; ?>" class="form-control required" id="vehicle_model_no" placeholder="Enter vehicle model number">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('vehicle_model_no'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Details">Vehicle Detail</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="vehicle_detail" value="<?php echo $user_data['v_vehicle_detail'];  ?>" class="form-control required" id="vehicle_detail" placeholder="Enter vehicle details">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('vehicle_detail'); ?></span>
                        </div>
                    </div>
                </div>
                
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Image">RC Picture <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'rcfile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/rcpic/<?php echo $user_data['v_vehicle_rc'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="VehicleImage">Vehicle Picture <span class="required">*</span></label>
                            <div class="input-group">
                                <?php echo form_upload(['name'=>'vimagefile','class'=>'form-control'])?>
                            </div>
                            <div class="input-group">
                                <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleImage/<?php echo $user_data['v_vehicle_Image'] ?>" style="width: 100px;height: 100px;">
                            </div>
                            <span class="help-block error-message"><?php if(isset($upload_error)) echo $upload_error ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- /.row -->
            </div>
               
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/vehicle'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
         </div>
        <!-- /.form -->
    
</section>
<script type="text/javascript">
    document.forms['edit_form'].elements['vehicle_type'].value = '<?php echo $user_data['v_type_id']; ?>';
//    document.forms['edit_form'].elements['v_vehicle_driver_id'].value = '<?php echo $user_data['v_vehicle_driver_id']; ?>';
</script>