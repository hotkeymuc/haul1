<pre>
<?php
/**
 * Static HAL compiler
 *
 * This prgram uses the HTKphpBoot bootstrap compiler to compile the real HTPphp from HAL.
 * It then uses the real HTKphp to compile the shadowrunner.hal to PHP and runs it.
 *
 * 2011-07-31 Bernhard -HotKey- Slawik
 */

function _put($txt) {
	echo $txt."\n";
	flush();
}
function _putR($txt) {
	echo $txt;
}
define('currPlatform', 'PHPboot');


function deploy($fIn, $htk, $fOut) {
	_putR('Compiling "'.$fIn.'" to "'.$fOut.'"...');
	if (is_file($fOut)) unlink($fOut);
	$lines = file($fIn);
	
	$htk->deployStart();
	
	# Bundle resources
	$htk->resourceStart();
	$htk->resourceAdd("htk_php.inc.php", file_get_contents("src.hal/htk_php.inc.php"));
	$htk->resourceEnd();
	
	# Translate the given HAL source code using the given HTK
	$htk->translateLibs();
	$htk->translateStart();
	$i = 0;
	foreach($lines as $line) {
		$i++;
		
		# Count indents and de-indent
		$indents = 0;
		while ((strlen($line) > 0) && (substr($line, 0, 1) == "\t")) {$line = substr($line, 1); $indents++;}
		
		$line = trim($line);
		if (strlen($line) == 0) continue;
		if (substr($line, 0, 1) == "#") continue;
		
		$items = explode("\t", $line."\t\t\t\t\t");
		// Bootstrapping instructions
		switch($items[0]) {
			case "!MERGE":
				global $srcFolder;
				$mergeFilename = $srcFolder.'/'.$items[1];
				_put('Merging source file: "'.$mergeFilename.'"...');
				$mergeLines = file($mergeFilename);
				doTranslate($mergeLines, $htk);
				_put('...back from merge with "'.$mergeFilename.'"...');
				break;
				
			default:
				$htk->translateInstruction($items, $line, $indents, $i);
		}
	}
	$htk->translateEnd();
	
	# Write output file
	$hOut = fopen($fOut, "wb+");
	fwrite($hOut, $htk->deployEnd());
	fclose($hOut);
	_put('Created "'.$fOut.'".');
}


// Compile HTKphp
require_once("htk_php.class.php");

$htkPhpBoot = new HTKphpBoot();
$fIn = 'src.hal/htk_php.hal';
$fOut = 'src.gen/htk_php.php';
deploy($fIn, $htkPhpBoot, $fOut);
if (!is_file($fOut)) die($fOut.' NOT created! Stopping tool chain.');
require_once($fOut);
$htkPhp = new HTKphp();


// Compile the REAL program
$fIn = 'src.hal/counter.hal';
$fOut = 'src.gen/counter.php';
deploy($fIn, $htkPhp, $fOut);
if (!is_file($fOut)) die('Not created, stopping tool chain.');
require_once($fOut);

// Start testing
$c = new Counter();
$c->init();
##$c->run();
$c->runABit(10);
for ($j=0; $j < 3; $j++) {
	
	echo 'HYBERnating...';
	print_r($_HY_STATE);	echo "\n";
	print_r($_HY_PARAM);	echo "\n";
	$c->wake($_HY_STATE, $_HY_PARAM);
	$c->runABit(10);
}

_put("Finished!");
?>
</pre>