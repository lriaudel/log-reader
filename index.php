<?php
/***
* Allows you to read the last x lines of a log file
* @author : Ludovic Riaudel <ludovic@riaudel.net>
*
* $filename	url log file
* $maxLineLength	number of line
**/
function read_file_by_the_end( $filename, $maxLineLength = 500) {
	$l = 0;
	$lines = array();
	$fp = fopen($filename, "r");
	
	while(!feof($fp)) 	{
		$l++;
		
		$line['line'] = $l;
		$line['content'] = fgets($fp);
		
		array_push($lines, $line);
		
		if ( count($lines) > $maxLineLength )
			array_shift($lines);
	}
	
	fclose($fp);
	
	return $lines;
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Log Reader</title>
</head>
<body>

<?php
	$debut = microtime(true);
	$lines = read_file_by_the_end('../../../logs/php-error.log', 20);
	$fin = microtime(true);
	$delai = ($fin - $debut);
	echo '<span style="font-size:0.7em;">Le temps de traitement du fichier : '.round($delai).' ms.</span>';
	echo"<br>-------------<br>";
?>

<table style="margin:2em;">
	<thead>
		<tr>
			<th colspan="2" align="left">Ligne</th><th align="left">Log</th>
		</tr>
	</thead>
<?php
// Affiche toutes les lignes du tableau comme code HTML, avec les numéros de ligne
foreach ($lines as $line_num => $line) {
	echo "<tr><td><b>{$line['line']}</b></td><td>&nbsp;&nbsp;</td><td>" . htmlspecialchars($line['content']) . "</td></tr>\n";
}

?>
</table>
	
</body>
</html>
