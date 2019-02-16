<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="thevacationstylesheet.css">
        <script src="thevacation.js"></script>
        <?php 
            require 'vacation_db_controller.php';
            on_load_page();
        ?>
        <title>The Vacation</title>
        <div id="titlediv">
            <h1 id="homepagetitle">May the best vacation win!</h1>
                    <form id="user_login_form" method="POST" formaction="vacation_db_controller.php">
                        <input type="text" id="username_textfield" name="username" placeholder="Username">
                        <input type="text" id="password_textfield" name="password" placeholder="Password">
                        <input type="submit" name="login" value="Login">
                        <input type="submit" name="sign_up" value="Sign up">
                    </form> 
            <!-- <img id="escudoMexico" src="escudoMex.png" width="100" height="100"> -->
        </div> 
    </head>

    <body> 

        <div id="table_options_div">
            <img src="images/ilter.png" id="filter_image">
            <select id="filter_by_user_select">
                <option value="start">Select user</option>
            <?php
            $all_goers = $_SESSION["vacation_goers_array"];
            for ($i = 0; $i < count($all_goers); $i++) {
                $vacation_goer_at_index = $all_goers[$i];
                echo '<option value="' . $i . '">' . $vacation_goer_at_index->getDisplayName() . '</td>';
            }
            ?>
            </select id="sort_by_select">
            <img src="images/sort.png" id="sort_image">
            <select>
                <option>Select field</option>
                <option value="0">Date</option>
                <option value="1">Total votes</option>
            </select>
        </div>

        <div id="contentdiv">
            <form>
                <table id="vacationstable">
                    <tr>
                        <th id="vacationsnamecolumn">Destination</th>
                        <th id="authornamecolumn">Author</th>
                        <th id="detailscolumn">Details</th>
                        <th id="datecolumn">Date Posted</th> 
                        <th id="votescolumn">Votes</th>
                    </tr> 
                        <?php
                            $all_vacations = $_SESSION["vacations_array"];
                            $all_goers = $_SESSION["vacation_goers_array"];
                            $all_votes = $_SESSION["vacation_votes_array"];
                        for ($i = 0; $i < count($all_vacations); $i++) {
                        echo '<tr>';
                            $vacation_at_index = $all_vacations[$i];
                            echo '<td id="cellTable">' . $vacation_at_index->getDestination() . '</td>';
                            echo '<td id="cellTable">' . $vacation_at_index->findAuthor($all_goers) . '</td>';
                            echo '<td id="cellTable">' . $vacation_at_index->getDescription() . '</td>';
                            echo '<td id="cellTable">' . $vacation_at_index->getDateAdded() . '</td>';
                            echo '<td id="cellTable">' . $vacation_at_index->findVotes($all_votes) . '</td>';
                            echo '<td id="cellTable">' . '<button type="submit" id="up_vote_button" style="border: 0; background: transparent">'. 
                                '<image src="images/like-50.png" width="40" height="40" alt="submit"' . '</button>'.'</td>' . '</td>';
                        echo '</tr>';
                        }
                        ?>
                </table>
            </form>
        </div>
    
    </body>
</html>