<?php
/* The purpose of this demo is showing how to use php to grab the image files
 * from a folder to make maintanice easier. to change the images just change
 * the files in the folder.
 * 
 * this demo modifes the code from Uvm Web tools: 
 * http://www.uvm.edu/webguide/tools/?Page=photogallery.html
 * 
 * for this resposive slider the images must be large enough to fit on a full 
 * size screen mine are 1200px wide. smaller images get resized to fit the full
 * window. so a small 400px wide image woudl be stretched to 1200px wide or 
 * whatever the size of the monitor is.
 * 
 * The images are displayed in alphabetical order. you can rename your images to
 * change the order
 * 
 * this folder is where the images are located and it cannot have an index file
 * named index.php or index.html
 * 
 * this does not work on https
 * 
 */

$folder = "images";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JQuery Slider Example</title>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="/www/js/jquery.flexslider-min.js"></script>
        <script type="text/javascript">
            var flexsliderStylesLocation = "/www/css/flexslider.css";
            $('<link rel="stylesheet" type="text/css" href="'+flexsliderStylesLocation+'" >').appendTo("head");
            $(window).load(function() {
          
                $('.flexslider').flexslider({
                    animation: "fade",
                    slideshowSpeed: 3000,
                    animationSpeed: 1000
                });
         
            });
        </script>

    </head>
    <body>
        <!-- Place somewhere in the <body> of your page -->
        <div class="flexslider">
            <ul class="slides">
<?php
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// Automatically set up PATH
//
// $domain = "https://www.uvm.edu" or http://www.uvm.edu;

if ($_SERVER['HTTPS']) {
    $domain = "https://";
    print "<h1>This code does not work on https</h1>";
} else {
    $domain = "http://";
}

$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

$domain .= $server;

$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);

$basePath = $domain . $path_parts['dirname'] . "/";

/*
 * this functions gets a list of all the image files in variable url
 * however the url cannot have an index file
 * 
 */

function getFileList($url) {
    $outputBuffer = array();

    error_reporting(0); //404 reports a warning i dont want
    $var = file_get_contents($url);
    error_reporting(1);

    if ($var != "") {
        preg_match_all("/a[\s]+[^>]*?href[\s]?=[\s\"\']+" .
                "(.*?)[\"\']+.*?>" . "([^<]+|.*?)?<\/a>/", $var, &$matches);

        $matches = $matches[1];

        foreach ($matches as $var) {
            $ext = pathinfo($var, PATHINFO_EXTENSION);
            if ($ext == "jpg" | $ext == "png" | $ext == "gif") {
                $outputBuffer[] = $var;
            }
        }
    }
    return $outputBuffer;
}

$images = getFileList($basePath . $folder);

foreach ($images as $img) {
    echo "\n\t<li>";
    echo "\t\t";
    echo '<img src="' . $folder . '/' . $img . '" alt="" />' . "\n";
    echo "\n\t</li>";
}
?>

            </ul>
        </div>
    </body>
</html>
