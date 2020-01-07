<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicle
        <small>View Vehicle </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/vehicle'); ?>"><i class="fa fa-cogs"></i> Manage Vehicle</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Vehicle </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Vehicle </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
                <div class="col-lg-2 col-md-3">
                    <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/vehicleImage/<?php echo $vehicle_data['v_vehicle_Image'] ?>" class="img-responsive img-thumbnail">
                </div>
            <div class="col-lg-2 col-md-3">
                    <img src="<?php echo base_url() ?>/assets/backend/img/vehicle/rcpic/<?php echo $vehicle_data['v_vehicle_rc'] ?>" class="img-responsive img-thumbnail">
                </div>
<div class="table-responsive panel">
    <table class="table">
    <tbody>
        <tr>

        <td class="text-success"><i class="fa fa-user"></i> Name :</td>

        <td class="text-left"><?php echo $vehicle_data['v_vehicle_name']; ?></td>
    </tr>
    <tr>
        <td class="text-success"><i class="fa fa-mobile"></i> Vehicle Color :</td>
        <td><?php echo $vehicle_data['v_vehicle_Color']; ?></td>
    </tr>

        <tr>
            <td class="text-success"><i class="fa fa-envelope-o"></i>Vehicle Number :</td>
            <td><?php echo $vehicle_data['v_vehicle_number']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-calendar"></i> Vehicle Model :</td>
            <td><?php echo $vehicle_data['v_vehicle_model_no']; ?></td>
        </tr>
        <tr>
            <td class="text-success"><i class="fa fa-home"></i> Vehicle Details  :</td>
            <td><?php echo $vehicle_data['v_vehicle_detail']; ?></td>
        </tr>

        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
</section>
