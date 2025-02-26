<?php



	for($i = 0; $i < 3000; $i++){
    if (query("INSERT INTO sampleuuid (Puuid) 
				VALUES(?)", 
				create_uuid("P")) === false)
				{
					dump("Sorry, that operator_no has already been taken!");
				}
	}
?>
