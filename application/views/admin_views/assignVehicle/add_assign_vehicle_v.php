<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicle
        <small>Assign Vehicle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/assignVehicle'); ?>"><i class="fa fa-cogs"></i> Manage Vehicles Type</a></li>
        <li><a class="active"><i class="fa fa-cogs"></i> Assign Vehicle</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Assign Vehicle</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
        
       



        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/assignVehicle/create_assign_vehicle'); ?>" method="post"  class="form-validation" >
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="Driver">Driver</label>
                            <select name="driver" class="form-control required" id="driver">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($driverData as $row) {
                                 echo '<option value ="'.$row['Id'].'">'.$row['Name'].'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('driver'); ?></span>
                        </div>
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="Vehicle">Vehicle</label>
                            <select name="vehicle" class="form-control required" id="vehicle">
                                <option value="" selected="" disabled="">select</option>
                                <?php
                                foreach ($vehicleData as $row) {
                                 echo '<option value ="'.$row['v_Id'].'">'.ucwords($row['v_vehicle_name']).' '.$row['v_vehicle_number'].'</option>';
                                    
                                }
                                ?>
                            </select>
                            <span class="help-block error-message"><?php echo form_error('vehicle'); ?></span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/vehicle/vehicle-type'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
        </form>
        <!-- /.form -->
    </div>
</section>