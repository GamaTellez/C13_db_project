<?php
    class Vacation_goer
    {
        public $id;
        public $username;
        public $display_name;
        public $password;
    
        function __construct($id, $username, $password, $display_name)
        {
            $this->id = $id;
            $this->username = $username;
            $this->display_name = $display_name;
            $this->password = $password;
        }
    
        function getUserName()
        {
            return $this->username;
        }
    
        function getId()
        {
            return $this->id;
        }
    
        function getDisplayName()
        {
            return $this->display_name;
        }
    
        function getPassword()
        {
            return $this->password;
        }
    }
?>