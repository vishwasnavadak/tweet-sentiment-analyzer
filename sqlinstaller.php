<?php

$sql= new mysqli("localhost","DBUSER","PASSWORD","DATABASE");

if($sql->connect_error)
	die("couldnot connect");
else
	echo "connected";

$query="create table if not exists twitter (tweets char(150) primary key,hashtag varchar(20));";
if(!($sql->query($query)))
	echo "<br/>$sql->error";


?>