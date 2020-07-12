<?php
	session_start();
	require_once('sessionvalidation.php');
	include("connect/conn.php");
	$user_name = $_SESSION['id_wms'];
	$nama = $_SESSION['name_wms'];

	$sql = "select a.person, b.description from person a inner join person_type b on a.person_type=b.type
		where a.person_code='$user_name' ";
	$data_sql = oci_parse($connect, $sql);
	oci_execute($data_sql);
	$dt_sql = oci_fetch_object($data_sql);

	if($dt_sql->DESCRIPTION == '' OR is_null($dt_sql->DESCRIPTION)){
		$ty = 'ADMINISTRATOR';
	}else{
		$ty = $dt_sql->DESCRIPTION;
	}

	function access_log($menu_id,$user){
		include("connect/conn.php");
		$qry = "select access_add, access_update, access_delete, access_view, access_print 
			from ztb_user_access where menu_id=$menu_id and person_code='$user' ";
		$data_qry = oci_parse($connect, $qry);
		oci_execute($data_qry);
		$dt = oci_fetch_array($data_qry);
		$result = 'ADD/'.$dt[0].'-UPDATE/'.$dt[1].'-DELETE/'.$dt[2].'-VIEW/'.$dt[3].'-PRINT/'.$dt[4];
		return $result;
	}
?>

<script language="javascript">
 function confirmLogOut(){
	var is_confirmed;
	is_confirmed = window.confirm("End current session?");
	return is_confirmed;
 }
 </script> 
<style>
	.style4 {
	font-size: 11px;
	color: #CC0000;
	}
</style>
	<div style="margin: 0px 0px;">
	<table width="100%">
		<tr>
			<td align="left" width="92%" valign="middle"><marquee><span class="style4"><?php echo "Welcome ".$nama.", you are login as ".$ty." PT FDK INDONESIA";?></span></marquee></td>
			<td align="right" width="8%"><span id='demo'></span></td>
			<td align="right"><a href="../dashboard/dashboard.php" title="Home"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a></td>
			<td align="right" width="2%" valign="middle"><a href="../logout.php" onClick="return confirmLogOut()" title="Sign-Out" target="_top"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a></td>
		</tr>
	</table>
	</div>

<script type="text/javascript">
	var myVar = setInterval(function(){myTimer()},1000);

	function myTimer(){
	    var d = new Date();
	    document.getElementById("demo").innerHTML = d.toLocaleTimeString().replace('.',':').replace('.',':');
	}
</script>