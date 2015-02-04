<?php
	
	mysql_connect("localhost","root","root") or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db("easymeeting") or 
		     die("Could not select database: " . mysql_error());
	
	// Values received via ajax
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$url = 'www';//$_POST['url'];
	// connection to the database
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=easymeeting', 'root', 'root');
	} catch(Exception $e) {
		exit('Unable to connect to database.');
	}
	
	// insert the records
	$sql = "INSERT INTO agendamento_reuniao (title, start, end, url) VALUES (:title , :start, :end, :url)";
	$q = $bdd->prepare($sql);
	$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':url'=>$url));
	$dbb->close();
?>