
<?php
session_start();
  /* Première instruction : démarrage de la session
    A faire avant TOUT le reste */
?>

<?php
	/* Database connection settings */
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'piscine';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

	$data1 = '';
	$data2 = '';
    $data3 = '';
    $test1 = $_SESSION['nom'];
    $test2 = $_SESSION['prenom'];
    $test4 = $_POST['groupe'];

	//query to get data from the table
	$sql = "UPDATE Nageur SET Groupe='".$test4."' WHERE nom='".$test1."' and prenom='".$test2."'";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
    //$result->closeCursor(); // Termine le traitement de la requête
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="stat.css">
  <title>Hamburger Menu Overlay</title>
   
   
</head>
<body>
  <div class="menu-wrap">
    <input type="checkbox" class="toggler">
    <div class="hamburger"><div></div></div>
    <div class="menu">
      <div>
        <div>
          <ul>
            <li><a href="index.php">Page principale</a></li>
            <li><a href="info.html">Information</a></li>

          </ul>
        </div>
      </div>
    </div>
  </div>

  <header class="showcase">
    <div class="container showcase-inner">
  
	<?php echo $test1.' '.$test2.' est désormais dans le groupe '.$test4; ?>
       
    </div>
  </header>
    	 <section id="moi"> 
		<br/> 
		<center> 
		En savoir plus sur Cergy Pontoise Natation :
		</center>
		<br/>
		<center>
	<a title="" href="https://www.cergypontoisenatation.fr/"><img src="site.png" height="40" width="40"/></a> &nbsp; &nbsp;<a href="https://www.facebook.com/CPN95/"><img src="fb30.png" /></a>
		</center>
	
		<br/>
		<center>
		<figure>
		<img src="copy.png" height="40" width="40">
		
		  <figcaption>by CAP'EISTI in 2019</figcaption>
        </figure>
		</center>
		<br/>  
		<center>
		<a href="https://capeisti.fr/"><img src="cap.png" height="50" width="140"/></a>
		</center>
		<br/>
		<center>
		Gonnet-Marty, Boisseau, Perrono, Rabahi, Toulza
		</center>
	<br/>
		
		</section>
       
      <footer>   
   </footer> 
</body>
</html>