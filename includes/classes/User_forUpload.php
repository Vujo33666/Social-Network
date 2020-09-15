<?php 
	class User{
		private $korisnik;
		private $konekcija;

		public function __construct($konekcija,$korisnik){
			$this->konekcija = $konekcija;
			$rezultati_upita=mysqli_query($konekcija,"SELECT * FROM users WHERE username='$korisnik'");
			$this->korisnik=mysqli_fetch_array($rezultati_upita);
		}

		public function getUsername(){
			return $this->korisnik['username'];
		}

		public function getNumberOfFriendRequests(){
			$korisničko_ime=$this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT * FROM friend_requests WHERE user_to='$username'");
			return mysqli_num_rows($upit);
		}

		public function getNumPosts(){
			$korisničko_ime=$this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT num_posts FROM users WHERE username='$username'");
			$red=mysqli_fetch_array($upit);
			return $red['num_posts'];
		}
		public function getFirstAndLastName(){
			$korisničko_ime=$this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT first_name, last_name FROM users WHERE username='$username'");
			$red=mysqli_fetch_array($upit);
			return $red['first_name'] . " " . $red['last_name'];
		}

		public function isClosed(){
			$korisničko_ime = $this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT user_closed FROM users WHERE username='$username'");
			$red=mysqli_fetch_array($upit);

			if($red['user_closed']=='yes')
				return true;
			else
				return false;
		}

		public function isFriend($provjera_korisnika){
			$korisnikZarez="," . $provjera_korisnika . ",";

			if((strstr($this->korisnik['friend_array'], $korisnikZarez) || $provjera_korisnika == $this->korisnik['username'])){
				return true;
			} 
			else{
				return false;
			}
		}

		public function getProfilePic(){
			$korisničko_ime=$this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT profile_pic FROM users WHERE username='$username'");
			$red=mysqli_fetch_array($upit);
			return $red['profile_pic'];
		}

		public function getFriendArray(){
			$korisničko_ime=$this->korisnik['username'];
			$upit=mysqli_query($this->konekcija,"SELECT friend_array FROM users WHERE username='$username'");
			$red=mysqli_fetch_array($upit);
			return $red['friend_array'];
		}

		public function didReceiveRequest($user_from){
			$prema_korisniku=$this->korisnik['username'];
			$provjera_zahtjeva_upit=mysqli_query($this->konekcija,"SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
			if(mysqli_num_rows($provjera_zahtjeva_upit)>0){
				return true;
			}
			else{
				return false;
			}
		}

		public function didSendRequest($za_korisnika){
			$za_korisnika=$this->korisnik['username'];
			$provjera_zahtjeva_upit=mysqli_query($this->konekcija,"SELECT * FROM friend_requests WHERE user_to='$user_to' AND user_from='$user_from'");
			if(mysqli_num_rows($provjera_zahtjeva_upit)>0){
				return true;
			}
			else{
				return false;
			}
		}

		public function removeFriend($korisnik_za_brisanje){
			$prijavljeni_korisnik = $this->korisnik['username'];

			$upit=mysqli_query($this->konekcija,"SELECT friend_array FROM users WHERE username='$user_to_remove'");
			$red=mysqli_fetch_array($upit);
			$niz_prijatelja=$red['friend_array'];

			$novi_niz_prijatelja = str_replace($korisnik_za_brisanje . ",","",$this->korisnik['friend_array']);
			$brisi_prijatelja=mysqli_query($this->konekcija,"UPDATE users SET friend_array='$new_friend_array' WHERE username='$logged_in_user'");

			$novi_niz_prijatelja = str_replace($this->korisnik['friend_array'] . ",","", $niz_prijatelja);
			$brisi_prijatelja=mysqli_query($this->konekcija,"UPDATE users SET friend_array='$new_friend_array' WHERE username='$user_to_remove'");
		}

		public function sendRequest($za_korisnika){
			$za_korisnika = $this->korisnik['username'];
			$upit = mysqli_query($this->konekcija,"INSERT INTO friend_request VALUES('','$user_to','$user_from')");
		}

		public function getMutualFriends($provjera_korisnika){
			$za_korisnika_niz=0;
			$niz_prijatelja=$this->korisnik['friend_array'];
			$niz_prijatelja_explode=explode(",",$niz_prijatelja); //splits array gdje je zarez

			$upit=mysqli_query($this->konekcija, "SELECT friend_array FROM users WHERE username='$user_to_check'");
			$red=mysqli_fetch_array($upit);
			$za_korisnika_niz=$red['friend_array'];
			$za_korisnika_niz_explode=explode(",",$za_korisnika_niz);

			foreach($niz_korisnika_explode as $i){
				foreach($za_korisnika_niz_explode as $j){

					if($i == $j && $i!=""){
						$zajednicki_prijatelji++;
					}
				}
			}

			return $zajednicki_prijatelji;
		}
	}
?>