<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Assign Vehicle
        <small>Manage Assign Vehicle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
        <div class="box-body">
            <div class="row">
                <div class="col-md-12" >
                    <a href="<?php echo base_url('admin/assignVehicle/add_assign_vehicle'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add Vehicle Type </a>
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Name</th>
                                <th>Added By</th> 
                                <th>Status</th> 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($vehicle_info as $user_data) { ?>
                                <?php $memberObj = $this->session->userdata; ?>
                            <tr>
                                    <td><?php echo $sl++; ?></td>
                                    <td><?php echo $user_data['a_v_t_d_status']; ?></td>
                                    <td><?php echo $memberObj['admin_name']; ?></td>
                                    <td>
                                        <?php
                                        $status = $user_data['a_v_t_d_status'];
                                        if ($status == 1) {
                                            echo "<a href='" . base_url('admin/assignVehicle/inactive_assign_vehicle/' . $user_data['a_v_t_d_id'] . '') . "' class='btn btn-block btn-success btn-xs' data-toggle='tooltip' title='Click to inactive'><i class='fa fa-arrow-down'></i> Active</a>";
                                        } else {
                                            echo "<a href='" . base_url('admin/assignVehicle/active_assign_vehicle/' . $user_data['a_v_t_d_id'] . '') . "' class='btn btn-block btn-warning btn-xs' data-toggle='tooltip' title='Click to active'><i class='fa fa-arrow-up'></i> Inactive</a>";
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <a href="<?php echo base_url('admin/assignVehicle/edit_assign_vehicle/' . $user_data['a_v_t_d_id'] . ''); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url('admin/assignVehicle/remove_assign_vehicle/' . $user_data['a_v_t_d_id'] . '') ?>" class="btn btn-danger btn-xs check_delete" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>