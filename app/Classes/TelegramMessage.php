<?php

namespace App\Classes;

class TelegramMessage
{
    public $type;
    public $label;
    public $action;
    public $by;

    public function __construct($type, $label, $action, $by)
    {
        $this->type = $type;
        $this->label = $label;
        $this->action = $action;
        $this->by = $by;
    }
}