<?php 	ob_start();
		require_once dirname(__FILE__) . '/inc/session.php';
	    require_once dirname(__FILE__) . '/inc/connection.php';
	    require_once dirname(__FILE__) . '/inc/functions.php';
	    confirm_logged_in();

	    $grp = "";
	    $count = 0;
	    global $connection;
		$message = $_POST['message'];
		$groups = $_POST['groups'];
		foreach ($groups as $group) {

			if($_POST['user'] == 'group'){
				$query = "SELECT value 
	                      FROM  wpbp_xprofile_data, wpbp_groups, wpbp_groups_members
	                      WHERE wpbp_xprofile_data.field_id = 6
	                      AND wpbp_groups.id = wpbp_groups_members.group_id
	                      AND wpbp_xprofile_data.user_id = wpbp_groups_members.user_id
	                      AND wpbp_groups.id = '$group' GROUP BY value";
	            $result = mysql_query($query,$connection);
	            confirm_query($result);
	            while($row = mysql_fetch_array($result)){
	                 $num = $row['value'];
	                 
	                 $gatewayURL  =   'http://localhost:9333/ozeki?'; 
					  $request = 'login=admin'; 
					  $request .= '&password=abc123'; 
					  $request .= '&action=sendMessage'; 
					  $request .= '&messageType=SMS:TEXT'; 
					  $request .= '&recepient='.urlencode($num); 
					  $request .= '&messageData='.urlencode($message); 
					  $url =  $gatewayURL . $request;  
					  //Open the URL to send the message 
					   file($url); 
	            }
	            if($result){
            		redirect_to("content.php?page=messaging&msg=1");

	            }else{
	            	redirect_to("content.php?page=messaging&msg=0");
	            }

        	}else{
        		$num = $group;
        		$gatewayURL  =  'http://localhost:9333/ozeki?'; 
				$request = 'login=admin'; 
				$request .= '&password=abc123'; 
				$request .= '&action=sendMessage'; 
				$request .= '&messageType=SMS:TEXT'; 
				$request .= '&recepient='.urlencode($num); 
				$request .= '&messageData='.urlencode($message); 
				$url =  $gatewayURL . $request;  
				//Open the URL to send the message 
				file($url);

            	redirect_to("content.php?page=messaging&msg=1");
        	}
		}
		
?>