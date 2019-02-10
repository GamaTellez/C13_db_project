
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="thevacationstylesheet.css">
        <title>The Vacation</title>
        <div id="titlediv">
            <h1 id="homepagetitle">May the best vacation win!</h1> 
            <!-- <img id="escudoMexico" src="escudoMex.png" width="100" height="100"> -->
        </div>
    </head>

    <body> 
        <div id="contentdiv">
            <?php
                include connect.php;
                try
                {
                  $dbUrl = getenv('DATABASE_URL');
                
                  $dbOpts = parse_url($dbUrl);
                
                  $dbHost = $dbOpts["host"];
                  $dbPort = $dbOpts["port"];
                  $dbUser = $dbOpts["user"];
                  $dbPassword = $dbOpts["pass"];
                  $dbName = ltrim($dbOpts["path"],'/');
                
                  $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
                
                  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch (PDOException $ex)
                {
                  echo 'Error!: ' . $ex->getMessage();
                  die();
                }            
            ?>


            <form>
                <table id="vacationstable">
                    <th id="vacationsnamecolumn">Vacation Name</th>
                    <th id="authornamecolumn">Author</th>
                    <th id="detailscolumn">Details</th>
                    <th id="datecolumn">Date Posted</th>
                    <th id="votescolumn">Votes</th>
                </table>
            </form>
        </div>
    </body>

</html>