<?php
/**
 *
 * @file sc.php
 * @desc
 *		This is a screen capture php script.
 * @date last updated May 20, 2015 by Song JaeHo - Changed FTP to SFTP.
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
$dst = "www/employee/$filename";
// FTP connect
//$conn_id = ftp_connect($ftp_server);
//$login_result = ftp_login($conn_id, $ftp_id, $ftp_password);

// SFTP connection
$conn = ssh2_connect($ftp_server, 22);
if ( ! $conn ) { log_message("ERROR: ssh2_connect() failed"); exit; }
else log_message("ssh2_connect() : success");

$login_result = ssh2_auth_password($conn, $ftp_id, $ftp_password);
if ( ! $login_result ) {  log_message("ERROR: ssh2_auth_password() failed"); exit; }
else log_message("ssh2_auth_password() : success");



ssh2_scp_send($conn, $src, $dst, 0644);
if ( ! $login_result ) {  log_message("ERROR: ssh2_scp_send() failed"); exit; }
else log_message("ssh2_scp_send() : success");











function log_message($content)
{
	$filename = "sc.log";
	if (!$handle = fopen($filename, 'a')) {
		return false;
	}
	
	$content .= "\r\n";
	if (fwrite($handle, $content) === FALSE) {
		return false;
	}
	fclose($handle);
	return true;
}
