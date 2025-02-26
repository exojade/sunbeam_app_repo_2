<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "teacherAdd"):
			// dump($_POST);
			$teacherId = create_trackid("T");
				query("insert INTO teacher (teacher_id, teacher_firstname, teacher_middlename, teacher_lastname, teacher_extension,
												teacher_region, teacher_province, teacher_citymun, teacher_barangay, teacher_address,
													college_course, post_graduate_course, teacher_birthdate, teacher_gender,
														teacher_emailaddress, teacher_contactNumber) 
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", 
				$teacherId,
				$_POST["firstname"], $_POST["middlename"], $_POST["lastname"], $_POST["nameExtension"],
				$_POST["region"], $_POST["province"], $_POST["cityMun"], $_POST["barangay"], $_POST["address"],
				$_POST["undergrad_course"], $_POST["postgraduate_course"], $_POST["birthDate"], $_POST["gender"],
				$_POST["email"], $_POST["contactNumber"]
			);

				query("insert INTO users (id, username, password, role, active_remarks ,fullname) 
				VALUES(?,?,?,?,?,?)", 
				$teacherId, $_POST["email"], $hashed_password = password_hash("p@55word", PASSWORD_DEFAULT), "teacher", "active" , $_POST["firstname"] . " " . $_POST["lastname"] . "");

				$res_arr = [
					"result" => "success",
					"title" => "Submitted Successfully",
					"message" => "Thank you! The new teacher has been successfully added.",
					"link" => "teacher",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			
		elseif($_POST["action"] == "teacherList"):

			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];


			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
		



			$where = " where 1=1";


			$baseQuery = "select * from teacher " . $where;


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
				$data[$i]["action"] = '<a href="teacher?action=specific&id='.$row["teacher_id"].'" class="btn btn-block btn-sm btn-success">View</a>';
				$data[$i]["teacher_name"] = $row["teacher_firstname"] . ", " . $row["teacher_lastname"];
                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "teacherClassList"):

			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];
			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			// dump($_POST);

			$where = " where teacher_id = '".$_REQUEST["teacher_id"]."'";
			$order_string = " order by sy.school_year desc";
			if(isset($_REQUEST["syid"])):
				if($_REQUEST["syid"] != ""):
					$where.=" and school_year = '".$_REQUEST["syid"]."'";
				endif;
			endif;
			$baseQuery = "select a.*, sy.school_year, sec.section from advisory a
							left join school_year sy on sy.syid = a.school_year
							left join section sec on sec.section_id = a.section_id
							
							" . $where . $order_string;
			$data = query($baseQuery . $limitString . $offsetString);
			$all_data = query($baseQuery);

			$population = query("SELECT 
                        e.advisory_id,
                        SUM(CASE WHEN s.sex = 'Male' THEN 1 ELSE 0 END) AS male_count, 
                        SUM(CASE WHEN s.sex = 'Female' THEN 1 ELSE 0 END) AS female_count
                     FROM enrollment e
                     LEFT JOIN student s ON s.student_id = e.student_id
                     GROUP BY e.advisory_id");
			// dump($population);

			$Population = [];
			foreach($population as $row):
				$Population[$row["advisory_id"]] = $row;
			endforeach;

			$i = 0;
			foreach($data as $row):
				$data[$i]["action"] = '<a href="advisory?action=specific&id='.$row["advisory_id"].'" target="_blank" class="btn btn-primary btn-sm btn-block">View</a>';
				$data[$i]["class_section"] = $row["grade_level"] . " - " . $row["section"];

				$male = 0;
				$female = 0;
				// dump($Population);
				if(isset($Population[$row["advisory_id"]])):
					
					$male = $Population[$row["advisory_id"]]["male_count"];
					$female = $Population[$row["advisory_id"]]["male_count"];
				endif;

				$data[$i]["male_count"] = $male;
				$data[$i]["female_count"] = $female;


				$i++;
			endforeach;

			$json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "teacherSubjectList"):
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];
			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$where = " where sched.teacher_id = '".$_REQUEST["teacher_id"]."'";
			$order_string = " order by sy.school_year desc";

			$baseQuery = "select sched.*, sub.subject_id, sm.subject_head_name,
			sub.subject_title, sec.section, sy.school_year, adv.grade_level
								 from schedule sched
							left join advisory adv on adv.advisory_id = sched.advisory_id
							left join section sec on sec.section_id = adv.section_id
							left join subjects sub on sub.subject_id = sched.subject_id
							left join subject_main sm on sm.subject_head_id = sub.subject_head_id
							left join school_year sy on sy.syid = sched.syid
			
			" . $where . " group by sched.schedule_id, sched.subject_id " . $order_string ;
			// dump($baseQuery);
			$data = query($baseQuery . $limitString . $offsetString);
			$all_data = query($baseQuery);
			// dump($data);

			$i=0;
			foreach($data as $row):
				$days_string = '';
				if ($row["monday"] == 1) {
				  $days_string .= 'M,';
				}
				if ($row["tuesday"] == 1) {
				  $days_string .= 'T,';
				}
				if ($row["wednesday"] == 1) {
				  $days_string .= 'W,';
				}
				if ($row["thursday"] == 1) {
				  $days_string .= 'TH,';
				}
				if ($row["friday"] == 1) {
				  $days_string .= 'F,';
				}
				// Remove the trailing comma
				$days_string = rtrim($days_string, ',');
				// dump($days_string);


				$data[$i]["action"] = '<a href="#" data-toggle="modal" data-target="#modalViewSchedule" data-schedule_id="'.$row["schedule_id"].'" data-subject_id="'.$row["subject_id"].'" class="btn btn-block btn-sm btn-primary">Details</a>';
				$data[$i]["class"] = $row["grade_level"] . " - " . $row["section"];
				$data[$i]["schedule"] = $row["from_time"] . " - " . $row["to_time"] . " | " .$days_string;

				$i++;
			endforeach;


			// /schedule?action=gradeTeacher&id=SCHED6753F51304046&subject_id=SUBJ3E019105754A7





			$json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "modalScheduleDetails"):
			// dump($_POST);

			$schedule = query($baseQuery = "select sched.*, sub.subject_id, sm.subject_head_name,
			sub.subject_title, sec.section, sy.school_year, adv.grade_level,
			concat(t1.teacher_lastname, ', ', t1.teacher_firstname) as adviser,
			concat(t2.teacher_lastname, ', ', t2.teacher_firstname) as teacher
								 from schedule sched
							left join advisory adv on adv.advisory_id = sched.advisory_id
							left join section sec on sec.section_id = adv.section_id
							left join subjects sub on sub.subject_id = sched.subject_id
							left join subject_main sm on sm.subject_head_id = sub.subject_head_id
							left join school_year sy on sy.syid = sched.syid
							left join teacher t1 on t1.teacher_id = adv.teacher_id
							left join teacher t2 on t2.teacher_id = sched.teacher_id
							where sched.schedule_id = ? and sched.subject_id = ?", $_POST["schedule_id"], $_POST["subject_id"]);
			$schedule = $schedule[0];


			$days_string = '';
				if ($schedule["monday"] == 1) {
				  $days_string .= 'M,';
				}
				if ($schedule["tuesday"] == 1) {
				  $days_string .= 'T,';
				}
				if ($schedule["wednesday"] == 1) {
				  $days_string .= 'W,';
				}
				if ($schedule["thursday"] == 1) {
				  $days_string .= 'TH,';
				}
				if ($schedule["friday"] == 1) {
				  $days_string .= 'F,';
				}
				// Remove the trailing comma
				$days_string = rtrim($days_string, ',');
			$html = '';
			$html.='
			<table class="table" id="sectionTable">
                    <tbody><tr>
                      <th>Section:</th>
                      <td>'.$schedule["grade_level"] . ' - ' . $schedule["section"] .'</td>
                      <th>Adviser:</th>
                      <td>'.$schedule["adviser"].'</td>
                    </tr>
                    <tr>
                      <th>Subject:</th>
                      <td>'.$schedule["subject_head_name"] . ' - ' . $schedule["subject_title"] .'</td>
                      <th>Teacher:</th>
                      <td>'.$schedule["teacher"].'</td>
                    </tr>
                    <tr>
                      <th>Time Schedule:</th>
                      <td>'.$schedule["from_time"] . ' - ' . $schedule["to_time"] .'</td>
                      <th>Day:</th>
                      <td>'.$days_string.'</td>
                    </tr>
                  </tbody></table>
			
			';

			$grades = query("select * from student_grades sg left join student s
							on sg.student_id = s.student_id
							where sg.schedule_id  = ? and sg.subject_id = ?
							order by s.lastname, s.firstname", $schedule["schedule_id"], $schedule["subject_id"]);

			$html.='
			<table class="table table-bordered">
				<thead>
					<th>Student Name</th>
					<th>Sex</th>
					<th>1st</th>
					<th>2nd</th>
					<th>3rd</th>
					<th>4th</th>
					<th>Ave</th>
					<th>Remarks</th>
				</thead>
				<tbody>';
				foreach($grades as $row):
					$html .='<tr>';
						$html .='<td>'.$row["lastname"] . ", " . $row["firstname"].'</td>';
						$html .='<td>'.$row["sex"].'</td>';
						$html .='<td>'.$row["first_grading"].'</td>';
						$html .='<td>'.$row["second_grading"].'</td>';
						$html .='<td>'.$row["third_grading"].'</td>';
						$html .='<td>'.$row["fourth_grading"].'</td>';
						$html .='<td>'.$row["average"].'</td>';
						$html .='<td>'.$row["remarks"].'</td>';
					$html .='<tr>';
				endforeach;
				$html.='
				</tbody>

			</table>
			
			';

			echo($html);


		elseif($_POST["action"] == "teacherEdit"):

			// dump($_POST);


			query("update teacher set
					teacher_firstname = '".$_POST["teacher_firstname"]."',
					teacher_middlename = '".$_POST["teacher_middlename"]."',
					teacher_lastname = '".$_POST["teacher_lastname"]."',
					teacher_extension = '".$_POST["teacher_extension"]."',
					teacher_address = '".$_POST["teacher_address"]."',
					teacher_birthdate = '".$_POST["teacher_birthdate"]."',
					teacher_gender = '".$_POST["teacher_gender"]."',
					teacher_contactNumber = '".$_POST["teacher_contactNumber"]."',
					teacher_emailaddress = '".$_POST["teacher_emailaddress"]."',
					college_course = '".$_POST["college_course"]."',
					post_graduate_course = '".$_POST["post_graduate_course"]."'
						where teacher_id = ?", $_POST["teacher_id"]);

				if(isset($_FILES["profileImage"])):
					$target_pdf = "uploads/profile_images/".$_POST["teacher_id"]."/";
					if (!file_exists($target_pdf )) {
						mkdir($target_pdf , 0777, true);
					}
					if($_FILES["profileImage"]["size"] != 0){
						
						$path_parts = pathinfo($_FILES["profileImage"]["name"]);
						$extension = $path_parts['extension'];
						$target = $target_pdf . "profile_image" . "." . $extension;
							if(!move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)){
								echo("FAMILY Do not have upload files");
								exit();
							}
							query("update teacher set teacher_profile = '".$target."'
							where teacher_id = '".$_POST["teacher_id"]."'");
							// $_SESSION["dnsc_audit"]["img"] = $target;
					}
				endif;

				$res_arr = [
					"result" => "success",
					"title" => "Submitted Successfully",
					"message" => "Thank you! Teacher has been successfully updated!",
					"link" => "refresh",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();




		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/teacher_system/teacherList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/teacher_system/teacherSpecific.php",[
				]);
			endif;
		endif;
	}
?>
