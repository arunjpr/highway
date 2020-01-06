<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
--> 
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Highway- <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/backend/img/favicon.png">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/datepicker/datepicker3.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/skins/_all-skins.min.css">
         <!-- bootstrap wysihtml5 - text editor -->
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
         <!-- DataTables -->
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/datatables/dataTables.bootstrap.css">
         <!-- Custom CSS -->
         <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/custom/css/style.css">
         <link href="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
         <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
         <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url('dashboard'); ?>" class="logo"> 
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Highway</b></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div style="margin-bottom: -56px; margin-top: 9px;" class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                        
                    </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
          
                        <?php
                        $avatar = $this->session->userdata('admin_avatar');
                        if (!empty($avatar)) {
                            $profile_picture = base_url('assets/uploaded_files/profile_img/resize/' . $avatar);
                        } else {
                            $profile_picture = base_url('assets/backend/dist/img/user4-128x128.jpg');
                        }
                        ?>
                        
                        
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>  
                                    <a href="javascript:void()" class="d-inline-block">
                                        <span class="badge badge-pill gradient-2">5</span>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span> 
                                                </div>
                                            </a>
                                        </li>
                                        
                                        
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span> 
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </li>
                        
                        
                        
                        
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo $profile_picture; ?>" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">
                                    <?php echo $full_name = $this->session->userdata('admin_name'); ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo $profile_picture; ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $full_name; ?>
                                        <small>Member since <?php echo date("d F Y", strtotime($this->session->userdata('date_added'))); ?></small>
                                    </p>
                                </li>
                          
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo base_url('profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo $profile_picture; ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $full_name; ?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form (Optional) -->
<!--            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>-->
            <!-- /.search form -->
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <?php echo $main_menu; ?>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php echo $main_content; ?>
    </div>
    <!-- /.content-wrapper -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <!--Anything you want-->
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019 <a href="http://highway.vrok.in/" target="_blank">highway</a>.</strong> All rights reserved.
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->
                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                                    <span class="label label-danger pull-right">70%</span>
                                </span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->
            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
             <div class="control-sidebar-bg"></div>
         </div>
         <!-- ./wrapper -->
         <?php
         $success = $this->session->userdata('success');
         $exception = $this->session->userdata('exception');
         if (!empty($success)) {
            echo "<div class='col-xs-6 col-sm-6 col-md-2 alert bootstrap-growl-bottom-right alert-success' id='message_box' style='position: fixed; margin: 0px; z-index: 1031; bottom: 60px; right: 20px;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-check'></i> " . $success . "</div>";
            $this->session->unset_userdata('success');
        } elseif (!empty($exception)) {
            echo "<div class='col-xs-6 col-sm-6 col-md-2 alert bootstrap-growl-bottom-right alert-warning' id='message_box' style='position: fixed; margin: 0px; z-index: 1031; bottom: 60px; right: 20px;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><i class='icon fa fa-warning'></i>" . $exception . "</div>";
            $this->session->unset_userdata('exception');
        }
        ?>
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?php echo base_url(); ?>assets/backend/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="<?php echo base_url(); ?>assets/backend/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- date-range-picker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/backend/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="<?php echo base_url(); ?>assets/backend/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/backend/dist/js/app.min.js"></script>
        <!-- CK Editor -->
    <?php 
    /*
        <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
         */ 
    ?>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 
        <!-- For custom allert box -->
        <script src="<?php echo base_url(); ?>assets/backend/custom/js/custom_allert_box/jquery.confirm.js"></script>
        <script src="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
        <!--
        <script src="<?php echo base_url(); ?>assets/backend/plugins/validation/jquery-1.9.1.js"></script>
    -->     
    <script src="<?php echo base_url(); ?>assets/backend/plugins/validation/jquery.validate.min.js"></script> 
    <!-- validation -->
    <!-- geo-address -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQbRQP-Y2V1k4H_1PjzvHjsIIWGpmwsPs&sensor&libraries=places&callback=initMap"
    async defer></script>
    <input type="hidden" id="googleidsearch" value="">
    <script> 
    $(document).ready(function(){ 
    $(".geo-address").one("keyup", function() { 
      $("#googleidsearch").val(this.id);
      initMap();
    });
  });
     var map, places, infoWindow;
     var markers = [];
     var autocomplete;
     var countryRestrict = {'country': 'us'};
     var MARKER_PATH = 'https://developers.google.com/maps/documentation/javascript/images/marker_green';
     var hostnameRegexp = new RegExp('^https?://.+?/');
     var countries = {
        'us': {
          center: {lat: 37.1, lng: -95.7},
          zoom: 3
      },
  };
  function initMap() {
   /* document.getElementById('autocomplete')) */
   var idsearch=document.getElementById('googleidsearch').value; 
   autocomplete = new google.maps.places.Autocomplete(
       (
          document.getElementById(''+idsearch+'')), {
         /*  types: ['(cities)'], */
          componentRestrictions: countryRestrict
      });  
}
function search() {
    var search = {
      bounds: map.getBounds(),
      types: ['lodging']
  };
  places.nearbySearch(search, function(results, status) {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        clearResults();
        clearMarkers();
        for (var i = 0; i < results.length; i++) {
          var markerLetter = String.fromCharCode('A'.charCodeAt(0) + (i % 26));
          var markerIcon = MARKER_PATH + markerLetter + '.png';
          markers[i] = new google.maps.Marker({
            position: results[i].geometry.location,
            animation: google.maps.Animation.DROP,
            icon: markerIcon
        });
          markers[i].placeResult = results[i];
          google.maps.event.addListener(markers[i], 'click', showInfoWindow);
          setTimeout(dropMarker(i), i * 100);
          addResult(results[i], i);
      }
  }
});
}
function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
      if (markers[i]) {
        markers[i].setMap(null);
    }
}
markers = [];
}
function setAutocompleteCountry() {
    var country = document.getElementById('country').value;
    if (country == 'all') {
      autocomplete.setComponentRestrictions({'country': []});
      map.setCenter({lat: 15, lng: 0});
      map.setZoom(2);
  } else {
      autocomplete.setComponentRestrictions({'country': country});
      map.setCenter(countries[country].center);
      map.setZoom(countries[country].zoom);
  }
} 
</script>
<!-- geo-address -->
<script>
 $(".form-validation").validate({ 
 }); 
 $(".form-validation-event").validate({  
     rules: { 
         end_date: {
            required: function(elem)
            {      
                if($('input[name="recurring"]:checked')){
                    return true;
                }else{
                    return false;
                } 
            }  
        },
    },
    messages: { 
     end_date: {
        required: "This field is required.", 
    }, 
}
}); 
</script>
<!-- validation -->
<script>
    $(".check_delete").confirm({
        title: "<i class='fa fa-warning'></i> Delete confirmation !",
        text: "Are you really sure, you want to delete this ?",
        confirmButton: "<i class='fa fa-check'></i> Ok",
        cancelButton: "<i class='fa fa-remove'></i> Cancel",
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-danger"
    });
