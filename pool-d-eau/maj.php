<?php
   if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
      //$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
      $test="rankings_natcourse_25.csv";
      $extensions= array("csv","jpg","png");
      $host = 'localhost';
      $user = 'root';
      $pass = '';
      $db = 'piscine';
      $filenamesql="temp.sql";
      $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
      $lines = file($filenamesql);
      
      //if(in_array($file_ext,$extensions)=== false){
        // $errors[]="extension not allowed, please choose a CSV file.";
      //}
      
      if($file_size > 5097152){
         $errors[]='File size must be excately 5 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"upload/".$file_name);
         passthru("python insertmysqlphp.py $file_name");
         //passthru("python ete.py");
         foreach ($lines as $line)
         {

         // Add this line to the current segment
         $sql= $line;
         $result = mysqli_query($mysqli, $sql);
         if (substr(trim($line), -1, 1) == ';')
         {
         // Perform the query
         // Reset temp variable to empty
         $sql = '';
         }
         }
         echo "Success";
         //passthru("python ete.py");
         
      }else{
         print_r($errors);
      }
   }
  
   //passthru('python ete.py');

?>
