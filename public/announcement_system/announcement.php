<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "announcementList"):
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
	
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
				$orderBy = ' order by announcement_id desc';
				$where = " where type='school'";
				$data = query("select * from announcement");
				$all_data = $data;
				$data = query("select * from announcement $where $orderBy $limitString $offsetString ");
				$i = 0;
				// dump(count($data));

				$users = query("select * from users where role in ('admin', 'cashier', 'teacher')");
				$Users = [];
				foreach($users as $row):
					$Users[$row["id"]] = $row;
				endforeach;


				foreach($data as $row):

					// if(count($data) == ($i + 1))
					$theUL = "";
					// if($i == 0):
					// 	$theUL = '<div class="timeline">';
					// endif;
					$data[$i]["announcementText"] = $theUL;
					$data[$i]["announcementText"] .= 
					'
              <div class="card card-widget" >
              <div class="card-header">
                <div class="user-block">
                  <img class="img-circle" src="AdminLTE_new/dist/img/user1-128x128.jpg" alt="User Image">
                  <span class="username"><a href="#">'.$Users[$row["from_sender"]]["fullname"].'</a></span>
                  <span class="description">School Advisory - '.date('F d, Y h:i a', strtotime($row["dateTimePosted"])).'</span>
                </div>
              </div>
              <div class="card-body">
                <!-- post text -->
        
						'.$row["announcement"].'

                <!-- Attachment -->
              
              </div>
          
            </div>
        
						
					';
			// 		$endUL = "";
			// 		if(count($data) == ($i)):
			// 			$endUL = '    
			// 			<div>
            //     <i class="fas fa-clock bg-gray"></i>
            //   </div>
			// 			</div>
			// 			';
			// 		endif;
			// 		$data[$i]["announcementText"] .= $endUL;
					$i++;
				endforeach;
				$json_data = array(
					"draw" => $draw + 1,
					"iTotalRecords" => count($all_data),
					"iTotalDisplayRecords" => count($all_data),
					"aaData" => $data
				);
				echo json_encode($json_data);




				elseif($_POST["action"] == "announcementListAdviser"):
					$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
						$offset = $_POST["start"];
						$limit = $_POST["length"];
						$search = $_POST["search"]["value"];
			
						$limitString = " limit " . $limit;
						$offsetString = " offset " . $offset;
						$orderBy = ' order by announcement_id desc';
		
						$where = " where advisory_id = '".$_REQUEST["adviser_id"]."'";
						$data = query("select * from announcement");
						$all_data = $data;
						$data = query("select * from announcement $where $orderBy $limitString $offsetString ");
						// dump($_REQUEST);
						$i = 0;
						// dump(count($data));
		
						$users = query("select * from users where role in ('admin', 'cashier', 'teacher')");
						$Users = [];
						foreach($users as $row):
							$Users[$row["id"]] = $row;
						endforeach;
		
		
						foreach($data as $row):
		
							// if(count($data) == ($i + 1))
							$theUL = "";
							// if($i == 0):
							// 	$theUL = '<div class="timeline">';
							// endif;
							$data[$i]["announcementText"] = $theUL;
							$data[$i]["announcementText"] .= 
							'
					  <div class="card card-widget" >
					  <div class="card-header">
						<div class="user-block">
						  <img class="img-circle" src="AdminLTE_new/dist/img/user1-128x128.jpg" alt="User Image">
						  <span class="username"><a href="#">'.$Users[$row["from_sender"]]["fullname"].'</a></span>
						  <span class="description">School Advisory - '.date('F d, Y h:i a', strtotime($row["dateTimePosted"])).'</span>
						</div>
					  </div>
					  <div class="card-body">
						<!-- post text -->
				
								'.$row["announcement"].'
		
						<!-- Attachment -->
					  
					  </div>
				  
					</div>
				
								
							';
					// 		$endUL = "";
					// 		if(count($data) == ($i)):
					// 			$endUL = '    
					// 			<div>
					//     <i class="fas fa-clock bg-gray"></i>
					//   </div>
					// 			</div>
					// 			';
					// 		endif;
					// 		$data[$i]["announcementText"] .= $endUL;
							$i++;
						endforeach;
						$json_data = array(
							"draw" => $draw + 1,
							"iTotalRecords" => count($all_data),
							"iTotalDisplayRecords" => count($all_data),
							"aaData" => $data
						);
						echo json_encode($json_data);


						elseif($_POST["action"] == "announcementListParent"):
							$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
								$offset = $_POST["start"];
								$limit = $_POST["length"];
								$search = $_POST["search"]["value"];
					
								$limitString = " limit " . $limit;
								$offsetString = " offset " . $offset;
								$orderBy = ' order by announcement_id desc';

								$school_year = query("select * from school_year where active_status = 'ACTIVE'");
								$school_year = $school_year[0];
								$myStudents = query("select advisory_id from student s
													  left join enrollment e on e.student_id = s.student_id
													   where parent_id = ?
													   and e.syid = ?
													", $_REQUEST["parent"], $school_year["syid"]);
								$myStudents = "'".implode("','", array_column($myStudents, 'advisory_id'))."'";
								// dump($myStudents);
				
								$where = " where advisory_id in (".$myStudents.")";
								$data = query("select * from announcement");
								$all_data = $data;
								$data = query("select * from announcement $where $orderBy $limitString $offsetString ");

								$advisory = query("select * from advisory a
													left join section s on a.section_id = a.section_id");
								$Advisory = [];
								foreach($advisory as $row):
									$Advisory[$row["advisory_id"]] = $row;
								endforeach;
								// dump($advisory);
								// dump($_REQUEST);
								$i = 0;
								// dump(count($data));
				
								$users = query("select * from users where role in ('admin', 'cashier', 'teacher')");
								$Users = [];
								foreach($users as $row):
									$Users[$row["id"]] = $row;
								endforeach;
				
				
								foreach($data as $row):
				
									// if(count($data) == ($i + 1))
									$theUL = "";
									// if($i == 0):
									// 	$theUL = '<div class="timeline">';
									// endif;
									$data[$i]["announcementText"] = $theUL;
									$data[$i]["announcementText"] .= 
									'
							  <div class="card card-widget" >
							  <div class="card-header">
								<div class="user-block">
								  <img class="img-circle" src="AdminLTE_new/dist/img/user1-128x128.jpg" alt="User Image">
								  <span class="username"><a href="#">'.$Users[$row["from_sender"]]["fullname"] .'</a></span>
								  <span class="description">'.$Advisory[$row["advisory_id"]]["grade_level"] . " - " . $Advisory[$row["advisory_id"]]["section"].' - '.date('F d, Y h:i a', strtotime($row["dateTimePosted"])).'</span>
								</div>
							  </div>
							  <div class="card-body">
								<!-- post text -->
						
										'.$row["announcement"].'
				
								<!-- Attachment -->
							  
							  </div>
						  
							</div>
						
										
									';
							// 		$endUL = "";
							// 		if(count($data) == ($i)):
							// 			$endUL = '    
							// 			<div>
							//     <i class="fas fa-clock bg-gray"></i>
							//   </div>
							// 			</div>
							// 			';
							// 		endif;
							// 		$data[$i]["announcementText"] .= $endUL;
									$i++;
								endforeach;
								$json_data = array(
									"draw" => $draw + 1,
									"iTotalRecords" => count($all_data),
									"iTotalDisplayRecords" => count($all_data),
									"aaData" => $data
								);
								echo json_encode($json_data);

		elseif($_POST["action"] == "addAnnouncement"):
			// dump($_POST);


			query("insert INTO announcement (
				announcement,
				from_sender,
				type,
				syid,
				dateTimePosted
				) 
			VALUES(?,?,?,?,?)", 
			$_POST["announcement"],
			$_POST["from_sender"],
			"school",
			$_POST["school_year"],
			date("Y-m-d H:i:s")
		);

		$res_arr = [
			"result" => "success",
			"title" => "Thank You!",
				"message" => "The announcement has been successfully posted!",
			"link" => "refresh",
			// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
			];
			echo json_encode($res_arr); exit();


			elseif($_POST["action"] == "addAnnouncementAdviser"):
				// dump($_POST);
				query("insert INTO announcement (
					announcement,
					from_sender,
					type,
					syid,
					advisory_id,
					dateTimePosted
					) 
				VALUES(?,?,?,?,?,?)", 
				$_POST["announcement"],
				$_POST["from_sender"],
				"advisory",
				$_POST["school_year"],
				$_POST["advisory_id"],
				date("Y-m-d H:i:s")
			);
	
			$res_arr = [
				"result" => "success",
				"title" => "Thank You!",
				"message" => "The announcement has been successfully posted!",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		endif;
		
    }
	else {
		if(!isset($_GET["action"])):
			render("public/announcement_system/announcementForm.php",[
			]);
		else:
			if($_GET["action"] == "announcementAdviser"):
				render("public/announcement_system/announcementAdviserForm.php",[
				]);
			endif;
		endif;
	}
?>
