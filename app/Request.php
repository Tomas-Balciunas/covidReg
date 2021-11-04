<?php

namespace Visma;

class Request {
    public static function uri() {
        return str_replace("/visma", "", trim($_SERVER['REQUEST_URI']));
    }
}