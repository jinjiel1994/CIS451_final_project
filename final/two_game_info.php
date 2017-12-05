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
            Battle between two teams
        </h3>
        <hr>
        
        <?php
        header("content-type:text/html;charset=utf-8");
        session_start();
        $team_name1=$_POST['team_name1'];
        $team_name2=$_POST['team_name2'];
        
        $query1="SELECT Date, ht.TEAM_NAME AS Home_Team, Home_PTS, vt.TEAM_NAME AS Visitor_Team, Visitor_PTS FROM games g <br>
                JOIN team ht ON ht.TEAM_ID = g.Home_ID <br>
                JOIN team vt ON vt.TEAM_ID = g.Visitor_ID <br>
                WHERE (ht.TEAM_NAME = '".$team_name1."' AND vt.TEAM_NAME = '".$team_name2."') <br>
                OR (ht.TEAM_NAME = '".$team_name2."' AND vt.TEAM_NAME = '".$team_name1."');";


        $query2="SELECT Date, ht.TEAM_NAME AS Home_Team, Home_PTS, vt.TEAM_NAME AS Visitor_Team, Visitor_PTS FROM games g
                JOIN team ht ON ht.TEAM_ID = g.Home_ID
                JOIN team vt ON vt.TEAM_ID = g.Visitor_ID
                WHERE (ht.TEAM_NAME = '".$team_name1."' AND vt.TEAM_NAME = '".$team_name2."')
                OR (ht.TEAM_NAME = '".$team_name2."' AND vt.TEAM_NAME = '".$team_name1."');";
       
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
      <th>Visitor PTS</th>";
      print "</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<td>$row[Date]</td> <td>$row[Home_Team]</td> <td>$row[Home_PTS]</td> <td>$row[Visitor_Team]</td> <td>$row[Visitor_PTS]</td>";
        print "</tr>";
    }
    print "</table>";
    print "</pre>";
    $dbh = null;
    ?>




        <br><br><br>
        <hr>
    <p>
        Click <a href="injury_info.txt">here</a> to see the Implementation code of this page.
    </p>
    </body>
</html>