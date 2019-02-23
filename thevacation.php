<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="thevacationstylesheet.css">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
        <script src="thevacation.js"></script>
        
        <title>The Vacation</title>
        <div id="titlediv">
            <h1 id="homepagetitle">May the best vacation win!</h1>
                    <form id="user_login_form" method="POST" 
                    onsubmit="return login_user_with_credentials(this.username_textfield.value, this.password_textfield.value)">
                        <input type="text" id="username_textfield" name="username" placeholder="Username">
                        <input type="text" id="password_textfield" name="password" placeholder="Password">
                        <input type="submit" name="login" value="Login">
                        <input type="submit" name="sign_up" value="Sign up">
                    </form> 
            <!-- <img id="escudoMexico" src="escudoMex.png" width="100" height="100"> -->
        </div> 
    </head>

    <body onload="load_current_vacations_to_table()"> 
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
                    <tr>
                    </tr>
                </table>
            </form>
        </div>
    
    </body>
</html>