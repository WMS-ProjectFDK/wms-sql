<?php
	session_start();
	$result = array();
	include("../connect/conn.php");
	$rs = "select a.id, a.menu_parent, a.menu_name, a.link, id_parent, id_menu from ztb_menu a order by id asc";
	$data_rs = oci_parse($connect, $rs);
	oci_execute($data_rs);

	$items = array();
	while($row = oci_fetch_object($data_rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	echo json_encode($result);
?>