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
            Games of the team
        </h3>
        <hr>
        
        <?php
        header("content-type:text/html;charset=utf-8");
        session_start();
        $team_name=$_POST['team_name'];
        
        $query1="SELECT CONCAT(p.firstName,' ', p.lastName) AS Player_name, i.DATE, i.INJURY FROM injuries i <br>
                JOIN team t USING(TEAM_ID) <br>
                JOIN player p ON p.personID = i.PLAYER_ID <br>
                WHERE t.TEAM_NAME = '".$team_name."';";


        $query2="SELECT CONCAT(p.firstName,' ', p.lastName) AS Player_name, i.DATE, i.INJURY FROM injuries i
                JOIN team t USING(TEAM_ID)
                JOIN player p ON p.personID = i.PLAYER_ID
                WHERE t.TEAM_NAME = '".$team_name."';";
       
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
      <th>Date</th>
      <th>Injury Type</th>";
      print "</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<td>$row[Player_name]</td> <td>$row[DATE]</td> <td>$row[INJURY]</td>itor_PTS]</td>";
       
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