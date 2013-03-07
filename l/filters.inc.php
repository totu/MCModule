<?php

$filters = array(
	"all" => "SELECT DISTINCT * FROM Customers",
);



if(!natcasesort($filters)){
	echo 'sorting error'; 
};
?>