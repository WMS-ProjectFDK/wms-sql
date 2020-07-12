<?php
header("Content-type: application/json");
$label = isset($_REQUEST['label']) ? strval($_REQUEST['label']) : '';
$arrData = array();
$arrNo = 0;
$q=0;

include("../../connect/conn.php");

$sql = "select sum(total) as total from (
	select * from (select a.id_print, b.labelline, b.shift, replace(b.recorddate,' ','<br>') as recorddate, b.tanggal, b.asy_line, b.grade,
		case when a.status=2 then total_2 else total_1 end as total
		from (
		select id_print, labelline, recorddate, status, qty, qty_terpakai, ng_qty, qty_in_antrian,
		sum(qty_in_antrian-(qty_terpakai+ng_qty)) as total_2,
		sum(qty-(qty_terpakai+ng_qty)) as total_1
		from ztb_lbl_trans
		where remark='FINISH'
		and replace(labelline,'#','-') = '$label'
		group by id_print, labelline, recorddate, status, qty, qty_terpakai, ng_qty, qty_in_antrian
		) a
		inner join ztb_lbl_trans b on a.id_print = b.id_print and a.labelline= b.labelline and a.recorddate= b.recorddate
		where (a.total_2 > 0 OR a.total_1 > 0)
		) where total > 0
	)";
$result = oci_parse($connect, $sql);
oci_execute($result);

while($row = oci_fetch_object($result)){
	$q += $row->TOTAL;
}

$qnum = number_format($q);
array_push($arrData, array('TOTAL'=>$qnum));
echo json_encode($arrData);
?>