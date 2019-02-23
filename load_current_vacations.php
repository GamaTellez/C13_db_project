<?php
        // require 'vacation_db_controller.php';
        // set_db_connection();
    require_once('vacation_goer.php');
    require_once('vacation.php');
    require_once('vacation_vote.php');

    function set_db_connection()
    {
        static $db;
        // try { 
        //     $user = 'root';
        //     $pass = '';
        //     $db = 'vacation_app_test_db';
        //     $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
        //     return $db;
        //     } catch (PDOException $ex) {
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
         
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
        catch (PDOException $ex)
        {
            $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
            echo 'Error!: ' . $ex->getMessage();
            died();
        }
    }
        
        $vacation_goers_array = array();
        $vacation_votes_array = array();
        $vacations_array = array();

        $array_response = array();
        // $_SESSION["vacation_goers_array"] = $vacation_goers_array;
        // $_SESSION["vacation_votes_array"] = $vacation_votes_array;
        // $_SESSION["vacations_array"] = $vacations_array;

        $new_conn = set_db_connection();

        if ($new_conn) {            
            foreach ($new_conn->query('SELECT id, username, password, display_name FROM vacation_goer') as $row) {
                array_push($array_response, new Vacation_goer($row['id'], $row['username'], $row['password'], $row['display_name']));
            }
        
            foreach ($new_conn->query('SELECT id, destination, description, author_goer_id, date_added FROM vacation') as $row) {
                array_push($array_response, new Vacation($row['id'], $row['destination'], $row['description'], $row['author_goer_id'], $row['date_added']));
            }
        
            foreach ($new_conn->query('SELECT id, author_goer_id, vacation_id FROM vacation_vote') as $row) {
                array_push($array_response, new Vacation_vote($row['id'], $row['author_goer_id'], $row['vacation_id']));
            }
        } else {
            echo "failed to connect to datababe";
        }

        if (sizeof($array_response, 0) == 0) {
            echo "array is empty";
            } else {

            print json_encode($array_response);
        }
        
?>
