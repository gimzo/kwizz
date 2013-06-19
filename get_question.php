<?php
class Pitanje
{
	public $tekst="";
	public $vrsta="";
	public $bodovi="";
	public $odgovori="";
	public $tocan="";
	public $kategorija="";
}
	session_start();
	include_once 'config.php';
	
	if (!isset($_SESSION['user'])) {
		die();
	}
	
	db_connect();
	
	$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje = 1 ORDER BY RAND() LIMIT 1;");
			$data=mysqli_fetch_array($result);
			$id=$data['id_pitanje'];
			$tekst=$data['tekst_pitanja'];
			$vrsta=$data['vrsta_pitanja'];
			$bodovi=$data['bodovi_pitanja'];
			mysqli_free_result($result);
	$pitanje=new Pitanje();
	$pitanje->tekst=$tekst;
	$pitanje->vrsta=$vrsta;
	$pitanje->bodovi=$bodovi;
	if ($vrsta)
	{
		$result=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje = $id AND tocan_odgovor>0;");
	}else
	{
		$result=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje = $id;");
	}
	$pitanje->odgovori=array();
	while ($data=mysqli_fetch_array($result)) {
		$pitanje->odgovori[$data['id_odgovor']] = $data['tekst_odgovor'];
		if ($data['tocan_odgovor']) $pitanje->tocan=$data['id_odgovor'];
	}
	$result=mysqli_query($mysqli, "SELECT naziv_kategorija FROM kategorija NATURAL JOIN pitanje_kategorija WHERE id_pitanje=".$id.";");
	while ($data=mysqli_fetch_array($result)) {
		$pitanje->kategorija=$pitanje->kategorija . " " . $data['naziv_kategorija'];
	}
	$pitanje->kategorija=trim($pitanje->kategorija);
	mysqli_free_result($result);
	db_disconnect();
	echo json_encode($pitanje);
?>
