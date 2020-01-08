<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Trip Header (Page header) -->
<section class="content-header">
    <h1>
        trip
        <small>Edit Trip </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/trip'); ?>"><i class="fa fa-cogs"></i> Manage Trip</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Trip </li>
    </ol>
</section>

<!-- Main trip -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Trip </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/trip/update_trip/' . $tripData[0]['t_id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Source latitude">Source latitude</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_start_latitude" value="<?php echo $tripData[0]['t_start_latitude']; ?>" class="form-control required" id="t_start_latitude" placeholder="Enter Source Latitude">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_start_latitude'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Source Longitude">Source Longitude</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_start_longitude" value="<?php echo $tripData[0]['t_start_longitude']; ?>" class="form-control required" id="t_start_longitude" placeholder="Enter Source longitude">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_start_longitude'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Source Latitude">Destination Latitude</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_end_latitude" value="<?php echo $tripData[0]['t_end_latitude']; ?>" class="form-control required" id="t_end_latitude" placeholder="Enter Destination Latitude">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_end_latitude'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Destination Longitude">Destination Longitude</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_end_longitude" value="<?php echo $tripData[0]['t_end_longitude']; ?>" class="form-control required" id="t_end_longitude" placeholder="Enter Destination longitude">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_end_longitude'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Start Date">Start Date</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_start_date" value="<?php echo $tripData[0]['t_start_date']; ?>" class="form-control required" id="t_start_date" placeholder="Enter start date">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_start_date'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="End Date">End Date</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_end_date" value="<?php echo $tripData[0]['t_end_date']; ?>" class="form-control required" id="t_end_date" placeholder="Enter End Date">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_end_date'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Start Time">Start Time</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_start_time" value="<?php echo $tripData[0]['t_start_time']; ?>" class="form-control required" id="t_start_time" placeholder="Enter start time">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_start_date'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="End Time">End Time</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="t_end_time" value="<?php echo $tripData[0]['t_end_time']; ?>" class="form-control required" id="t_end_date" placeholder="Enter End Time">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('t_end_date'); ?></span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
                
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/trip'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
   </div>
</section>
<script type="text/javascript">
    
</script>