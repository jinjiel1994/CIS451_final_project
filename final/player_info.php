<?php

include('connectionData.php');
try
{
    $dbh = new PDO('mysql:host='.$server.';port='.$port.';dbname='.$dbname, $user, $pass);
} catch (PDOException $e) {
    print $e->getMessage();
    exit;
}
?>

<html>
    <head>
        <title>NBA 2016-2017 Season</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{text-align:center}
        </style>
    </head>
    <body bgcolor='white'>
        <h3><br><br><br><br>
            Players in the team
        </h3>
        <hr>
        
        <?php
        header("content-type:text/html;charset=utf-8");
        session_start();
        $team_name=$_POST['team_name'];
        
        $query1="SELECT p1.Player_name, p.weightPounds, CONCAT(p.heightFeet,',', p.heightInches) AS Height, p.pos AS Position, p.jersey <br>
                FROM player p <br>
                JOIN (SELECT CONCAT(firstName,' ', lastName) AS Player_name, personID FROM player) p1 USING(personID) <br>
                JOIN team t USING(TEAM_ID)<br>
                WHERE t.TEAM_NAME ='".$team_name."';";


        $query2="SELECT p1.Player_name, p.weightPounds, CONCAT(p.heightFeet,',', p.heightInches) AS Height, p.pos AS Position, p.jersey
                FROM player p
                JOIN (SELECT CONCAT(firstName,' ', lastName) AS Player_name, personID FROM player) p1 USING(personID)
                JOIN team t USING(TEAM_ID)
                WHERE t.TEAM_NAME ='".$team_name."';";
       
        ?>
        <p><br><br>
            <b>Query:</b>
            <br>
        </p>
        <?php
  	print $query1;
  	?>
        <p><br><br>
            <b>Result:</b>
            <br>
        </p>
   <?php
   $result = $dbh->prepare($query2);

   if (!$result) 
   {
	   print "execution error: </br>";
   	$error = $dbh->errorInfo();
    print($error[2]);
    exit;
   }


   $result->execute();
    
    print "<pre>";
    print "<table border=\"1\" align=\"center\">";
      print"<tr>
      <th>Player Name</th>
      <th>Weight</th>
      <th>Height</th>
      <th>Position</th>
      <th>Jersey Number</th>";
      print "</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<td>$row[Player_name]</td> <td>$row[weightPounds]</td> <td>$row[Height]</td> <td>$row[Position]</td> <td>$row[jersey]</td>";
        print "</tr>";
    }
    print "</table>";
    print "</pre>";
    $dbh = null;
    ?>
  <center>
  <p>
  Enter name of your favorite player for his more info

  <p>
   
  <form action="player_stat.php" method="POST">

  <input type="text" name="player_name"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Enter a jersey number to show the top 3 players in this jersey in terms of point per game

  <p>
   
  <form action="jersey.php" method="POST">

  <input type="text" name="number"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>



  </center>
        <br><br><br>
        <hr>
    <p>
        Click <a href="player_info.txt">here</a> to see the Implementation code of this page.
    </p>
    </body>
</html>