<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		


			// dump($onlinePaymentStudents);


		if($_POST["action"] == "request"):
			// dump($_POST);

			query("insert INTO documentrequest (
				document,
				parent_id,
				student_id,
				request_status,
				dateRequested
				) 
			VALUES(?,?,?,?,?)", 
			$_POST["documentType"],
			$_POST["parent_id"],
			$_POST["student"],
			"PENDING",
			date("Y-m-d H:i:s")
		);



		$res_arr = [
			"result" => "success",
			"title" => "Success",
			"message" => "REQUEST SUCCESSFULLY",
			"link" => "refresh",
			// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
			];
			echo json_encode($res_arr); exit();






			

			

			
		elseif($_POST["action"] == "documentRequestListParent"):
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			$where = " where dr.parent_id = '".$_REQUEST["parent"]."'";
			$baseQuery = "select dr.*, concat(s.lastname, ', ', s.firstname) as student from documentrequest dr
							left join student s
							on s.student_id = dr.student_id
			" . $where . " order by dateRequested desc";

			// dump($baseQuery);

			if($search == ""):
                $data = query($baseQuery . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery);
            else:
                                // dump($query_string);
                $data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'" . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'");
                // $all_data = $data;
            endif;


			$i = 0;
			foreach($data as $row):


				if($row["request_status"] == "PENDING"):
					$data[$i]["action"] = '
					<form class="generic_form_trigger" data-url="documentRequest">
						<input type="hidden" name="action" value="deleteDocument">
						<input type="hidden" name="tblid" value="'.$row["tblid"].'">
						<button class="btn btn-sm btn-danger btn-block" type="submit">Cancel</button>
					</form>
					';
				else:
					$data[$i]["action"] = '
					<form class="generic_form_trigger" data-url="documentRequest">
						<input type="hidden" name="action" value="deleteDocument">
						<input type="hidden" name="tblid" value="'.$row["tblid"].'">
						<button disabled class="btn btn-sm btn-danger btn-block" type="submit">Cancel</button>
					</form>
					';

				endif;
                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

			elseif($_POST["action"] == "documentRequestList"):
				$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
	
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
				$where = " where 1=1";
				$baseQuery = "select dr.*, concat(s.lastname, ', ', s.firstname) as student,
								u.fullname as parent from documentrequest dr
								left join student s
								on s.student_id = dr.student_id
								left join users u on u.id = dr.parent_id
				" . $where . " order by dateRequested desc";
	
				// dump($baseQuery);
	
				if($search == ""):
					$data = query($baseQuery . " " . $limitString . " " . $offsetString);
					$all_data = query($baseQuery);
				else:
									// dump($query_string);
					$data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'" . " " . $limitString . " " . $offsetString);
					$all_data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'");
					// $all_data = $data;
				endif;
	
	
				$i = 0;
				foreach($data as $row):
					$data[$i]["action"] = '
					<a href="#" data-toggle="modal" data-target="#updateStatusModal" data-id="'.$row["tblid"].'" class="btn btn-warning btn-sm btn-block">Update Status</a>
					';
					$i++;
				endforeach;
				$json_data = array(
					"draw" => $draw + 1,
					"iTotalRecords" => count($all_data),
					"iTotalDisplayRecords" => count($all_data),
					"aaData" => $data
				);
				echo json_encode($json_data);

		elseif($_POST["action"] == "updateStatusModal"):
			// dump($_POST);

			$document = query("select * from documentrequest where tblid = ?", $_POST["tblid"]);
			$document = $document[0];
			$hint = '
			<input type="hidden" name="tblid" value="'.$_POST["tblid"].'">
			<div class="form-group">
                    <label>Document Statu</label>
                    <select required class="form-control" name="request_status">
                     <option value="'.$document["request_status"].'">'.$document["request_status"].'</option>
					 <option value="PENDING">PENDING</option>
					 <option value="FOR CLAIM">FOR CLAIM</option>
					 <option value="CLAIMED">CLAIMED</option>
                    </select>
                  </div>
			';

			echo($hint);

		elseif($_POST["action"] == "updateDocumentRequest"):
			// dump($_POST);

			query("update documentrequest set request_status = ? where tblid = ?", $_POST["request_status"], $_POST["tblid"]);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "REQUEST SUCCESSFULLY",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		endif;
    }
	else {
		if(!isset($_GET["action"])):
			if($_SESSION["sunbeam_app"]["role"] == "parent")
				render("public/documentRequest_system/documentRequestParentForm.php",[
			]);
			elseif($_SESSION["sunbeam_app"]["role"] == "admin")
				render("public/documentRequest_system/documentRequestForm.php",[
				]);
			else;
		else:
			if($_GET["action"] == "specific"):
				render("public/teacher_system/teacherSpecific.php",[
				]);
			endif;
		endif;
	}
?>
