<?php
 
// Path to move uploaded files
$target_path = "uploads/";
 
// array for final json respone
$response = array();
 
// getting server ip address
$server_ip = gethostbyname(gethostname());

// getting client ip address
$client_ip = get_client_ip();
$client_ip = str_replace(".","",$client_ip);
$ext = "jpg";
 
// final file url that is being uploaded
$file_upload_url = 'http://' . $server_ip . '/' . 'AndroidFileUpload' . '/' . $target_path;
 
 
if (isset($_FILES['image']['name'])) {
	//$target_path = $target_path . basename($_FILES['image']['name']);
    $target_path = $target_path . $client_ip . "." . $ext;
 
    // reading other post parameters
	// $email = isset($_POST['email']) ? $_POST['email'] : '';
    // $website = isset($_POST['website']) ? $_POST['website'] : '';
 
     $response['file_name'] = basename($_FILES['image']['name']);
	// $response['email'] = $email;
    //$response['website'] = $website;
 
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
			echo json_encode($response);
        }
 
        // File successfully uploaded
        //$response['message'] = 'File uploaded successfully!';
        //$response['error'] = false;
        //$response['file_path'] = $file_upload_url . basename($_FILES['image']['name']);
    } catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
		echo json_encode($response);
    }
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
	echo $response;
}
 
// Echo final json response to client
//echo json_encode($response);



//$command = "sudo -u www-data python label.py /var/www/html/AndroidFileUpload/uploads/" . $client_ip.".".$ext;
$command = "sudo -u www-data python proc.py /var/www/html/AndroidFileUpload/uploads/" . $client_ip.".".$ext . "  2>&1";
$output = exec($command);

echo $output;
//echo "95% original";

//echo $output;



// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
