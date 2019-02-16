<?php
    class Vacation_vote
    {
        public $id;
        public $author_goer_id;
        public $vacation_id;
    
        function __construct($id, $author_goer_id, $vacation_id)
        {
            $this->id = $id;
            $this->author_goer_id = $author_goer_id;
            $this->vacation_id = $vacation_id;
        }
    
        function getId()
        {
            return $this->id;
        }
    
        function getAuthorGoerId()
        {
            return $this->author_goer_id;
        }
    
        function getVacationId()
        {
            return $this->vacation_id;
        }
    }
?>