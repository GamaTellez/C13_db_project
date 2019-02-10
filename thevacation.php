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
                // include 'connect.php';
                // try
                //     {
                //         $user='root';
                //         $pass='';
                //         $db='vacation_app_test_db';
                
                //         $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
                //     }
                //     catch (PDOException $ex)
                //     {
                //         echo 'Error!: ' . $ex->getMessage();
                //         die();
                //     }
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

                    class Vacation_goer {
                        public $id;
                        public $username;
                        public $display_name;
                        public $password;

                        function __construct($id, $username, $display_name, $password)
                        {
                            $this-> id = $id;
                            $this-> username = $username;
                            $this-> display_name = $display_name;
                            $this-> password = $password;
                        }

                        function getUserName() { return $this-> username; }

                        function getId() { return $this-> id; }

                        function getDisplayName() { return $this-> display_name; }

                        function getPassword() { return $this-> password; }
                    }

                    class Vacation {
                        public $id;
                        public $destination;
                        public $description;
                        public $author_goer;

                        function __construct($id, $destination, $description, $author_goer)
                        {
                            $this-> id = $id;
                            $this-> destination = $destination;
                            $this-> description = $description;
                            $this-> author_goer_id = $author_goer;
                        }

                        function getId() { return $this-> id; }

                        function getDestination() { return $this-> destination; }

                        function getDescription() { return $this-> description; }

                        function getAuthorGoerId() { return $this-> author_goer_id; }

                        function findAuthor($vacation_goers_array) { 
                            for ($i = 0;  $i < count($vacation_goers_array); $i++) {
                                    $author_at_index = $vacation_goers_array[$i];
                                    if ($this-> getAuthorGoerId() == $author_at_index-> getId()) {
                                         return $author_at_index-> getDisplayName();
                                    }
                            }
                        }

                        function findVotes($vacation_votes) {
                                $votes_count = 0;
                                for ($i = 0;  $i < count($vacation_votes); $i++) {
                                    $vote_at_index = $vacation_votes[$i];
                                        if ($this-> getId() == $vote_at_index-> getVacationId()) {
                                            $votes_count++;
                                }
                            }
                            return $votes_count;
                        }
                    }

                    class Vacation_vote {
                        public $id;
                        public $author_goer_id;
                        public $vacation_id;

                        function __construct($id, $author_goer_id, $vacation_id)
                        {
                            $this-> id = $id;
                            $this-> author_goer_id = $author_goer_id;
                            $this-> vacation_id = $vacation_id;
                        }

                        function getId() { return $this-> id; }

                        function getAuthorGoerId() { return $this-> author_goer_id; }

                        function getVacationId() { return $this-> vacation_id; }
                    }

                    $vacation_goers_array = array();
                    $vacations_array = array();
                    $vacation_votes_array= array();

                    foreach ($db->query('SELECT id, username, password, display_name FROM vacation_goer') as $row) {
                        array_push($vacation_goers_array, new Vacation_goer($row['id'], $row['username'], $row['display_name'], $row['password']));
                    }
                    // print_r($vacation_goers_array);

                    foreach ($db->query('SELECT id, destination, description, author_goer_id FROM vacation') as $row) {
                        array_push($vacations_array, new Vacation($row['id'], $row['destination'], $row['description'], $row['author_goer_id']));
                    }
                    // print_r($vacations_array);

                    foreach ($db->query('SELECT id, author_goer_id, vacation_id FROM vacation_vote') as $row) {
                        array_push($vacation_votes_array, new Vacation_vote($row['id'], $row['author_goer_id'], $row['vacation_id']));
                    }
                    // print_r($vacation_votes_array);
            ?>


            <form>
                <table id="vacationstable">
                    <tr>
                        <th id="vacationsnamecolumn">Vacation Name</th>
                        <th id="authornamecolumn">Author</th>
                        <th id="detailscolumn">Details</th>
                        <!-- <th id="datecolumn">Date Posted</th> -->
                        <th id="votescolumn">Votes</th>
                    </tr>
                   
                    
                        <?php
                           for ($i = 0;  $i < count($vacations_array); $i++) {
                            echo '<tr>';
                                $vacation_at_index = $vacations_array[$i];
                                echo '<td id="cellTable">'. $vacation_at_index-> getDestination() . '</td>';
                                echo '<td id="cellTable">'. $vacation_at_index-> findAuthor($vacation_goers_array) . '</td>';
                                echo '<td id="cellTable">'. $vacation_at_index-> getDescription() . '</td>';
                                echo '<td id="cellTable">'. $vacation_at_index-> findVotes($vacation_votes_array) . '</td>';
                            } 
                            echo '</tr>';
                        ?>
                    
                
                </table>
            </form>
        </div>
    </body>

</html>