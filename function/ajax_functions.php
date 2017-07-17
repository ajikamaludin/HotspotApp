<?php
include "config_functions.php";
include "db.php";
include "functions.php";

$aksi = $_POST['aksi'];

if($aksi == 'hapusUser'){
	$username = $_POST['id'];
	$hasil = hapus_user($username);
	if($hasil){
		echo "0";
	}else{
		echo "1";
	}
}else if($aksi == 'hapusGroup'){
	$group = $_POST['id'];
	$hasil = hapus_group($group);
	if($hasil){
		echo "0";
	}else{
		echo "1";
	}
}else{
	echo "1";
}
?>