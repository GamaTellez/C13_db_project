// $(window).on('load',function(){
//     $.get("load_current_vacations.php"), function(data) {
//         alert(data);
//     }
// });

var vacation_goers_array = new Array();
var vacations_array = new Array();
var vacation_votes_array = new Array();
//Classes
class VacationGoer {
    constructor(id, username, display_name, password) {
        this.id = id;
        this.username = username;
        this.display_name = display_name;
        this.password = password;
    }
}

class Vacation {
     constructor (id, destination, description, author_goer_id, date_added) {
        this.id = id;
        this.destination = destination;
        this.description = description;
        this.author_goer_id = author_goer_id;
        this.date_added = date_added;
    }
    
    find_Author(vacation_goers_array) {
        vacation_goers_array.forEach(element => {
            if (element.id == this.author_goer_id) {
                return element.username;
            }
        });
        return "not found";
    }
    
    count_votes(vacation_votes_array) {
        var votes_count = 0;
        vacation_votes_array.forEach(element => {
            if (element.vacation_id == this.id) {
                votes_count++;
            }
        });
        return votes_count;
    }
}

class VacationVote {
    constructor (id, author_goer_id, vacation_id) {
        this.id = author_goer_id;
        this.vacation_id = vacation_id;
    }
}

function login_user_with_credentials(username_entered, password_entered) {
    $.ajax({
        type: 'post',
        url: 'vacation_db_controller.php',
        data: {username:username_entered, password:password_entered},
        success: function(output) {
           console.log(output.success)
        }
    });
}

function load_current_vacations_to_table() {
    $.ajax({
        type: 'GET',
        url: 'load_current_vacations.php',
        data: {},
        success: function(objects_array) {
            var object_data_array = JSON.parse(objects_array);
             jQuery.each(object_data_array, function(index, value){
                if (value.hasOwnProperty('username')) {
                    var new_vacation_goer = new VacationGoer(value['id'], value['username'], value['display_name'], 
                                            value['password']);
                    vacation_goers_array.push(new_vacation_goer);
                }
                if (value.hasOwnProperty('destination')) {
                    var new_vacation = new Vacation(value['id'], value['destination'], value['description'],
                    value['author_goer_id'], value['date_added']);
                    vacations_array.push(new_vacation);
                }
                if (value.hasOwnProperty('author_goer_id') && value.hasOwnProperty('vacation_id')) {
                    var new_vacation_vote = new VacationVote(value['id'], value['author_goer_id'], value['vacation_id']);
                    vacation_votes_array.push(new_vacation_vote);
                }
          });
          update_vacations_table();
        }
    });
}

function  update_vacations_table() {
    var vacations_table = document.getElementById("vacationstable");
    vacations_array.forEach(element => {
        var new_row = vacations_table.insertRow(vacations_table.rows.length);
        var new_cell_0 = new_row.insertCell(0);
        new_cell_0.innerHTML = element.destination;
        var new_cell_1 = new_row.insertCell(1);
        new_cell_1.innerHTML = element.find_Author(vacation_goers_array);
        var new_cell_2 = new_row.insertCell(2);
        new_cell_2.innerHTML = element.description;
        var new_cell_3 = new_row.insertCell(3);
        new_cell_3.innerHTML = element.date_added;
        var new_cell_4 = new_row.insertCell(4);
        new_cell_4.innerHTML = element.count_votes(vacation_votes_array);
    });
}