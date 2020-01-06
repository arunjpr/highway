<h1>login form</h1>
    <?php $attributes = array('id'=>'login-form','class' => 'form_horizontal'); ?>
    <?php echo form_open('users/login',$attributes);?>

 <div class="form-group">
  <?php echo form_label('username');?>
    <?php
    $data = array(
      'class'=>'form_control',
      'name'=>'username',
      'placeholder'=>'Enter Name',
    )
    ?>
  <?php echo form_input($data);?>
  </div>
 <div class="form-group">
  <?php echo form_label('password');?>
     
  <?php
    $datpass = array(
      'class'=>'form_control',
      'password'=>'password',
      'placeholder'=>'Enter Password',
    )
?>
  <?php echo form_password($datpass);?>
  </div>
    
    
  <div class="form-group">
  <?php
    $datasubmit = array(
      'class'=>'btn btn-primary',
      'name'=>'submit',
      'value'=>'login',
    )
?>
  <?php echo form_submit($datasubmit);?>
  </div>