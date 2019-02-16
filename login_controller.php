<?php         
    require_once('vacation_goer.php');
    require_once('vacation.php');
    require_once('vacation_vote.php');
    
    $vacation_goers_array = array();
    $vacations_array = array();
    $vacation_votes_array = array();
    function set_db_connection() {
        static $db;
        try {
            $user = 'root';
            $pass = '';    
            $db = 'vacation_app_test_db';
            $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");   
            return $db;
        } catch (PDOException $ex) {
            echo 'Error!: ' . $ex->getMessage();
            die();
        }
                     // try
                     // {
                     //     $dbUrl = getenv('DATABASE_URL');
 
                     //     $dbOpts = parse_url($dbUrl);
 
                     //     $dbHost = $dbOpts["host"];
                     //     $dbPort = $dbOpts["port"];
                     //     $dbUser = $dbOpts["user"];
                     //     $dbPassword = $dbOpts["pass"];
                     //     $dbName = ltrim($dbOpts["path"],'/');
 
                     //     $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
                     //     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                     //     get_current_user_data();
                     // }
                     // catch (PDOException $ex)
                     // {
                     //     echo 'Error!: ' . $ex->getMessage();
                     //     die();
                     // }
    }
    

    function get_current_user_data() {
        $new_conn = set_db_connection();
        if ($db){
            $current_username = mysql_real_escape_string($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            if (!empty($current_user) && !empty($password)) {
                $current_vacation_goer_query = $db->query("SELECT * FROM vacation_goer WHERE username = '$username'");
                $current_user_obj = mysql_fetch_object($current_vacation_goer_query);
                if ($current_user_obj) {
                    var_dump($current_user_obj);
                    echo "connected to db";
                } else{
                    echo "something went wrong";
                }
            }
            // include 'vacations_db_controller.php';

        } else {

        }   
    }

    function on_load_page() {
        $new_conn = set_db_connection();
       foreach ($new_conn->query('SELECT id, username, password, display_name FROM vacation_goer') as $row) {
            array_push($vacation_goers_array, new Vacation_goer($row['id'], $row['username'], $row['display_name'], $row['password']));
        }
                // print_r($vacation_goers_array);
        foreach ($new_conn->query('SELECT id, destination, description, author_goer_id, date_added FROM vacation') as $row) {
            array_push($vacations_array, new Vacation($row['id'], $row['destination'], $row['description'], $row['author_goer_id'], $row['date_added']));
        }
                // print_r($vacations_array);
        foreach ($new_conn->query('SELECT id, author_goer_id, vacation_id FROM vacation_vote') as $row) {
            array_push($vacation_votes_array, new Vacation_vote($row['id'], $row['author_goer_id'], $row['vacation_id']));
        }
    }
?>