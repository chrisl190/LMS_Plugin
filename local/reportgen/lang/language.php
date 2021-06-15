<?php

abstract class Language {
    abstract protected function apply_language($page);
    abstract protected function reset_language($page);
    abstract protected function is_RTL();

    public static function newInstance() {
        return new static();
    }
}
