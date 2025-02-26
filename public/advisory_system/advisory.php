<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "advisoryAdd"):
			// dump($sy);

			$currSY = query("select * from school_year where active_status = 'ACTIVE'");
			$currSY = $currSY[0]["syid"];
			
			$advisoryId = create_trackid("ADV");
				query("insert INTO advisory (advisory_id, section_id, grade_level, school_year, teacher_id, max_students) 
				VALUES(?,?,?,?,?,?)", 
				$advisoryId,
				$_POST["section"], $_POST["grade_level"], $currSY, $_POST["teacher"], $_POST["max_students"]
			);
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Success on updating data",
					"link" => "advisory",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			
		elseif($_POST["action"] == "advisoryList"):

			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];


			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
		

			$where = " where sy.active_status = 'ACTIVE'";
			$baseQuery = "select ad.*, sy.school_year as sy from advisory ad left join school_year sy on sy.syid = ad.school_year " . $where;

			$teacher = query("select * from teacher");
			$Teacher = [];
			foreach($teacher as $row):
				$Teacher[$row["teacher_id"]] = $row;
			endforeach;

			$section = query("select * from section");
			$Section = [];
			foreach($section as $row):
				$Section[$row["section_id"]] = $row;
			endforeach;

			$TheAdvisoryCount = [];
			$advisory_count = query("select advisory_id, count(*) as count from enrollment group by advisory_id");
			foreach($advisory_count as $row):
				$TheAdvisoryCount[$row["advisory_id"]] = $row;
			endforeach;
			// dump($TheAdvisoryCount);
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
				
				$data[$i]["action"] = '<a href="advisory?action=specific&id='.$row["advisory_id"].'" class="btn btn-block btn-sm btn-success">View</a>';
				$data[$i]["section"] = $Section[$row["section_id"]]["section"];
				$data[$i]["teacher"] = $Teacher[$row["teacher_id"]]["teacher_lastname"] . ", " . $Teacher[$row["teacher_id"]]["teacher_firstname"];
				if(!isset($TheAdvisoryCount[$row["advisory_id"]])):
					$data[$i]["enrolled"] = 0;
				else:
					$data[$i]["enrolled"] = $TheAdvisoryCount[$row["advisory_id"]]["count"];
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

		elseif($_POST["action"] == "addClass"):
				
			// dump($_POST);
			$schedules = query("select * from schedule where advisory_id = ?", $_POST["advisory_id"]);
			
			foreach($schedules as $row):
				query("insert INTO student_grades (schedule_id, student_id, advisory_id) 
				VALUES(?,?,?)", 
				$row["schedule_id"],
				$_POST["student_id"], $_POST["advisory_id"]
			);
			endforeach;

			query("update enrollment set advisory_id = ? where student_id = ?", $_POST["advisory_id"], $_POST["student_id"]);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on updating data",
				"link" => "advisory?action=specific&id=".$_POST["advisory_id"],
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		

		elseif($_POST["action"] == "gradesModal"):
			// dump($_POST);
			$student = query("select * from student where student_id = ?", $_POST["student_id"]);
			$student = $student[0];

			$grades = query("select g.*,
							sub.subject_code, sched.*,
							concat(teacher_lastname, ', ', teacher_firstname) as teacher
							from student_grades g
							left join advisory a
							on a.advisory_id = g.advisory_id
							left join schedule sched
							on sched.schedule_id = g.schedule_id
							left join subjects sub
							on sub.subject_id = sched.subject_id
							left join teacher t
							on t.teacher_id = sched.teacher_id
							where g.student_id = ? and g.advisory_id = ?
							order by STR_TO_DATE(from_time, '%h:%i %p')
						",$_POST["student_id"], $_POST["advisory_id"]);

			$html = '';
			$html = $html . '
			<h4>Student: '.$student["student_id"]. ' - ' . $student["lastname"] . ', ' . $student["firstname"]. '</h4>
			';

			$html.='
			<table class="table table-bordered">
				<thead>
					<th>Subject</th>
					<th>Schedule</th>
					<th>Teacher</th>
					<th>G1</th>
					<th>G2</th>
					<th>G3</th>
					<th>G4</th>
					<th>Ave</th>
					<th>Remarks</th>
				</thead>
				<tbody>';
				foreach($grades as $row):
					$html .='<tr>';
						$html .='<td>'.$row["subject_code"].'</td>';
						$html .='<td>'.$row["from_time"] . ' - ' . $row["to_time"] .'</td>';
						$html .='<td>'.$row["teacher"] .'</td>';
						$html .='<td>'.$row["first_grading"] .'</td>';
						$html .='<td>'.$row["second_grading"] .'</td>';
						$html .='<td>'.$row["third_grading"] .'</td>';
						$html .='<td>'.$row["fourth_grading"] .'</td>';
						$html .='<td>'.$row["average"] .'</td>';
						$html .='<td>'.$row["remarks"] .'</td>';
					$html .='</tr>';
				endforeach;
			$html .='	</tbody>
			</table>
			';
			// dump($html);
			echo($html);

		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/advisory_system/advisoryList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/advisory_system/advisorySpecific.php",[
				]);
			endif;
		endif;
	}
?>
