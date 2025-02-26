<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "subjectsList"):
			// dump($_POST);
				$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
				$where = " where subjects.subject_type = 'PARENT'";
				$baseQuery = "select subjects.*, sm.subject_head_name from subjects left join subject_main sm
								on sm.subject_head_id = subjects.subject_head_id";
				if($search == ""):
					$data = query($baseQuery . " " . $where . $limitString . " " . $offsetString);
					$all_data = query($baseQuery . " ");
				else:
					$where .= " and (subject_code like '%".$search."%' or subject_title like '%".$search."%' or subject_description like '%".$search."%')";
					$data = query($baseQuery . " " . $where . $limitString . " " . $offsetString);
					$all_data = query($baseQuery . " " . $where);
				endif;
				$i = 0;
				foreach($data as $row):
					$data[$i]["action"] = '
						<form class="generic_form_trigger" data-url="subjects">
							<input type="hidden" name="action" value="deleteSubject">
							<input type="hidden" name="subject_id" value="'.$row["subject_id"].'">
							<button type="submit" class="btn btn-sm btn-danger btn-block">Delete</button>
						</form>
					
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
		elseif($_POST["action"] == "deleteSubject"):
			$schedule = query("select * from schedule where subject_id = ?", $_POST["subject_id"]);
			if(!empty($schedule)):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Failed to Delete! Subject already been added to a schedule!",
					// "link" => "schedule?action=gradeTeacher&id=".$_POST["schedule_id"],
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			else:
				query("delete from subjects where subject_id = ?", $_POST["subject_id"]);
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Delete Successfully!",
					"link" => "subjects",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;



		elseif($_POST["action"] == "addSubject"):
			// dump($_POST);

			if(intval($_POST["subject_head_id"]) != 8):
				$subject_id = create_trackid("SUBJ");
				query("insert INTO subjects (subject_id, subject_code, subject_title, subject_description, subject_head_id, subject_type) 
					VALUES(?,?,?,?,?,?)", 
					$subject_id, $_POST["subject_code"] ,$_POST["subject_name"], $_POST["description"],$_POST["subject_head_id"], "PARENT");
			else:
				$subject_id = create_trackid("SUBJ");
				query("insert INTO subjects (subject_id, subject_code, subject_title, subject_description, subject_head_id, subject_type) 
					VALUES(?,?,?,?,?,?)", 
					$subject_id, $_POST["subject_code"] ,$_POST["subject_name"], $_POST["description"],$_POST["subject_head_id"], "PARENT");

				$mapeh_subjects = array("Music", "Arts", "Physical Education", "Health");
				$i=0;
				$childMain_id = $_POST["subject_head_id"];
				foreach($mapeh_subjects as $row):
					$i++;
					 + 0.1;
					// dump($childMain_id);
					$childMain_id += 0.1;
					$childSubjects = create_trackid("SUBJ");
					query("insert INTO subjects (subject_id, subject_code, subject_title, subject_description, subject_head_id, subject_type, subject_parent_id) 
					VALUES(?,?,?,?,?,?,?)", 
					$childSubjects, "" ,$row, "",floatval($childMain_id), "CHILD", $subject_id);
				endforeach;


			

			endif;



			

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on adding subject",
				"link" => "subjects",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();


		elseif($_POST["action"] == "addSubSubjectModal"):
			// dump($_POST);

			$hint = "";
			$subject = query("select * from subjects s left join subject_main sm on sm.subject_head_id = s.subject_head_id
								where subject_id = ?", $_POST["subject_id"]);

			$hint.='
			<input type="hidden" name="subject_id" value="'.$_POST["subject_id"].'">
			<div class="form-group">
				<label>Subject</label>
				<input class="form-control" disabled value="'.$subject[0]["subject_head_name"].'">
			</div>

			<div class="form-group">
				<input class="form-control" disabled value="'.$subject[0]["subject_title"].'">
			</div>

			<div class="form-group">
				<label>Sub Subject Title</label>
				<input class="form-control" required name="sub_subject" placeholder="Enter Title of Sub Subject">
			</div>

			';

			echo($hint);

		elseif($_POST["action"] == "addSubSubject"):
			// dump($_POST);


			$subject_id = create_trackid("SUBJ");
			query("insert INTO subjects (subject_id, subject_code, subject_title, subject_description, subject_head_id, subject_type, subject_parent_id) 
				VALUES(?,?,?,?,?,?,?)", 
				$subject_id, "" ,$_POST["sub_subject"], "","", "CHILD", $_POST["subject_id"]);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on adding subject",
				"link" => "subjects",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		
		
		endif;
    }
	else {
		render("public/subjects_system/subjects_list.php",[
		]);
	}
?>
