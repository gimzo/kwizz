<!DOCTYPE html> 
<html>
<head>
  <title>Add question</title>
</head>
<body>
	<form action="add_question.php" method="POST">
		<p>Pitanje: <input type="text" name="tekst_pitanja" maxlength="100"></p>
    <p>a: <input type="text" name="odgovor_a" maxlegth="45">
    <input type="checkbox" name="tocan_a"></p>
    <p>b: <input type="text" name="odgovor_b" maxlegth="45">
    <input type="checkbox" name="tocan_b"></p>
    <p>c: <input type="text" name="odgovor_c" maxlegth="45">
    <input type="checkbox" name="tocan_c"></p>
    <p>d: <input type="text" name="odgovor_d" maxlegth="45">
    <input type="checkbox" name="tocan_d"></p>
    <p><input type="text" name="bodovi"></p>
    <p><input type="submit" value="potvrdi" ></p>
  </form> 


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	$tekst=$_POST['tekst_pitanja'];
  $bodovi=$_POST['bodovi'];
  $vrsta=1; //visestruki izbor
  $jezik="hr";
  $autor=2; //id_autor izvuci iz sesije
  $checked=0;
  $odgovor_a=$_POST['odgovor_a'];
  $odgovor_b=$_POST['odgovor_b'];
  $odgovor_c=$_POST['odgovor_c'];
  $odgovor_d=$_POST['odgovor_d'];
  $tocan=1;
  

	include 'config.php';
	db_connect();
	
  //provjera da li su svi textboxi puni
  if(empty($_POST['tekst_pitanja']) || empty($_POST['odgovor_a']) || empty($_POST['odgovor_b']) || empty($_POST['odgovor_c']) || empty($_POST['odgovor_d']))
  {
    print '<script type="text/javascript">';
    print 'alert("niste popunili sve textboxe")';
    print '</script>';  
  }

  else
  {
  //provjera da li su checkboxi checkirani, upisivanje pitanja i odg u bazu
    if(empty ($_POST['tocan_a']) && empty($_POST['tocan_b']) && empty($_POST['tocan_c']) && empty($_POST['tocan_d']))
    {
      print '<script type="text/javascript">';
      print 'alert("niste odabrali nijedan odgovor")';
      print '</script>';  
    }

    else
    {
      mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '$vrsta', '$bodovi', '$jezik', '$autor');");
      $id=mysqli_insert_id($mysqli);

      if (empty($_POST['tocan_a']))
      {
        $tocan=0;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$tocan', '$id');");    
      }

      else
      {
        $tocan=1;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$tocan', '$id');"); 
      }

      if(empty($_POST['tocan_b']))
      {
        $tocan=0;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_b', '$tocan', '$id');");    
      }

      else
      {
        $tocan=1;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_b', '$tocan', '$id');"); 
      }

      if(empty($_POST['tocan_c']))
      {
        $tocan=0;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_c', '$tocan', '$id');");    
      }

      else
      {
        $tocan=1;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_c', '$tocan', '$id');"); 
      }

      if(empty($_POST['tocan_d']))
      {
        $tocan=0;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_d', '$tocan', '$id');");       
      }

      else
      {
        $tocan=1;
        mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_d', '$tocan', '$id');"); 
      }
  
    }
  }

	db_disconnect();
}

?>

</body>
</html>