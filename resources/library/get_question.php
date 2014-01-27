<?php
class Pitanje
{
	public $id="";
	public $tekst="";
	public $vrsta="";
	public $bodovi="";
	public $odgovori="";
	public $tocan="";
	public $kategorija="";
}
	session_start();
	include_once '../config.php';
	
	if (!isset($_SESSION['user'])) {
		die();
	}
	
	db_connect();
	$difficulty="";
	$categorycheck="";
	
	//odabir kategorije, ukoliko postoji u requestu
	if (isset($_GET['kategorije']))
	{
		$categorycheck=" AND id_kategorija = ".$_GET['kategorije']." ";
	}
	
	//odabir tezine, ukoliko postoje sve opcije urequestu
	if (isset($_GET['easy']) && isset($_GET['med']) && isset($_GET['hard']))
	$difficulty=get_difficulty_query(trim(strtolower($_GET['easy']))!="false",trim(strtolower($_GET['med']))!="false",trim(strtolower($_GET['hard']))!="false");
	
	//prihvat pitanja
	$query="SELECT * FROM pitanje NATURAL JOIN pitanje_kategorija NATURAL JOIN kategorija WHERE odobreno_pitanje = 1 ".$difficulty. $categorycheck. "ORDER BY RAND() LIMIT 1;";
	$result=mysqli_query($mysqli, $query);
			$data=mysqli_fetch_array($result);
			$id=$data['id_pitanje'];
			$tekst=$data['tekst_pitanja'];
			$vrsta=$data['vrsta_pitanja'];
			$bodovi=$data['bodovi_pitanja'];
			mysqli_free_result($result);
	$pitanje=new Pitanje();
	$pitanje->id=$id;
	$pitanje->tekst=$tekst;
	$pitanje->vrsta=$vrsta;
	$pitanje->bodovi=$bodovi;
	//prihvat odgovora na pitanje
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
	
	//prihvat kategorije
	$result=mysqli_query($mysqli, "SELECT naziv_kategorija FROM kategorija NATURAL JOIN pitanje_kategorija WHERE id_pitanje=".$id.";");
	while ($data=mysqli_fetch_array($result)) {
		$pitanje->kategorija=$pitanje->kategorija . $data['naziv_kategorija'] . " | ";
	}
	$pitanje->kategorija=trim($pitanje->kategorija);
	mysqli_free_result($result);
	db_disconnect();
	echo json_encode($pitanje);
	
/* Konstrukcija querya za tezinu pitanja */
function get_difficulty_query($easy,$med,$hard)
{
	if(!($easy || $med || $hard))
		return "";
		$string=" AND ( ";
	if ($easy){
		$string.=" bodovi_pitanja<15 ";
	}
	if ($med){
		if (strlen($string)>10) $string.=" OR ";
		$string.=" bodovi_pitanja BETWEEN 15 AND 50 ";
	}
	if ($hard){
		if (strlen($string)>10) $string.=" OR ";
		$string.=" bodovi_pitanja>50 ";
	}
	$string.=" )";
	return $string;
}
?>
