<?php

$sqli = "insert into random_id (random) values ("; 
$i = 20000;
$numbers =[] ;

for($j = 0 ; $j < $i ; ++$j){
	$m = rand(0,$i-1) *$i + rand(0,$i-1);
	while(in_array($m , $numbers)){
		$m = rand(0,$i-1) *$i + rand(0,$i-1);
	}
	$numbers[] = $m; 
	//echo "\n".rand(0,$i * 900 -$j)."\n";
	//unset($numbers[rand(0,$i *90 -$j)]);
	//$numbers = array_values($numbers); 
	//echo count($numbers)."\n";//. floor(rand()*$i *900 -$j)."\n"; 
}
$numbers = array_unique($numbers);
//echo count($numbers); 
//var_dump( $numbers); 
//shuffle($numbers); 
for($l = 0; $l < $i -10&& $l <count($numbers) -1 ; $l = $l +10 ){
	$ll = $sqli; 
	for($myl = $l ; $myl < $l+9; ++$myl)
		$ll .= $numbers[$myl]."),(";
	$ll .= $numbers[$l+9]."); ";	
	$sql[] = $ll ; 
}
$sql = implode("\n", $sql); 
echo $sql;
//echo "\n". count($numbers)."\n"; 
