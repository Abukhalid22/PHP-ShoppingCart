<?php

namespace Cart\Support\Storage\Contracts;

interface StorageInterface
{
    Public function get($index);
    Public function set($index, $value);
    Public function all();
    Public function exists($index);
    public function unset($index);
    public function clear();

}