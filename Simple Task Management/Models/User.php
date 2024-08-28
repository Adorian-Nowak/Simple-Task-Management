<?php

    class User {
        public int $id;
        public string $name;

        public function __construct($name)
        {
            $this->name = $name;
        }

    }

?>