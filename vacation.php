<?php
    class Vacation
    {
        public $id;
        public $destination;
        public $description;
        public $author_goer_id;
        public $date_added;
    
        function __construct($id, $destination, $description, $author_goer_id, $date_added)
        {
            $this->id = $id;
            $this->destination = $destination;
            $this->description = $description;
            $this->author_goer_id = $author_goer_id;
            $this->date_added = $date_added;
        }
    
        function getId()
        {
            return $this->id;
        }
    
        function getDestination()
        {
            return $this->destination;
        }
    
        function getDescription()
        {
            return $this->description;
        }
    
        function getAuthorGoerId()
        {
            return $this->author_goer_id;
        }
    
        function getDateAdded()
        {
            return $this->date_added;
        }
    
        function findAuthor($vacation_goers_array)
        {
            for ($i = 0; $i < count($vacation_goers_array); $i++) {
                $goer_at_index = $vacation_goers_array[$i];
                    if ($this->getAuthorGoerId() == $goer_at_index->getId()) {
                    return $goer_at_index->getDisplayName();
                }
            }
        }
    
        function findVotes($vacation_votes)
        {
            $votes_count = 0;
            for ($i = 0; $i < count($vacation_votes); $i++) {
                $vote_at_index = $vacation_votes[$i];
                if ($this->getId() == $vote_at_index->getVacationId()) {
                    $votes_count++;
                }
            }
            return $votes_count;
        }
    }
?>