</script>
<!-- For fadeout notifications -->
<script>
    $(document).ready(function () {
        $("#message_box").fadeOut(4000);
    });
</script>
<!-- For DataTable -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
        });
    });
    $(function () {
        $( ".tagsinput,.bootstrap-tagsinput input" ).keyup(function() {  
         $(this).parents('.c-p-related').find('.tags-btn').html('<div class="selectize-dropdown form-control tag-input multi plugin-remove_button" style= > <div class="selectize-dropdown-content"> <div data-selectable="" class="create">Add keyword <strong>'+$(this).val()+'</strong>…</div> </div> </div>');
     });
        $( ".tagsinput,.bootstrap-tagsinput input" ).focusout(function() {
         $(this).parents('.c-p-related').find('.tags-btn').html('');
     });
    });
</script>
<!-- For Date Picker -->
<script>
    /* format: "yyyy-mm-dd" */
    $(function () {
                //Initialize Select2 Elements
                $(".select2").select2();
                //Date picker
                $('#datepicker,.datepicker').datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd"
                });
                //Date picker
                $('#datepicker2,.datepicker2').datepicker({
                    autoclose: true,
                    format: "yyyy-mm-dd"
                });
            });
        </script>
        <!-- For Editor -->
        <script>
            $(function () {
               if($('#editor1').length){
                CKEDITOR.replace('editor1'); 
                $(".textarea").wysihtml5();
            }
        });
    /*
    $(function () {
               if($('#description').length){ 
        CKEDITOR.replace( 'description', {
        filebrowserUploadUrl: "<?php echo base_url(); ?>upload/upload.php" 
        } );
        $(".textarea").wysihtml5(); 
            }
        });
    */
    /*
    $(function () {
               if($('#content').length){ 
        CKEDITOR.replace( 'content', {
        filebrowserUploadUrl: "<?php echo base_url(); ?>upload/upload.php" 
        } );
        $(".textarea").wysihtml5(); 
            }
        });
    */
    </script>
  <!--
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>
   -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
   <script>
      $('#content').summernote({
        placeholder : "Content",
        tabsize: 2,
        height: 800, 
      }); 
    $('#content_message').summernote({
        placeholder : "Content",
        tabsize: 2,
        height: 400, 
      }); 
    </script>
    <script>
    /*
        $(function () {
            if($('#editor1').length){
                CKEDITOR.replace('editor2');                
                $(".textarea").wysihtml5();
            }
        });
    */
    </script>
    <script>
        function easyFriendlyUrl(strToReplace, target) {
         var strToReplace=strToReplace.toString()
         .normalize('NFD')                
         .replace(/[\u0300-\u036f]/g,'') 
         .replace(/\s+/g,'-')            
         .toLowerCase()                  
         .replace(/&/g,'-and-')          
         .replace(/[^a-z0-9\-]/g,'')   
         .replace(/-+/g,'-')              
         .replace(/^-*/,'')              
         .replace(/-*$/,'');   
         document.getElementById(target).value = strToReplace.toLowerCase(); 
     }
   function easyFriendlyUrl_2(strToReplace, target) {
         var strToReplace=strToReplace.toString()
         .normalize('NFD')                
         .replace(/[\u0300-\u036f]/g,'') 
         .replace(/\s+/g,'-')            
         .toLowerCase()                  
         .replace(/&/g,'-and-')          
         .replace(/[^a-z0-9\-]/g,'')   
         .replace(/-+/g,'-')              
         .replace(/^-*/,'')              
         .replace(/-*$/,'');   
         var val=document.getElementById(target).value;
     if(val==""){
     document.getElementById(target).value = strToReplace.toLowerCase(); 
     }
     }
 </script>
