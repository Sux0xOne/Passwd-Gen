<?php
// Coded by Sux 

		if(isset($_POST['pass']))
		{
			$pass = generateStrongPassword($length = 30, $add_dashes = false, $available_sets = 'luds');
			echo $pass;
			return;
		}
 
function generateStrongPassword($length = 30, $add_dashes = false, $available_sets = 'luds')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '0123456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
 
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
 
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
 
	$password = str_shuffle($password);
 
			$con = mysqli_connect('127.0.0.1', 'root', '', 'karim');				
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
				return;
			}
			$date = date("Y-m-d H:i:s");
			$password = mysqli_real_escape_string($con,$password);

			$insertQuery1 = "INSERT INTO passowrd(`password`, `date`) VALUES ('".$password."','".$date."')";

			if (!mysqli_query($con,$insertQuery1))
		  		{
		//	  		die('Error: ' . mysqli_error($con));
					//echo "This url already inserted ...";
					return;
				}

	if(!$add_dashes)
		return $password;
 
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}

?>
