<?php

ob_start();
include ('database_connection.php');
if (isset($_POST['formsubmitted'])) {
    // Initialize a session:
session_start();
    $error = array();//this aaray will store all error messages
  

    if (empty($_POST['e-mail'])) {//if the email supplied is empty 
        $error[] = 'You forgot to enter  your Email ';
    } else {


        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['e-mail'])) {
           
            $Email = $_POST['e-mail'];
        } else {
             $error[] = 'Your EMail Address is invalid  ';
        }


    }


    if (empty($_POST['Type'])) {
        $error[] = 'Please select Type ';
    } else {
        $Type = $_POST['Type'];
    }
    
    if (empty($_POST['Password'])) {
        $error[] = 'Please Enter Your Password ';
    } else {
        $Password = $_POST['Password'];
    }


       if (empty($error))//if the array is empty , it means no error found
    { 
        echo "$Type";
       
       if($Type=='Admin')
        {
            $k1=13;
            $k2=13;
            $k3=13;
            //echo "good";
        }
        else if($Type=='Competitor')
        {
            $k1=0;
            $k2=0;
            $k3=0;
            
        }
        else if($Type=='Judge')
        {
            $k1=1;
            $k2=2;
            $k3=3;
        }
        else
        {
            $k1=4;
            $k2=4;
            $k3=4;
        }

        $query_check_credentials = "SELECT * FROM User WHERE (Email='$Email' AND Password='$Password' AND (Permission='$k1' OR Permission='$k2' OR Permission='$k3')) AND Activation IS NULL";
   
        

        $result_check_credentials = mysqli_query($dbc, $query_check_credentials);
        if(!$result_check_credentials){//If the QUery Failed 
            echo 'Query Failed ';
        }

        if (@mysqli_num_rows($result_check_credentials) == 1)//if Query is successfull 
        { // A match was made.

           
            $_SESSION = mysqli_fetch_array($result_check_credentials, MYSQLI_ASSOC);//Assign the result of this query to SESSION Global Variable
            if($_SESSION['Permission']==0)
                header("Location: page.php");
            else if($_SESSION['Permission']==13)
                header("Location: iadmin.php");
            else if($_SESSION['Permission']==4)
                header("Location: ivalid.php");
                //header("Location: validator_page.php");
            else
                header("Location: ijudge.php");
                //header("Location: judge_page.php");
          

        }else
        { 
            
            $msg_error= 'Either Your Account is inactive or Email address /Password is Incorrect';
        }

    }  else {
        
        

echo '<div class="errormsgbox"> <ol>';
        foreach ($error as $key => $values) {
            
            echo '	<li>'.$values.'</li>';


       
        }
        echo '</ol></div>';

    }
    
    
    if(isset($msg_error)){
        
        echo '<div class="warning">'.$msg_error.' </div>';
    }
    /// var_dump($error);
    mysqli_close($dbc);

} // End of the main Submit conditional.



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Form</title>


    
    
    
<style type="text/css">
body {
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.registration_form {
	margin:0 auto;
	width:500px;
	padding:14px;
}
label {
	width: 10em;
	float: left;
	margin-right: 0.5em;
	display: block
}
.submit {
	float:right;
}
fieldset {
	background:#EBF4FB none repeat scroll 0 0;
	border:2px solid #B7DDF2;
	width: 500px;
}
legend {
	color: #fff;
	background: #80D3E2;
	border: 1px solid #781351;
	padding: 2px 6px
}
.elements {
	padding:10px;
}
p {
	border-bottom:1px solid #B7DDF2;
	color:#666666;
	font-size:11px;
	margin-bottom:20px;
	padding-bottom:10px;
}
a{
    color:#0099FF;
font-weight:bold;
}

/* Box Style */


 .success, .warning, .errormsgbox, .validation {
	border: 1px solid;
	margin: 0 auto;
	padding:10px 5px 10px 60px;
	background-repeat: no-repeat;
	background-position: 10px center;
     font-weight:bold;
     width:450px;
     
}

.success {
   
	color: #4F8A10;
	background-color: #DFF2BF;
	background-image:url('images/success.png');
}
.warning {

	color: #9F6000;
	background-color: #FEEFB3;
	background-image: url('images/warning.png');
}
.errormsgbox {
 
	color: #D8000C;
	background-color: #FFBABA;
	background-image: url('images/error.png');
	
}
.validation {
 
	color: #D63301;
	background-color: #FFCCBA;
	background-image: url('images/error.png');
}



</style>

</head>
<body>


<form action="login.php" method="post" class="registration_form">
  <fieldset>
    <legend>Login Form  </legend>

    <p>Enter Your username and Password Below  </p>
    
    <div class="elements">
      <label for="name">Email :</label>
      <input type="text" id="e-mail" name="e-mail" size="25" />
    </div>
    <div class="elements">
      <label for="Type">Type :</label>
      <select name="Type">
            <option value="Competitor">Competitor</option>
            <option value="Validator">Validator</option>
            <option value="Judge">Judge</option>
            <option value="Admin">Admin</option>
       </select>
    </div>
    
  
    <div class="elements">
      <label for="Password">Password:</label>
      <input type="password" id="Password" name="Password" size="25" />
    </div>
    <div class="submit">
     <input type="hidden" name="formsubmitted" value="TRUE" />
      <input type="submit" value="Login" />
    </div>
  </fieldset>
</form>
Go Back to <a href="#">Account Verification on sign up</a><br>
Register <a href="index1.php">sign up</a>
</body>
</html>
