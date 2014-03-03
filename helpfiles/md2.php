<?php
spl_autoload_register(function($class){
	require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});
# Get Markdown class
use \Michelf\Markdown;


$file = $_FILES['md']['tmp_name'];
$css = $_POST['css'];
if ($css == 'no'){
// no direct access
echo "<?php defined('_JEXEC') or die; ?>\n";
}
if ($css == 'yes'):
?>
<!DOCTYPE html>
<head>
    <title>Filelinks plugin help</title>
    <style>
        /* Basic styles */
        html {
            margin: 5px;
        }

        body {
            font-family: sans-serif;
            font-size: 76%;
            line-height: 1.3em;
        }

        pre {
            font-size: 110%;
        }

        a {
            text-decoration: none;
            color: #d33930
        }

        a:hover {
            text-decoration: underline;
        }

        b {
            color: #303030;
        }

        .typewriter, .typewriterb {
            font-family: monospace;
            font-size: 120%
        }

        .typewriterb {
            font-weight: bold
        }

        h1 {
            color: #002bb8;
            margin: 15px 0 8px 0;
            font-size: 180%;
        }

        h2 {
            color: #002bb8;
            margin: 15px 0 8px 0;
            font-size: 130%;
        }

        h3 {
            color: #002ba8;
            margin: 15px 0 8px 0;
            font-size: 115%;
        }

        h4 {
            color: #002b98;
            margin: 15px 0 8px 0;
        }

        /* General list styles */
        ol {
            list-style-type: decimal;
            margin: 5px 0 20px 50px;
        }

        ol li {
            padding-bottom: 5px;
        }

        ul {
            list-style-type: square;
            margin: 15px 0 20px 30px;
        }

        ul ul {
            list-style-type: circle;
            margin: 10px 0 20px 30px;
        }

        ul ul li {
            padding-bottom: 5px;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<?php
endif;

$text = file_get_contents($file);
$html = Markdown::defaultTransform($text);

$html = preg_replace ('#(<img.*?)</p>#s','</p>$1',$html);
$html = str_replace('<img src="/com_filelinks_j25/media/help/','<img src="<?php echo JURI::root();?>media/com_filelinks/help/',$html);
$html = str_replace('<p></p>','<p>&nbsp;</p>',$html);
echo str_replace('<h1>','<h1 style="margin-left:0">',$html);
if ($css =='yes'): 
?>
</body>
</html>
<?php 
endif;