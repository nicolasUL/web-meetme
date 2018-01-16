<?php
//Default to English
$locale = 'en_US';

//$languages = ($_SERVER['HTTP_ACCEPT_LANGUAGE']);
//$languages = str_replace( ' ', '', $languages );
//$languages = str_replace( '-', '_', $languages );
//$languages = explode( ",", $languages );

$languages = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);

//print "Locales = ";
//print_r($languages);
//print " <br>";

/*foreach ( $languages as $temp) {
	$temp = substr($temp,0,5);

	$trans = './locale/'.$temp.'/LC_MESSAGES/messages.mo';

	//print "Looking for locale in $trans <br>";
	if ( ($temp == "en_us") || file_exists($trans)) {
		$locale = $temp;
		//break;
	}

}*/

if ( $languages == "fr") $languages = "fr_FR";


$trans = './locale/'.$languages.'/LC_MESSAGES/messages.mo';

//print "Looking for locale in $trans <br>";
if ( ($languages == "en_us") || ($languages == "fr_FR") || file_exists($trans)) {
	$locale = $languages;
}


setlocale(LC_ALL, $locale);

// Specify location of translation tables
bindtextdomain("messages", "./locale");

// Choose domain
textdomain("messages");
//echo $locale;
?>
