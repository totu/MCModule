<?php

$filters = [
	"all" => "SELECT DISTINCT * FROM Customers",
];



if(!natcasesort($filters)){
	echo 'sorting error'; 
};
?>