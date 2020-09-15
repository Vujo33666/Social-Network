<?php
//Declaring variables to prevent errors
$fname=""; //First name
$lname=""; //Last name
$em=""; //email
$em2=""; //email2
$password=""; //password
$password2=""; //password2
$date=""; //sign up date
$error_array=array(); // holds error messages

if(isset($_POST['register_button'])){  //checking that value is not null
	//Registration form values

	//First name
	$fname=strip_tags($_POST['reg_fname']); //Remove html tags
	$fname=str_replace(' ','',$fname);  //remove spaces
	$fname=ucfirst(strtolower($fname)); //sve changea u lowercase slova pa prebaciva prvo u veliko
	$_SESSION['reg_fname']=$fname; //stores first name into session variable

	//Last name
	$lname=strip_tags($_POST['reg_lname']); //Remove html tags
	$lname=str_replace(' ','',$lname);  //remove spaces
	$lname=ucfirst(strtolower($lname)); //sve changea u lowercase slova pa prebaciva prvo u veliko
	$_SESSION['reg_lname']=$lname; //stores last name into session variable


	//Email
	$em=strip_tags($_POST['reg_email']); //Remove html tags
	$em=str_replace(' ','',$em);  //remove spaces
	$em =strtolower($em); //sve changea u lowercase slova pa prebaciva prvo u velko
	$_SESSION['re_email']=$em; //stores email into session variable

	//Email2
	$em2=strip_tags($_POST['reg_email2']); //Remove html tags
	$em2=str_replace(' ','',$em2);  //remove spaces
	$em2=strtolower($em2); //sve changea u lowercase slova pa prebaciva prvo u veliko
	$_SESSION['reg_email2']=$em2; //sttores email2 into session variable

	//Password
	$password=strip_tags($_POST['reg_password']); //Remove html tags
	$password2=strip_tags($_POST['reg_password2']);

	//Date
	$date=date("Y-m-d"); // trenutni datum sign up-a
    
    if($em==$em2){
    	/*if(filter_var($em,FILTER_VALDATE_EMAIL)) {  //hmm nece mi iz nekog razloga
    		$em=filter_var($em,FILTER_VALIDATE_EMAIL);

    		//Check if email exists
    		$e_check=mysqli_query($con,"SELECT email FROM users WHERE email='$em'");

    		//Count the number of rows returned
    		$num_rows=mysqli_num_rows($e_check);

    		if($num_rows>0){
    			echo "Email already in use"; //tj upotrebljavat: array_push($error_array, "Email already in use<br>");
    		}
   		}
    	else{
    			echo "Invalid format"; //array_push($error_array, "Invalid email format<br>");
   		}*/  //MORAM PRONACI ZAMJENU ZA FILTER VALIDATE u novoj verziji php-a
    }
    else{
    	array_push($error_array, "Emails don't match<br>"); //echo "Email don't match";
	}

	//Validating other data
	if(strlen($fname)>25 || strlen($fname)<2){
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname)>25 || strlen($lname)<2){
		array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
	}

	if($password != $password2){
		array_push($error_array, "Your passwords don't match<br>");
	}
	else{
		if(preg_match('/[^A-Za-z0-9]/', $password)){
			array_push($error_array, "Your password can only contain numbers and english characters<br>");
		}
	}

	if(strlen($password)>30 || strlen($password)<5){
		array_push($error_array, "Your password must be between 5 and 30 characters<br>");
	}

	if(empty($error_array)) {
		$password =md5($password); //encrypt password before sending to database with md5 hash generator

		//generate username by concatenating first name and last name
		$username=strtolower($fname . "_" . $lname);
		$check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");

		$i=0;
		//if username exists add number to username
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++;
			$username = $username . "_" . $i;
			$check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
		}


		//profile picture assignment
	    $rand=rand(1,4); //randomiranje izmedu ova dva broja

	    if($rand==1)
			$profile_pic="assets/images/profile_pics/defaults/head.png";
	    else if($rand==2)
			$profile_pic="assets/images/profile_pics/defaults/head2.png";
		else if($rand==3)
			$profile_pic="assets/images/profile_pics/defaults/head3.jpg";
		else if($rand==4)
			$profile_pic="assets/images/profile_pics/defaults/head4.jpg";


		$query=mysqli_query($con,"INSERT INTO users VALUES ('', '$fname' , '$lname' , '$username' , '$em' , '$password' , '$date' , '$profile_pic' , '0' , '0' , 'no' , ',' )");

		if ( false===$query ) {
  			printf("error: %s\n", mysqli_error($con));
		}
		
		array_push($error_array, "<span style='color: #14C800;'>You are all set! Go ahead and login!</span><br>");

		//Clear session variables after successfull registration
		$_SESSION['reg_fname']="";
		$_SESSION['reg_lname']="";
		$_SESSION['re_email']="";
		$_SESSION['reg_email2']="";
	}
}

?>