<script src="https://farbelous.io/bootstrap-colorpicker/v2/dist/js/bootstrap-colorpicker.js"></script> 
<link href="https://farbelous.io/bootstrap-colorpicker/v2/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<script>
$(function() {
$('#cp2').colorpicker({
format: "hex",
});
$('#cp1').colorpicker({
format: "hex",
});
});
function imgdel_S3(id,imgname){ 
    /* $('#ajaximg_'+id+'').hide('slow');
    $('#ajaxinput_'+id+'').remove();
    $('#ajaxurl_'+id+'').remove();  */
  var form_data = new FormData();                  
      form_data.append('id', id);
    form_data.append('imgname', imgname);
  /* 
  alert(id);
  alert(imgname); 
  */
  $('#ajaximg_'+id+'').hide('slow');
    $('#ajaxinput_'+id+'').remove();
    $('#ajaxurl_'+id+'').remove(); 
      $.ajax({
        url: '<?php echo base_url('ajax/remove_image'); ?>', 
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){   
      }
    }); 
  }
 $(function() { 
  $(document).on("change", '.col-is-featured', function() {
    var variable = $('input[name=gallery_featured]:checked').val(); 
    if (typeof variable  != 'undefined') {
      $('.col-is-featured').prop('checked', false);
      $(this).prop('checked', true);
    }
  })
}); 
</script>
</body>
</html> 