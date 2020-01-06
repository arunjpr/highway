    <!DOCTYPE html>  
    <html lang="en">  
    <head>  
        <meta charset="utf-8">  
        <title>User view</title>  
    </head>  
    <body>  
        <h1>User</h1>  
          
        <?php  
        
        //echo '<pre>' ;print_r($user_array);die;
       
       foreach ($user_array as $object) {
           echo $object->Role_Id . "<br>";
           echo $object->Name . "<br>";
           echo $object->Email . "<br>";
           echo $object->Mobile . "<br>";
           echo $object->Password . "<br>";
       }
      
        ?>  
    </body>  
    </html>  