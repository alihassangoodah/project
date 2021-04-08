<?php
    
                       //path to file connect into data base 
                        include '../../connect.php';
         

    $fname                =$_POST['register_Fname'];
    $lname                =$_POST['register_Lname'];
    $email                =$_POST['register_email'];
    $password             =$_POST['register_password'];
    $confirm_password     =$_POST['register_password_confirm'];
    $hashed               =md5($password);
    $fnamecount = mb_strlen($fname ,'utf-8');
    $lnamecount = mb_strlen($lname ,'utf-8');
    $passcount = mb_strlen($password ,'utf-8');
    
    $verfication_code=rand('10000','100000');
   // $header='From:<3amleh@website.com >'."\r\n"
   //        'Content-type: text/html; charset=utf-8';
    
    $message_verfication='
                                 <html>
                                 <head>
                                 </head>
                                 <body>

                                 <h3> مرحبا بك'.$fname.'      </h3>
                                 <h3 style="text_align:center">   رمز التحقق الخاص بك هو   :   </h3>
                                 <h3 style="text_align:center">   '.$verfication_code.'   </h3>

                                 </body>
                                 </html>
                        ';
                        
    
   $stmt=$con->prepare("SELECT email FROM users WHERE email = ?");
   $stmt->execute([$email]);
   $Count=$stmt->rowCount();

   $Errors = array();
   if($password !== $confirm_password){
       $Errors[]='كلمه المرور غير متطابقتين';
   }
   if($Count > 0 ){
       $Errors[]='هذا البريد مسجل من قبل شخص آخر';
   }

   if($fnamecount < 3 ){
       $Errors[]='لا يُسمح بأن يكون الاسم الأول قصيرًا جدًا';
   }

   if($lnamecount < 3 ){
       $Errors[]='لا يُسمح بأن يكون اسم العائلة   قصيرًا جدًا';
   }

   if(!filter_var($email,FILTER_VALIDATE_EMAIL) ){
       $Errors[]='هذا البريد الالكترونى غير صالح';
   }

   if($passcount < 6 ){
       $Errors[]='الحد الادنى للباسورد 6 احرف';
   }


   if(empty($Errors)){
        $stmt=$con->prepare("insert into users(fname,lname,email,password) values (?,?,?,?) ");

        $stmt->execute([$fname,$lname,$email,$hashed]);
       
        mail($email,'كود التحقق',$message_verfication);
       
   } else { foreach($Errors as $error){?>

   <div class="alert alert-danger text-center"> <?php echo $error; ?> </div> 
       
   <?php }}
              
   
    
       
       

    

