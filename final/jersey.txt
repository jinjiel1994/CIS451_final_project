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
            Top 3 players
        </h3>
        <hr>
        
        <?php
        header("content-type:text/html;charset=utf-8");
        session_start();
        $number=$_POST['number'];
        
        $query1="SELECT  p1.Player_name, p.jersey, IF(ISNULL(pp.GP),0, pp.GP) AS GP, IF(ISNULL(pp.MIN),0, pp.MIN) AS MIN, <br>
                IF(ISNULL(pp.PTS),0, pp.PTS) AS PTS, IF(ISNULL(pp.REB),0, pp.REB) AS REB,<br>
                IF(ISNULL(pp.AST),0, pp.AST) AS AST, IF(ISNULL(pp.STL),0, pp.STL) AS STL,<br>
                IF(ISNULL(pp.BLK),0, pp.BLK) AS BLK, IF(ISNULL(pp.TOV),0, pp.TOV) AS TOV,<br>
                IF(ISNULL(pp.FG_PCT),0, pp.FG_PCT) AS FG_PCT, IF(ISNULL(pp.FG3_PCT),0, pp.FG3_PCT) AS FG3_PCT,<br>
                IF(ISNULL(pp.FT_PCT),0, pp.FT_PCT) AS FT_PCT FROM player p <br>
                JOIN (SELECT CONCAT(firstName,' ', lastName) AS Player_name, personID FROM player) p1 USING(personID)<br>
                LEFT JOIN player_performance pp ON pp.PLAYER_ID = p.personId<br>
                WHERE p.jersey = '".$number."' <br>
                ORDER BY PTS DESC <br>
                LIMIT 3;";


        $query2="SELECT  p1.Player_name, p.jersey, IF(ISNULL(pp.GP),0, pp.GP) AS GP, IF(ISNULL(pp.MIN),0, pp.MIN) AS MIN, 
                IF(ISNULL(pp.PTS),0, pp.PTS) AS PTS, IF(ISNULL(pp.REB),0, pp.REB) AS REB,
                IF(ISNULL(pp.AST),0, pp.AST) AS AST, IF(ISNULL(pp.STL),0, pp.STL) AS STL,
                IF(ISNULL(pp.BLK),0, pp.BLK) AS BLK, IF(ISNULL(pp.TOV),0, pp.TOV) AS TOV,
                IF(ISNULL(pp.FG_PCT),0, pp.FG_PCT) AS FG_PCT, IF(ISNULL(pp.FG3_PCT),0, pp.FG3_PCT) AS FG3_PCT,
                IF(ISNULL(pp.FT_PCT),0, pp.FT_PCT) AS FT_PCT FROM player p 
                JOIN (SELECT CONCAT(firstName,' ', lastName) AS Player_name, personID FROM player) p1 USING(personID)
                LEFT JOIN player_performance pp ON pp.PLAYER_ID = p.personId
                WHERE p.jersey = '".$number."' 
                ORDER BY PTS DESC 
                LIMIT 3;";
       
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
      <th>Jersey</th>
      <th>Game played</th>
      <th>Minutes</th>
      <th>Points</th>
      <th>Rebound</th>
      <th>Assist</th>
      <th>Steal</th>
      <th>Block</th>
      <th>Turnover</th>
      <th>FG_PCT</th>
      <th>FG3_PCT </th>
      <th>FT_PCT</th>";
      print "</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<td>$row[Player_name]</td> <td>$row[jersey]</td> <td>$row[GP]</td> <td>$row[MIN]</td> <td>$row[PTS]</td> <td>$row[REB]</td> <td>$row[AST]</td> <td>$row[STL]</td> <td>$row[BLK]</td>  <td>$row[TOV]</td> <td>$row[FG_PCT]</td> <td>$row[FG3_PCT]</td> <td>$row[FT_PCT]</td> ";
        print "</tr>";
    }
    print "</table>";
    print "</pre>";
    $dbh = null;
    ?>

    <p>


        <br><br><br>
            <p>
        Click <a href="http://ix.cs.uoregon.edu/~linzeli/final/team.php">here</a> to back to the Team page.
    </p>
        <hr>
    <p>
        Click <a href="jersey.txt">here</a> to see the Implementation code of this page.
    </p>
    </body>
</html>