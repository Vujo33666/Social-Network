<?php 
if(isset($_POST['login_button'])){
	$email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL); // provjera je li email u pravilnom obliku

	$_SESSION['log_email']=$email; // store email into session variable
	$password=md5($_POST['log_password']);  // stavljamo opet md5 enkripciju kako bi provjerili sa vec enkriptiranim passwordom

	$check_database_query=mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
	$check_login_query=mysqli_num_rows($check_database_query);

	if($check_login_query==1){
		$row=mysqli_fetch_array($check_database_query); //podatci iz database querya se spremaju u ovaj array
		$username=$row['username'];  //provjera usernamea

		$user_closed_query = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND user_closed='yes'"); //ukoliko je zatvoren acc , otvaramo ga
		if(mysqli_num_rows($user_closed_query)==1){
			$reopen_account=mysqli_query($con,"UPDATE users SET user_closed='no' WHERE email='$email'");
		}

		$_SESSION['username']=$username;  //spremanje username-a u sesiju , ukoliko je null, nismo logirani i izlazimo iz profila
		ob_start(); //spremamo output u buffer
		header("Location:index.php"); //nakon ovog odlazimo na index.php page
		exit();
	}
	else{
		array_push($error_array, "Email or password was incorrect<br>");
	}
}

?>