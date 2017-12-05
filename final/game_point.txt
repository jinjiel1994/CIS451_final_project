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
          Games which have a higher total point than the number
        </h3>
        <hr>
        
        <?php
        header("content-type:text/html;charset=utf-8");
        session_start();
        $point=$_POST['point'];
        
        $query1="SELECT Date, ht.TEAM_NAME AS Home_Team, Home_PTS, vt.TEAM_NAME AS Visitor_Team, Visitor_PTS, t.total_pts FROM games g <br>
                JOIN team ht ON ht.TEAM_ID = g.Home_ID <br>
                JOIN team vt ON vt.TEAM_ID = g.Visitor_ID <br>
                JOIN (SELECT GAME_ID, (Visitor_PTS+Home_PTS) AS total_pts FROM games) t USING (GAME_ID) <br>
                WHERE t.total_pts > '".$point."' <br>
                ORDER BY t.total_pts;";


        $query2="SELECT Date, ht.TEAM_NAME AS Home_Team, Home_PTS, vt.TEAM_NAME AS Visitor_Team, Visitor_PTS, t.total_pts FROM games g
                JOIN team ht ON ht.TEAM_ID = g.Home_ID
                JOIN team vt ON vt.TEAM_ID = g.Visitor_ID 
                JOIN (SELECT GAME_ID, (Visitor_PTS+Home_PTS) AS total_pts FROM games) t USING (GAME_ID)
                WHERE t.total_pts > '".$point."'
                ORDER BY t.total_pts;";
       
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
      <th>Date</th>
      <th>Home Team</th>
      <th>Home PTS</th>
      <th>Visitor Team</th>
      <th>Visitor PTS</th>
      <th>total_pts</th>";
      print "</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<td>$row[Date]</td> <td>$row[Home_Team]</td> <td>$row[Home_PTS]</td> <td>$row[Visitor_Team]</td> <td>$row[Visitor_PTS]</td> <td>$row[total_pts]</td>";
        print "</tr>";
    }
    print "</table>";
    print "</pre>";
    $dbh = null;
    ?>




        <br><br><br>
        <hr>
    <p>
        Click <a href="game_point.txt">here</a> to see the Implementation code of this page.
    </p>
    </body>
</html>