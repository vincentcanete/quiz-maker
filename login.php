<?php
	require_once dirname(__FILE__) . '/inc/session.php';
	require_once dirname(__FILE__) . '/inc/connection.php';
	require_once dirname(__FILE__) . '/inc/functions.php';
	include dirname(__FILE__) . '/inc/form_functions.php';
	if(logged_in()){
		redirect_to("content.php");
	}
?>
<?php
	
	// START FORM PROCESSING

	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT user_id, name, hash_password ";
			$query .= "FROM users ";
			$query .= "WHERE name = '{$username}' ";
			$query .= "AND hash_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$result_set = mysql_query($query);
			confirm_query($result_set);
			if (mysql_num_rows($result_set) == 1) {
				// username/password authenticated
				// and only 1 match
				$found_user = mysql_fetch_array($result_set);
				$_SESSION['user_id'] = $found_user['user_id'];
				$_SESSION['username'] = $found_user['name'];
				
				redirect_to("content.php");
			} else {
				// username/password combo was not found in the database
				$message = "Username/password does not match!";
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
		
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		$username = "";
		$password = "";
	}

?>
<!DOCTYPE html>
<head>

<title>Quiz Manager | Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link href="css/login-box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<script type="text/javascript">
	
</script>
<body>
	<h2 id="title" style="display:none;">E-Learning Quiz Maker</h2>
	<div id="login-box" style="display: none;">
	<p class="message"><?php if (!empty($message)) {echo $message;} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?></p>
		<form action="" method="post" id="form">
			<div id="login-box-name" style="margin-top:20px;">Username:</div><div id="login-box-field" style="margin-top:20px;"><input type="text" id="username" name="username" class="form-login" title="Username" value="" size="30"/></div>
			<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" id="password" title="Password" value="" size="30"/></div>
			<br />
			<span class="login-box-options"><input type="checkbox" name="1" value="1"> Remember Me</span>
			<br /><br />
			<input type="submit" name="submit" value="Login" style="margin-left:90px;" />
		</form>
	</div>
</body>
	<script type="text/javascript">
		(function(){
			jQuery('h2').fadeIn(1000,function(){
				jQuery('#login-box').slideDown(1000);
			})
		})();
	</script>

	<script type="text/javascript">
var text = document.getElementById('title'),
	body = document.body,
	steps = 7;
function threedee (e) {
	var x = Math.round(steps / (window.innerWidth / 2) * (window.innerWidth / 2 - e.clientX)),
		y = Math.round(steps / (window.innerHeight / 2) * (window.innerHeight / 2 - e.clientY)),
		shadow = '',
		color = 190,
		radius = 3,
		i;	
	for (i=0; i<steps; i++) {
		tx = Math.round(x / steps * i);
		ty = Math.round(y / steps * i);
		if (tx || ty) {
			color -= 3 * i;
			shadow += tx + 'px ' + ty + 'px 0 rgb(' + color + ', ' + color + ', ' + color + '), ';
		}
	}
	shadow += x + 'px ' + y + 'px 1px rgba(0,0,0,.2), ' + x*2 + 'px ' + y*2 + 'px 6px rgba(0,0,0,.3)';	
	text.style.textShadow = shadow;
	text.style.webkitTransform = 'translateZ(0) rotateX(' + y*1.5 + 'deg) rotateY(' + -x*1.5 + 'deg)';
	text.style.MozTransform = 'translateZ(0) rotateX(' + y*1.5 + 'deg) rotateY(' + -x*1.5 + 'deg)';
}
document.addEventListener('mousemove', threedee, false);
</script>

</html>
