<?php
/**
 *
 *
 */
//==============================================================================
/*

    Default Settings.

*/
// $username = "jaehosong";            // Computer Owner Name. You must change it every computer.
date_default_timezone_set( 'Asia/Manila' );

$username = gethostname();


//
$ymdhi = date("YmdHi");             // Time. (yymmddhhii). It is part of file name.
$image_quality = 30;                // jpg image quality. 100 is the beste.
$filename = "{$username}_{$ymdhi}.jpg";


// FTP Server Info
$ftp_server = "dev.withcenter.com";
$ftp_id = "dev";
$ftp_password = "xpmwcinc*00";
$ftp_data_folder = "www/employee";





/** Save it in local computer
 *
 *
 *
 */
$im = imagegrabscreen();
$src = tempnam(sys_get_temp_dir(), $filename);
imagejpeg($im, $src, $image_quality);
log_message("Image captured: $src");





/** Upload it to server
 *
 *
 *
 *
 */
$dst = "$filename";
// FTP connect
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_id, $ftp_password);


// passive mode
ftp_pasv($conn_id, true);

// check connection
if ((!$conn_id) || (!$login_result)) { 
	log_message("ERROR: failed on connection");
} else {
	
    // connection Success
	log_message("Connected to the ftp server");
	
	// try to change the directory to somedir
	if (ftp_chdir($conn_id, $ftp_data_folder)) {
		log_message("Current directory is now: " . ftp_pwd($conn_id));
	} else {
		log_message("ERROR: Couldn't change directory : $ftp_data_folder");
		return;
	}

	
	//
    $upload = ftp_put($conn_id, $dst, $src, FTP_BINARY);
	
    // check upload status
    if (!$upload) { 
        // failed
        log_message("Failed upload: $dst");
    } else {
        // success
        log_message("Success upload: $dst");
    }
    ftp_close($conn_id);
}



function log_message($content)
{
	$filename = "sc.log";
	if (!$handle = fopen($filename, 'a')) {
		return false;
	}
	
	if (fwrite($handle, $content . "\n") === FALSE) {
		return false;
	}
	fclose($handle);
	return true;
}
