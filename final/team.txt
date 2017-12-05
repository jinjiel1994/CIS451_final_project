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
            Teams in NBA
        </h3>
        <hr>
        <?php
        $query1 = "SELECT t.TEAM_NAME, t.Owner, c.COACH_NAME, t.Conference, t.Web, t.Arena, t.Location, t.Total_Salary FROM team t<br>
                    JOIN coach c USING(TEAM_ID)<br>
                    ORDER BY(t.Conference);";
        
        $query2 = "SELECT t.TEAM_NAME, t.Owner, c.COACH_NAME, t.Conference, t.Web, t.Arena, t.Location, t.Total_Salary FROM team t
                    JOIN coach c USING(TEAM_ID)
                    ORDER BY(t.Conference);";
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
      <th>Team Name</th>
      <th>Owner</th>
      <th>Coach</th>
      <th>Conference</th>
      <th>Web</th>
      <th>Arena</th>
      <th>Location</th>
      <th>Total Salary</th>


      ";
      print"</tr>";


    while($row = $result->fetch())
    {
        print "<tr>";
        print "<th>$row[TEAM_NAME]</th> <th>$row[Owner]</th> <th>$row[COACH_NAME]</th> <th>$row[Conference]</th> <th>$row[Web]</th> <th>$row[Arena]</th> <th>$row[Location]</th> <th>$row[Total_Salary]</th> ";
        print "</tr>";
    }
    print "</table>";
    print "</pre>";
    $dbh = null;
    ?>
  <center> 
  <p>
  Please enter any team name to have the player info of this team as well as
  further manipulation about players

  <p>
   
  <form action="player_info.php" method="POST">

  <input type="text" name="team_name"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Please enter any team name to have the game info for this team within the season

  <p>
   
  <form action="game_info.php" method="POST">

  <input type="text" name="team_name"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Please enter a number to show games which have a higher total point than this number(average total point is around 200)

  <p>
   
  <form action="game_point.php" method="POST">
  <input type="text" name="point"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Please enter any team name to have the injury info of this team

  <p>
   
  <form action="injury_info.php" method="POST">

  <input type="text" name="team_name"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Please enter any team name to have the award info of this team

  <p>
   
  <form action="award_info.php" method="POST">

  <input type="text" name="team_name"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Please enter two team names to have the game info between them

  <p>
   
  <form action="two_game_info.php" method="POST">

  <input type="text" name="team_name1"> <br> 
  <input type="text" name="team_name2"> <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  <p>
  Enter the value and the type of the stat to show the players with higher average of such stat

  <p>
   
  <form action="average_stat.php" method="POST">

  <input type="text" name="value"> (Value) <br> 
  <input type="text" name="type">  (PTS/AST/REB) <br> 
  <input type="submit" value="submit">
  <input type="reset" value="reset">
  </form>

  </center>

    <p>
    Click <a href="team.txt">here</a> to see the Implementation code of this page.
    </p>
    </body>
</html>