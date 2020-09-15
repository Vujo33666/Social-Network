<?php
include("includes/header.php");

if(isset($_POST['post'])){
	$post = new Post($con,$userLoggedIn);
	$post->submitPost($_POST['post_text'],'none');
}
?>
	<div class="user_details column">
		
		<a href="<?php echo $userLoggedIn; ?>"> <img class="profile_img" src="<?php echo $user['profile_pic'];?>" height= "150px"
	width="150px";> </a>

		<div class="user_details_left_right">

			<a href="<?php echo $userLoggedIn; ?>">
				<?php 
					echo $user['first_name']." " . $user['last_name'];
				?>
			</a>
			<?php
				echo "Posts: " . $user['num_posts'] . "<br>";
				echo "Likes: " . $user['num_likes'];
			?>
		</div>
	</div>

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>
		</form>

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
	</div>

	<script> //provjerava dokle imamo objava objavljenih
		var userLoggedIn = '<?php echo $userLoggedIn; ?>';

		$(document).ready(function() {
			$('#loading').show();

			//original ajax request for loading first posts
			$.ajax({
				url:"includes/handlers/ajax_load_posts.php",
				type: "POST",
				data: "page=1&userLoggedIn=" + userLoggedIn,
				cache:false,

				success: function(data){
					$('#loading').hide();
					$('.posts_area').html(data);
				}
			});

			$(window).scroll(function() {
				var height= $('.posts_area').height(); //div containing posts
				var scroll_top = $(this).scrollTop();
				var page = $('.posts_area').find('.nextPage').val();
				var noMorePosts = $('.posts_area').find('.noMorePosts').val();

				if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts =='false') {
					$('#loading').show();

					var ajaxReq=$.ajax({
						url:"includes/handlers/ajax_load_posts.php",
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
						cache:false,

						success: function(response){
							$('.posts_area').find('.nextPage').remove(); //removes current .nextpage
							$('.posts_area').find('.noMorePosts').remove(); //removes current .nomoreposts
							$('#loading').hide();
							$('.posts_area').append(response);
						}
					});
				}

				return false;
			});
		});
	</script>
	</div>  <!--closing tag od posljednjeg diva iz headera-->
  </body>
</html>
