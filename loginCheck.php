
<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	include("DbCon.php");
	$con=connection();


	$name="";
	$email="";
	
	$phone="";
	$address="";
	$Insert="";
	$pass="";
	$Conform_pass="";
	$matchPass="";
	$msgg="";
	$message="";
	$okFlag=TRUE;

	if(isset($_POST["regisubmit"])){
		 
	 
		if(!isset($_REQUEST["name"]) || $_REQUEST["name"]==''){
			$message="please type your name.";
			$okFlag=FALSE;
		}
		if(!isset($_REQUEST["email"]) || ($_REQUEST["email"])==''){
			$message="please type your email.";
			$okFlag=FALSE;
		}
		if(!isset($_REQUEST['address']) || ($_REQUEST['address'] == '')){
				$message .= 'Please type your address.<br>';
				$okFlag = FALSE;
			}
		if(!isset($_REQUEST['phone']) || ($_REQUEST['phone'] == '')){
				$message .= 'Please type your phone number.<br>';
				$okFlag = FALSE;
			}if(!isset($_REQUEST['pass']) || ($_REQUEST['pass'] == '')){
				$message .= 'Please type your password.<br>';
				$okFlag = FALSE;
			}
		if(isset($_REQUEST["R_pass"]) && (isset($_POST["R_pass"]))){
			
			if($_POST["pass"] != $_POST["R_pass"]){
				$message="password dont match.";
				$okFlag=FALSE;
			}
			
		}
	
	if($okFlag){
		$name=$_REQUEST["name"];
		$email=$_REQUEST["email"];
		$address=$_REQUEST["address"];
		$phone=$_REQUEST["phone"];
		$pass=md5($_REQUEST["pass"]);
		$Conform_pass=md5($_REQUEST["R_pass"]);
		$sql="SELECT * FROM `user` WHERE `email`='$email' ";
		$result = $con->query($sql);
		if($result->num_rows <= 0){
			$sql1 = "INSERT INTO `user`(`name`, `email`, `password`, `phone`, `address`) VALUES ('$name', '$email','$pass','$phone','$address')";
			
			if($con->query($sql1)){
				$_SESSION["msg"]=("registration Successfully done");
				header('location:login.php?msg=Successfully Registered');
			}else{
				$_SESSION["msg"]=("database error");
				header('location:login.php');
				}
		}
		else{
			$_SESSION["msg"]=("Your email already exits");
			header('location:login.php');
			}
		}
		else{
			 $_SESSION["msg"]=$message;
			header('location:login.php');
			}    


	echo($_SESSION["msg"]);
	}
	




	
	$Fname="";
	$Femail="";
	
	$Fphone="";
	$Faddress="";
	$FInsert="";
	$Fpass="";
	$FConform_pass="";
	$FmatchPass="";
	$state="";
	$pincode="";
	$Fmsgg="";
	$Fmessage="";
	$FokFlag=TRUE;

	if(isset($_POST["Fregisubmit"])){
		 
	 
		if(!isset($_REQUEST["Fname"]) || $_REQUEST["Fname"]==''){
			$message="please type your name.";
			$okFlag=FALSE;
		}
		if(!isset($_REQUEST["Femail"]) || ($_REQUEST["Femail"])==''){
			$message="please type your email.";
			$okFlag=FALSE;
		}
		if(!isset($_REQUEST['Faddress']) || ($_REQUEST['Faddress'] == '')){
				$message .= 'Please type your address.<br>';
				$okFlag = FALSE;
			}
		if(!isset($_REQUEST['Fphone']) || ($_REQUEST['Fphone'] == '')){
				$message .= 'Please type your phone number.<br>';
				$okFlag = FALSE;
			}if(!isset($_REQUEST['Fpass']) || ($_REQUEST['Fpass'] == '')){
				$message .= 'Please type your password.<br>';
				$okFlag = FALSE;
			}
		if(isset($_REQUEST["FR_pass"]) && (isset($_POST["FR_pass"]))){
			
			if($_POST["Fpass"] != $_POST["FR_pass"]){
				$message="password dont match.";
				$okFlag=FALSE;
			}
		if(!isset($_REQUEST["state"]) || ($_REQUEST["state"])==''){
				$message="please mention your state.";
				$okFlag=FALSE;
			}
		if(!isset($_REQUEST["pincode"]) || ($_REQUEST["pincode"])==''){
				$message="please type your pincode.";
				$okFlag=FALSE;
			}	
		}
	
	if($okFlag){
		$Fname=$_REQUEST["Fname"];
		$Femail=$_REQUEST["Femail"];
		$Faddress=$_REQUEST["Faddress"];
		$Fphone=$_REQUEST["Fphone"];
		$state=$_REQUEST["state"];
		$pincode=$_REQUEST["pincode"];
		$Fpass=md5($_REQUEST["Fpass"]);
		$FConform_pass=md5($_REQUEST["FR_pass"]);
		$sql="SELECT * FROM `user` WHERE `email`='$Femail' ";
		$result = $con->query($sql);
		if($result->num_rows <= 0){
			$sql1 = "INSERT INTO `farmer`(`name`, `email`, `password`, `phone`, `address`,`state`,`pincode`) 
					VALUES ('$Fname', '$Femail','$Fpass','$Fphone','$Faddress','$state','$pincode')";
			
			if($con->query($sql1)){
				$_SESSION["msg"]=("registration Successfully done");
				header('location:login.php?msg=Successfully Registered');
			}else{
				$_SESSION["msg"]=("database error");
				header('location:login.php');
				}
		}
		else{
			$_SESSION["msg"]=("Your email already exits");
			header('location:login.php');
			}
		}
		else{
			 $_SESSION["msg"]=$message;
			header('location:login.php');
			}    


	echo($_SESSION["msg"]);
	}


	if(isset($_POST["loginSubmit"])){
		$name="";
		$Pass="";
		 
		$right="";
		$Email1="";
		$wrong="";
		$_SESSION["right"]="";
		$_SESSION["isLogedIn"]=false;

			$email=$_POST["username"];
			$Pass=md5($_POST["passsword"]);
	
			
		$sql="SELECT * FROM `user` WHERE email='$email' AND password='$Pass'";
		$query=mysqli_query($con,"$sql");
		 
		$result=$con->query($sql);
		//echo($result->num_rows);

		$sql="SELECT * FROM `farmer` WHERE email='$email' AND password='$Pass'";
		$query=mysqli_query($con,"$sql");
		 
		$result1=$con->query($sql);
		 
		if(($result->num_rows > 0) || ($result1->num_rows > 0)){
				
		 
			foreach($result as $row){
				$_SESSION["username"]=$row["name"];
				$_SESSION["role"]=$row["admin"];
				//echo($_SESSION["Admin"]);exit();
				$_SESSION["useremail"]=$row["email"];
				$_SESSION["userid"]=$row["ID"];
				$active=$row["active"];
			}
			//echo($active);exit();
			if($active==1){
				$_SESSION["wrong"]="you are blocked by admin";
					header('location:login.php');
			}else{
				$_SESSION["right"]="login successfully";
			$_SESSION["isLogedIn"]=true;
			if($_SESSION["role"]==1){
				header('location:admin/report.php');
			}
			if($result->num_rows > 0){
				header('location:index.php');
			}
			if($result1->num_rows > 0){
				//echo('Farmer page');
				header('location:index.php');
			}
			
			}
			
		}
		
		else{
			
			if(!isset($_SESSION["loginChk"])){
				$_SESSION["loginChk"]=0;
			}

			$sql="SELECT * FROM `user` WHERE email='$email'";
			$result=$con->query($sql);

			$sql="SELECT * FROM `farmer` WHERE email='$email'";
			$result1=$con->query($sql);

			if($result->num_rows>=0 || $result1->num_rows>=0){
				foreach($result as $row){
				$Email1=$row["email"];
				$_SESSION["Email"]=$row["email"];
				
			}
			
			
			if($email != $Email1){
					$wrong="Your email is not matched, please register your email or input correctly.<br>";
				$_SESSION["wrong"]=$wrong;
				header('location:login.php');
			
				
			}else{
				$wrong="Password is wrong<br>";
					$_SESSION["wrong"]=$wrong;
					header('location:login.php');
					

					}
			$_SESSION["loginChk"]++;
			}
		 
			}
		echo($_SESSION["right"]);
		 
		echo($wrong);
		 
	
	}



 


?>
 