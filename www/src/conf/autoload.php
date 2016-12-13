<?php


function auto_charge($non_classe){
	$chaine = str_replace("\\", '/', $non_classe).".php";
	require($chaine);
}

spl_autoload_register("auto_charge");
