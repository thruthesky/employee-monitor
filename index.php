<?php
echo "<h1>Employee Screenshot Monitoring</h1>";
echo "<div class='menu'><a href='./'>HOME</a></div>";
        foreach( glob('*', GLOB_ONLYDIR) as $dir ) {
                echo "<a href='./?dir=$dir'>$dir</a><br>";
        }
echo "<hr>";

if ( $_GET['dir'] ) {
        $dir = $_GET['dir'] . '/*';
}
else {
        $dir = '*';
}

echo "<div class='images'>";

$arr = explode('/', $dir);
if ( count($arr) == 5 ) {
        foreach( glob("$dir.jpg") as $file ) {
                $dt = date("Y-M-d h:i a", filectime($file));
                echo "
                                <a href='$file' target='_blank'>
                                        <img src='$file'>
                                        $dt
                                </a>
                        ";
        }
}
else {
        foreach( glob($dir, GLOB_ONLYDIR) as $dir ) {
                echo "<a href='./?dir=$dir'>$dir</a><br>";
        }
}
?>
</div>
<style>
        .images a {
                display:block;
                float:left;
                width:400px;
                text-align:center;
                margin-bottom:1em;
        }
        .images a img {
                width:100%;
                height:auto;
        }
</style>
