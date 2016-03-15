<?php

interface DataStore
{
    public function fetchOne();
    public function fetchAll();
}