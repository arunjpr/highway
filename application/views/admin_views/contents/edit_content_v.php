<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        content
        <small>Edit Content </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="<?php echo base_url('admin/content'); ?>"><i class="fa fa-cogs"></i> Manage Content</a></li>
        <li class="active"><i class="fa fa-circle-o"></i> Edit Content </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Content </h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                
            </div>
        </div>

        <!-- form start -->
        <form role="form" name="edit_form" action="<?php echo base_url('admin/content/update_content/' . $user_data['c_id'] . ''); ?>" method="post" class="form-validation" >
           
            <div class="box-body">
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Title">Title</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" name="c_title" value="<?php echo $user_data['c_title']; ?>" class="form-control required" id="c_title" placeholder="Enter title">
                            </div>
                            <span class="help-block error-message"><?php echo form_error('c_title'); ?></span>
                        </div>
                    </div>
                    
                   
                    
                    
                    
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="Content">Content</label>
                            <textarea id="c_content" name="c_content" value="<?php echo $user_data['c_content']; ?>" ></textarea>
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
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Update Info</button>
            </div>
            
        </form>
        <!-- /.form -->
   </div>
</section>
<script type="text/javascript">
    
</script>