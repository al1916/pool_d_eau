
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
    $_SESSION['course'] = $_POST['course'];
    $test3 = $_POST['course'];
    $time = '';
    $datatemps='';
    $timeavg2 ='';
    $timeavg3 ='';

	//query to get data from the table
	$sql = "SELECT nom,prenom,time_to_sec(temps),pdate,type_course FROM `performance` where nom='".$test1."' and prenom='".$test2."' and type_course='".$test3."' order by pdate";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
		$data1 = $data1 . '"'. $row[2].'",';
		$data2 = $data2 . '"'. $row['pdate'] .'",';
        $data3  = $row['type_course'];
	}

    $sql2 = " SELECT TIME_TO_SEC(temps) FROM `performance` where type_course ='".$test3."'and age = (select max(age) from performance where nom ='".$test1."' and prenom='".$test2."' and type_course='".$test3."') and nom='".$test1."' and prenom='".$test2."'";

    $result2 = mysqli_query($mysqli, $sql2);
    while($row1 = mysqli_fetch_array($result2)){
    $timeavg = $time . '"'.$row1[0].'"';
    }


    $sql3 = " SELECT min(time_to_sec(temps)),`performance`.nom,`performance`.prenom FROM `performance` INNER JOIN `nageur` ON `performance`.nom = `nageur`.nom WHERE `type_course` ='".$test3."' and sexe=(select DISTINCT sexe from nageur where nom='".$test1."' and prenom='".$test2."') and age = (select max(age) from performance where nom ='".$test1."' and prenom='".$test2."' and type_course='".$test3."') ";

    $result3 = mysqli_query($mysqli, $sql3);
    while($row2 = mysqli_fetch_array($result3)){
    $timeavg2 = $timeavg2 . '"'.$row2[0].'",';
    $best = $row2[1].' '.$row2[2];}


   /* $sqls =  " SELECT temps FROM `performance` where type_course ='".$test3."'and age = 18 and nom<>'".$test1."'";

    $result5 = mysqli_query($mysqli,$sqls);
    while($row5 = mysqli_fetch_array($result5)){
        $b=$row2[0][6]*10 + $row2[0][7] + $row2[0][4]*60 + $row2[0][3]*600 + $row2[0][1]*3600 + $row2[0][0]*36000;

    }*/


    $sql4 = " SELECT avg(time_to_sec(temps)) FROM `performance` INNER JOIN `nageur` ON `performance`.nom = `nageur`.nom WHERE `type_course` ='".$test3."' and sexe=(select DISTINCT sexe from nageur where nom='".$test1."' and prenom='".$test2."') and age = (select max(age) from performance where nom ='".$test1."' and prenom='".$test2."' and type_course='".$test3."')";

    $result4 = mysqli_query($mysqli, $sql4);
    while($row3 = mysqli_fetch_array($result4)){
    $timeavg3 = $timeavg3 . '"'.$row3[0].'",';

    }



$datatemps = $timeavg.',' . ''.$timeavg2.'' . ''.$timeavg3.'' ;

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
	    <h1>Performance globale de <?php echo $test1." ".$test2 ?> sur <?php echo $test3; ?></h1>
			<canvas id="chart" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [<?php echo $data2 ;?>],
		            datasets:
		            [{
		                label: 'Temps',
		                data: [<?php echo $data1 ;?>] ,
		                backgroundColor: '#222',
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3,
                        steppedLine : false
		            }

		            ]
		        },

		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},

		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    });
			</script>
	    </div>

        <a href="marge1.php" class="btn">Calcul de la marge</a> <br/>

	    <div class="container">


            <h1>Temps moyen de <?php echo $test1." ".$test2 ?> par rapport aux autres nageurs au même age </h1>
			<canvas id="chart1" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
				var ctx = document.getElementById("chart1").getContext('2d');
    			var myChart1 = new Chart(ctx, {
        		type: 'bar',
		        data: {
		            labels: ['','Temps personnel','Meilleur temps au même age','temps moyen au meme age',''],
		            datasets:
		            [{
		                label: 'Temps',
		                data: [0,<?php echo $datatemps ;?>] ,
									backgroundColor: ["#3e95cd", "#0039B8","#49FF28","#FF9C16","#c45850"],
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3,

		            }

		            ]
		        },

		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},

		            legend:{display: true, position: 'top', labels: {fontColor: 'rgb(255,255,255)', fontSize: 16}}
		        }
		    });
			</script>
        <?php echo $best; ?>
        </div>
	</body>
</html>
