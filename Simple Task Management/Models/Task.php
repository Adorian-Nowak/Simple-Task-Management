<?php

    class Task {
        public int $id;
        public int $name;
        public ?int $user_id;
        public ?int $assigned_user_id;
        public Status $status_id;

        public function __construct(int $name, ?int $user_id, ?int $assigned_user_id, Status $status_id) 
        {
            $this->name = $name;
            $this->user_id = $user_id;
            $this->assigned_user_id = $assigned_user_id;
            $this->status_id = $status_id;
        }

    }

?>