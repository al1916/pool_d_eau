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
    $name1 = $_POST['name1'];
    $name2 = $_POST['name2'];
    $prenom1 = $_POST['prenom1'];
    $prenom2 = $_POST['prenom2'];
    $course= $_POST['course'];

	//query to get data from the table
	$sql = "SELECT p1.pdate,TIME_TO_SEC(p1.temps),TIME_TO_SEC(p2.temps) FROM `performance` as p1 join performance as p2 on p1.pdate=p2.pdate where p1.nom='".$name1."' and p1.prenom='".$prenom1."' and p1.type_course='".$course."' and p2.nom ='".$name2."' and p2.prenom='".$prenom2."' and p2.type_course='".$course."'";

    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) { 
        $data3 = $data3 . '"'.$row[0].'",';   
		$data1 = $data1 . '"'.$row[1].'",';
        $data2 = $data2 . '"'.$row[2].'",';
		 
	}

?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <link rel="stylesheet" href="stat.css">
		<title>Pool d'eau</title>

		<style type="text/css">	
            :root {
  --primary-color: rgba(13, 110, 139, 0.75);
  --overlay-color: rgba(24, 39, 51 , 0.85);
  --menu-speed: 0.75s;
}
           
			body{
				font-family: Arial;
			    margin: 80px 100px 10px 100px;
			    padding: 0;
			    color: white;
			    text-align: center;
			    background:var(--primary-color);
                position: relative
			}
             body:before{
            content: '';
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              z-index: -1;
            }

			.container {
				color: #E8E9EB;
				background: #222;
				border:  1px solid;
				padding: 10px;
			}
            
.btn {
  display: inline-block;
  border: none;
  background: var(--primary-color);
  color: #fff;
  padding: 0.75rem 1.5rem;
  margin-top: 1rem;
  transition: opacity 1s ease-in-out;
  text-decoration: none;
}
            .btn:hover {
  opacity: 0.7;
}

		</style>

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
        
	  <div class="container">	
	    <h1>Temps entre <?php echo $name1.' '.$prenom1; ?> et <?php echo $name2.' '.$prenom2; ?> au <?php echo $course; ?> </h1>       
			<canvas id="chart" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [<?php echo $data3; ?>],
		            datasets: 
		            [{
		                label: '<?php echo $name1.' '.$prenom1; ?>',
		                data: [<?php echo $data1; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3
		            },

		            {
		            	label: '<?php echo $name2.' '.$prenom2; ?>',
		                data: [<?php echo $data2; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(0,255,255)',
		                borderWidth: 3	
		            }]
		        },
		     
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    });
			</script>
	    </div>
	</body>
</html>