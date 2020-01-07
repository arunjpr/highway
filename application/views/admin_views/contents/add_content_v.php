<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Content
        <small>Add Content</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/content'); ?>"><i class="fa fa-cogs"></i> Manage Contents</a></li>
        <li><a class="active"><i class="fa fa-cogs"></i> Add Content</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Add Content</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>
        
       



        <!-- form start -->
        <form role="form" name="add_form" action="<?php echo base_url('admin/content/create_content'); ?>" method="post"  class="form-validation" >
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Title">Title</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="c_title" value="<?php echo set_value('c_title'); ?>" class="form-control required" id="c_title" placeholder="Enter title">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('c_title'); ?></span>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Content">Content</label>
                            <textarea id="c_content" name="c_content" ></textarea>
                                <script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
                                 <script>
                                      CKEDITOR.replace( 'c_content' );
                                </script>
                            <script src="<?php echo base_url(); ?>ckeditor/config.js"></script>
                              
                            <span class="help-block error-message"><?php echo form_error('c_content'); ?></span>
                        </div>
                    </div>
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo base_url('admin/content'); ?>" class="btn btn-danger" data-toggle="tooltip" title="Go back"><i class="fa fa-remove"></i> Cancel</a>
                <button type="submit" value="upload" class="btn btn-success"><i class="fa fa-plus"></i> Add Info</button>
            </div>
        </form>
        <!-- /.form -->
    </div>
</section>
<script type="text/javascript">
    document.forms['add_form'].elements['Status'].value = '<?php echo set_value('Status'); ?>';
     $(function () {
                $('#datepicker').datetimepicker();
            });
</script>