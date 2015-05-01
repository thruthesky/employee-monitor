#!/bin/php
<?php

date_default_timezone_set('Asia/Manila');
foreach( glob( "*.jpg" ) as $file ) {
        $len = strlen($file);

        $username = substr($file, 0, $len - 17);
        $part = substr($file, $len - 16 );


        $stamp = filectime($file);

        $year = date("Y", $stamp);
        $month = date("m", $stamp);
        $day = date("d", $stamp);


        $dir = "$username/$year/$month/$day";
        $filename = substr($part, 8);

        @mkdir($dir, 0777, true);
        rename($file,"$dir/$filename");

//      echo "$dir/$filename\n";
}
