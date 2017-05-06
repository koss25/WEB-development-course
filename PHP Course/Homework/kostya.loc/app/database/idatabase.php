<?php

interface iDatabase {
 static public function connect();
 static public function addTable($sql);
 static public function dataQuery($sql, $array = null); 
}