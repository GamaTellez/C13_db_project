<?php         
    require_once('vacation_goer.php');
    require_once('vacation.php');
    require_once('vacation_vote.php');



    session_start();
    
    $_SESSION["vacation_goers_array"] = $vacation_goers_array = array();
    $_SESSION["vacations_array"] = $vacations_array = array();
    $_SESSION["vacation_votes_array"] = $vacation_votes_array = array();
    

    function set_db_connection() {
        static $db;
        // try {
        //     $user = 'root';
        //     $pass = '';    
        //     $db = 'vacation_app_test_db';
        //     $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");   
        //     return $db;
        // } catch (PDOException $ex) {
        //     echo 'Error!: ' . $ex->getMessage();
        //     die();
        // }
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
            return $db;
        }
        catch (PDOException $ex)
        {
            echo 'Error!: ' . $ex->getMessage();
            die();
        }
    }
    
if (isset($_POST['login'])) {
    // $doc_html = new DOMDocument();
    // $doc_html-> loadHTMLFile("thevacation.php");
    // $login_form = $doc_html->getElementById("user_login_form"); 
    // $login_form->setAttribute("display","none");
    //     // $new_conn = set_db_connection();
        // if ($new_conn){
        //     $current_username = mysql_real_escape_string($_POST['username']);
        //     $password = htmlspecialchars($_POST['password']);
        //     // $goer_query = $new_conn-> query("SELECT * FROM vacation_goer WHERE username = '$current_username'");
        //     $goer_query = "SELECT * FROM vacation_goer WHERE username = '$current_username'";
        //     if ($result_goer = $new_conn-> query($goer_query)) {
        //         while ($obj = $result_goer->fetch_object()) {
        //             // printf("%s %s %s \n", $obj->username, $obj->password, $obj->display_name);
        //         }
        //         $doc_html = new DOMDocument();
        //         $doc_html-> load(file_get_contents("thevacation.php"));
        //         $login_form = $doc_html->getElementById('user_login_form'); 
        //         $login_form->setAttribute("display","none")
        //         $result_goer->close();
        //     }
        // } else {
        //     print_r("database didnt connect");
        // }
}

    function on_load_page() {
        $new_conn = set_db_connection();
       foreach ($new_conn->query('SELECT id, username, password, display_name FROM vacation_goer') as $row) {
            array_push($_SESSION["vacation_goers_array"], new Vacation_goer($row['id'], $row['username'], $row['password'], $row['display_name']));
        }

        foreach ($new_conn->query('SELECT id, destination, description, author_goer_id, date_added FROM vacation') as $row) {
            array_push($_SESSION["vacations_array"], new Vacation($row['id'], $row['destination'], $row['description'], $row['author_goer_id'], $row['date_added']));
        }

        foreach ($new_conn->query('SELECT id, author_goer_id, vacation_id FROM vacation_vote') as $row) {
            array_push($_SESSION["vacation_votes_array"], new Vacation_vote($row['id'], $row['author_goer_id'], $row['vacation_id']));
        }
    }
?>