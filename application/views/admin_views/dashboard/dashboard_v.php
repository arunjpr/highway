<?php

defined('BASEPATH') OR exit('No direct script access allowed');

?>
<style>
    .col-md-3 {
    width: 22%;
}
.container-fluid {
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
}
.media {
    
    margin-bottom: -7px;
}
.gradient-1:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-2:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-3:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
.gradient-4:hover{ box-shadow: 0 8px 16px 0 rgba(0,0,0,2);}
</style>

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>
      Dashboard
  </h1>

  <ol class="breadcrumb">

    <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

    <li class="active">Dashboard</li>

  </ol>

</section>

<!-- Main content -->

<section class="content">

  <!-- Small boxes (Stat box) -->
  
<div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <div class="card-body">
                                 <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $upcoming; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Upcoming Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                            </div>
                            
                           <a href="">
                           <div class="card gradient-1"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a href="<?php echo base_url('admin/trip/trip_by_status/1'); ?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;" class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                        
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $ongoing; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Ongoing Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-2"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a href="<?php echo base_url("admin/trip/trip_by_status/2")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $completed; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Completed Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-3"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                   <a href="<?php echo base_url('admin/trip/trip_by_status/3')?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                            <div class="card-body">
                                 <div class="d-inline-block">
                                    <h2 style="font-weight: bold;font-size: 30px;" class="text-white"><?php echo $cancel; ?></h2>
                                    <p style="font-weight: bold;" class="text-white mb-0">Cancel Trip</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                            </div>
                            <a href="">
                           <div class="card gradient-4"> 
                            <div style="height:20px; color:white; padding: 6px 17px 27px;" class="card-body">
                                 <div class="d-inline-block">
                                     <a href="<?php echo base_url("admin/trip/trip_by_status/4")?>"><p> View All<i style="    margin-left: 135px; font-weight: bold;"  class="fa fa-angle-right"></i></p></a>
                                </div>
                               
                            </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
  
  <!-------------------------->

  <div class="row">
 <div class="col-md-6 col-md-12">
                            <div class="card">
                                <div style="padding-bottom: 59px;" class="card-body">
                                    <h4 class="card-title">Order Summary</h4>
                                    <div id="morris-bar-chart" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        <svg height="342" width="100%" version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.953125px; top: -0.46875px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.859375" y="303" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#000000" d="M45.359375,303H425.094" stroke-opacity="0" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="233.5" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text><path fill="none" stroke="#000000" d="M45.359375,233.5H425.094" stroke-opacity="0" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="164" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><path fill="none" stroke="#000000" d="M45.359375,164H425.094" stroke-opacity="0" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="94.50000000000003" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4.000000000000028" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><path fill="none" stroke="#000000" d="M45.359375,94.50000000000003H425.094" stroke-opacity="0" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><path fill="none" stroke="#000000" d="M45.359375,25H425.094" stroke-opacity="0" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="397.9700982142857" y="315.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2022</tspan></text><text x="289.4744910714286" y="315.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2020</tspan></text><text x="180.97888392857143" y="315.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2018</tspan></text><text x="72.48327678571428" y="315.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2016</tspan></text><rect x="52.14035044642857" y="25" width="11.561950892857142" height="278" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="66.70230133928571" y="52.80000000000001" width="11.561950892857142" height="250.2" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="106.38815401785713" y="94.50000000000003" width="11.561950892857142" height="208.49999999999997" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="120.95010491071427" y="122.30000000000001" width="11.561950892857142" height="180.7" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="160.63595758928568" y="164" width="11.561950892857142" height="139" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="175.19790848214282" y="191.8" width="11.561950892857142" height="111.19999999999999" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="214.8837611607143" y="94.50000000000003" width="11.561950892857142" height="208.49999999999997" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="229.44571205357144" y="122.30000000000001" width="11.561950892857142" height="180.7" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="269.1315647321428" y="164" width="11.561950892857142" height="139" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="283.693515625" y="191.8" width="11.561950892857142" height="111.19999999999999" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="323.3793683035714" y="94.50000000000003" width="11.561950892857142" height="208.49999999999997" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="337.9413191964286" y="122.30000000000001" width="11.561950892857142" height="180.7" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="377.627171875" y="25" width="11.561950892857142" height="278" rx="0" ry="0" fill="#fc6c8e" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="392.18912276785716" y="52.80000000000001" width="11.561950892857142" height="250.2" rx="0" ry="0" fill="#7571f9" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect></svg><div class="morris-hover morris-default-style" style="left: 248.615px; top: 117px; display: none;"><div class="morris-hover-row-label">2020</div><div class="morris-hover-point" style="color: #FC6C8E">
  A:
  50
</div><div class="morris-hover-point" style="color: #7571f9">
  B:
  40
</div><div class="morris-hover-point" style="color: #FC6C8E">
  C:
  -
</div></div></div>
                                </div>
                            </div>
                            
                        </div>
                        

<div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6">
                        <div  class="card">
                            <div class="card-body">
                                <h4 class="card-title">New User</h4>
                               <a style="float: right;  margin-top: -30px;"  href="admin/customer"> View All</a>
                                <div  class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 390px;overflow: scroll;"><div id="activity" style="overflow: hidden; width: auto; height: 390px;">
                                   <?php
                                   foreach ($customer as $cdata) { ?>
                                    <div class="media border-bottom-1 pt-3 pb-3">
                                        <img width="35" src="<?=$cdata['customerImage']?>" class="mr-3 rounded-circle">
                                        <div class="media-body">
                                            <h5><?=$cdata['Name'];?></h5>
                                            <p class="mb-0"><?=$cdata['Mobile'];?></p>
                                        </div><span class="text-muted "><?=$cdata['created_on'];?></span>
                                    </div>
                                    <?php } ?> 
                                     <br><br>
                                </div>
                                    <div class="slimScrollBar" style="background: transparent; width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 268.728px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                            </div>
                        </div>
                    </div>
                    
  </div>

  <!-- /.row -->

 
 
     </section>

     <!-- /.content -->

 