<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Content
        <small>View Content </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/trip'); ?>"><i class="fa fa-cogs"></i> Manage Trip</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> View Content </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Content </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
                
<div class="table-responsive panel">
    <table class="table">
    <tbody>
        <tr>
            <td class="text-success">Trip Start Date :</td>
            <td><?php echo $user_data[0]['t_start_date']; ?></td>
        </tr>
        <tr>
            <td class="text-success">Trip End Date :</td>
            <td><?php echo $user_data[0]['t_end_date']; ?></td>
        </tr>
        <tr>
            <td class="text-success">Trip Start time :</td>
            <td><?php echo $user_data[0]['t_start_time']; ?></td>
        </tr>
        <tr>
            <td class="text-success">Trip End Time :</td>
            <td><?php echo $user_data[0]['t_end_time']; ?></td>
        </tr>
        <tr>
            <td class="text-success">DRIVER:</td>
            <td><?php echo $user_data[0]['driverName']; ?></td>
        </tr>
        <tr>
            <td class="text-success">VEHICLE :</td>
            <td><?php echo $user_data[0]['vehicleName']; ?></td>
        </tr>
        <tr>
            <td class="text-success">OWNER:</td>
            <td><?php echo $user_data[0]['ownerName']; ?></td>
        </tr>
        <tr>
            <td class="text-success">TRIP STATUS :</td>
            <td><?php echo $user_data[0]['tripStatus']; ?></td>
        </tr>
        

        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>
</section>
