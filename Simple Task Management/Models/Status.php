<?php

    enum Status: int {
        case planned = 1;
        case in_progress = 2;
        case complete = 3;
        case cancelled = 4;

        public function Name (int $value): self {
            return match($value) {
                1 => self::planned,
                2 => self::in_progress,
                3 => self::complete,
                4 => self::cancelled,
            };
        }

    };

?>