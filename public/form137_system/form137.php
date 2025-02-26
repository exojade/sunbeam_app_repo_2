<?php

use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "saveGrades"):
			// dump($_POST);

			query("delete from captureform137_grades where form137_id = ?", $_POST["id"]);

			$form137 = query("select * from captureform137 where form137_id = ?", $_POST["id"]);
			$form137 = $form137[0];

			foreach($_POST["data"] as $row):

					query("insert INTO captureform137_grades (form137_id, first_grading, second_grading, third_grading, 
																fourth_grading, final_rating, remarks, student_id, subject_head_id) 
					VALUES(?,?,?,?,?,?,?,?,?)", 
					$_POST["id"],
					$row["first_grading"],
					$row["second_grading"],
					$row["third_grading"],
					$row["fourth_grading"],
					$row["final_rating"],
					$row["remarks"],
					$form137["student_id"],
					$row["subject_head_id"]
				
				);
			endforeach;
			echo(1);


			elseif($_POST["action"] == "printForm137"):
				// dump($_POST);
	
				$merged_table = query("
				SELECT 
					sy.school_year,
					e.student_id,
					e.enrollment_id AS id,        -- Added enrollment_id
					'ENROLLMENT' AS type
				FROM 
					enrollment e
				JOIN 
					school_year sy ON e.syid = sy.syid
				WHERE 
					e.student_id = ?

				UNION ALL

				SELECT 
					school_year,
					cf.student_id,
					cf.form137_id AS id,          -- Added form137_id
					'CAPTURE' AS type
				FROM 
					captureform137 cf
	
				WHERE 
					cf.student_id = ?


					ORDER BY school_year
			", $_POST["student_id"], $_POST["student_id"]);
				// dump($merged_table);

			$student = query("select * from student where student_id = ?", $_POST["student_id"]);
			$student = $student[0];

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("reports/form137.xlsx");
			$front = $spreadsheet->getSheetByName("Front");
			$back = $spreadsheet->getSheetByName("Back");
			

			$front->setCellValue("E9", strtoupper($student["lastname"]));
			$front->setCellValue("R9", strtoupper($student["firstname"]));
			$front->setCellValue("AD9", strtoupper($student["name_extension"]));
			$front->setCellValue("AQ9", strtoupper($student["middlename"]));
			$front->setCellValue("J10", strtoupper($student["student_id"]));
			$front->setCellValue("V10", $student["birthDate"]);
			$front->setCellValue("AT10", strtoupper($student["sex"]));

			$SchoolDetails = [];
			// $Grades = [];

			$i = 1;
			foreach($merged_table as $row):
				if($i == 1):
					
					if($row["type"] == "CAPTURE"):
						$form137 = query("select * from captureform137 where form137_id = ?", $row["id"]);
						$SchoolDetails[$i]["school_name"] = $form137[0]["school_name"];
						$SchoolDetails[$i]["school_id"] = $form137[0]["school_id"];
						$SchoolDetails[$i]["district"] = $form137[0]["district"];
						$SchoolDetails[$i]["division"] = $form137[0]["division"];
						$SchoolDetails[$i]["region"] = $form137[0]["region"];
						$SchoolDetails[$i]["grade_level"] = $form137[0]["grade_level"];
						$SchoolDetails[$i]["section"] = $form137[0]["section"];
						$SchoolDetails[$i]["school_year"] = $form137[0]["school_year"];
						$SchoolDetails[$i]["adviser_name"] = $form137[0]["adviser_name"];
						$Grades[$i] = [];

						$grades = query("select * from captureform137_grades where form137_id = ?",$row["id"]);
						foreach($grades as $g):
							$Grades[$i][$g["subject_head_id"]] = $g;
						endforeach;



					elseif($row["type"] == "ENROLLMENT"):

					
					$enrollment = query("select concat(teacher_firstname, ' ', teacher_lastname) as adviser_name,
											e.*, sec.section, sy.school_year from enrollment e
											left join advisory a on a.advisory_id = e.advisory_id
											left join section sec on sec.section_id = a.section_id
											left join teacher t on t.teacher_id = a.teacher_id
											left join school_year sy on sy.syid = e.syid
											where e.enrollment_id = ?", $row["id"]);
					$enrollment = $enrollment[0];
					// dump($enrollment);
						$SchoolDetails[$i]["school_name"] = "Sunbeam Christian School of Panabo Inc.";
						$SchoolDetails[$i]["school_id"] = "";
						$SchoolDetails[$i]["district"] = "Panabo";
						$SchoolDetails[$i]["division"] = "Panabo";
						$SchoolDetails[$i]["region"] = "XI";
						$SchoolDetails[$i]["grade_level"] = $enrollment["grade_level"];
						$SchoolDetails[$i]["section"] = $enrollment["section"];
						$SchoolDetails[$i]["school_year"] = $enrollment["school_year"];
						$SchoolDetails[$i]["adviser_name"] = $enrollment["adviser_name"];
						// dump();
						$grades = query("select sg.*, sg.average as final_rating,  sm.subject_head_id from student_grades sg
											left join subjects sub on sub.subject_id = sg.subject_id
											left join subject_main sm on sm.subject_head_id = sub.subject_head_id
											where advisory_id = ? and student_id = ?",$enrollment["advisory_id"], $enrollment["student_id"]);
											$mapeh = query("SELECT
											sg.student_id,
											sub.subject_id,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) AS first_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) AS second_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) AS third_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END) AS fourth_grading,
											sg.advisory_id,
											8.0 AS subject_head_id, -- This will show 8.0 as the subject_head_id for the averaged row
											ROUND(
												(
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
												) / 4, 2
											) AS final_rating, -- Average of all grading periods (rounded to 2 decimal places)
											CASE
												WHEN ROUND(
													(
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
													) / 4, 2
												) >= 75 THEN 'Passed'
												ELSE 'Failed'
											END AS remarks
											
										FROM
											student_grades sg
										JOIN
											subjects sub ON sub.subject_id = sg.subject_id
										JOIN
											subject_main sm ON sm.subject_head_id = sub.subject_head_id
										WHERE
											sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4)
											AND sg.advisory_id = ?
										GROUP BY
											sg.advisory_id
						", $enrollment["advisory_id"]);

						
						foreach($grades as $g):
							$Grades[$i][$g["subject_head_id"]] = $g;
						endforeach;
						// foreach($mapeh as $g):
						// 	$Grades[$i][$g["subject_head_id"]] = $g;
						// endforeach;
						// if($Grades )
						// dump($grades);

					endif;
					$front->setCellValue("D23", strtoupper($SchoolDetails[$i]["school_name"]));
					$front->setCellValue("S23", $SchoolDetails[$i]["school_id"]);
					$front->setCellValue("D24", $SchoolDetails[$i]["district"]);
					$front->setCellValue("I24", $SchoolDetails[$i]["division"]);
					$front->setCellValue("T24", $SchoolDetails[$i]["region"]);
					$front->setCellValue("F25", $SchoolDetails[$i]["grade_level"]);
					$front->setCellValue("J25", $SchoolDetails[$i]["section"]);
					$front->setCellValue("S25", $SchoolDetails[$i]["school_year"]);
					$front->setCellValue("H26", $SchoolDetails[$i]["adviser_name"]);
					foreach($Grades[$i] as $myGrades):
						// dump($myGrades);
						$theRow = 0;
						switch ($myGrades["subject_head_id"]) {
							case 1.0:
								$theRow = 30;
								break;
							case 2.0:
								$theRow = 31;
								break;
							case 3.0:
								$theRow = 32;
								break;
							case 4.0:
								$theRow = 33;
								break;
							case 5.0:
								$theRow = 34;
								break;
							case 6.0:
								$theRow = 35;
								break;
							case 7.0:
								$theRow = 36;
								break;
							case 8.0:
								$theRow = 37;
								break;
							case 8.1:
								$theRow = 38;
								break;
							case 8.2:
								$theRow = 39;
								break;
							case 8.3:
								$theRow = 40;
								break;
							case 8.4:
								$theRow = 41;
								break;
							case 9.0:
								$theRow = 42;
								break;
							default:
								echo "Unknown version";
								break;
						}
						$front->setCellValue("K".$theRow, $myGrades["first_grading"]);
						$front->setCellValue("L".$theRow, $myGrades["second_grading"]);
						$front->setCellValue("N".$theRow, $myGrades["third_grading"]);
						$front->setCellValue("O".$theRow, $myGrades["fourth_grading"]);
						$front->setCellValue("P".$theRow, $myGrades["final_rating"]);
						$front->setCellValue("S".$theRow, $myGrades["remarks"]);
					endforeach;


					elseif($i==2):

					if($row["type"] == "CAPTURE"):
						$form137 = query("select * from captureform137 where form137_id = ?", $row["id"]);
						$SchoolDetails[$i]["school_name"] = $form137[0]["school_name"];
						$SchoolDetails[$i]["school_id"] = $form137[0]["school_id"];
						$SchoolDetails[$i]["district"] = $form137[0]["district"];
						$SchoolDetails[$i]["division"] = $form137[0]["division"];
						$SchoolDetails[$i]["region"] = $form137[0]["region"];
						$SchoolDetails[$i]["grade_level"] = $form137[0]["grade_level"];
						$SchoolDetails[$i]["section"] = $form137[0]["section"];
						$SchoolDetails[$i]["school_year"] = $form137[0]["school_year"];
						$SchoolDetails[$i]["adviser_name"] = $form137[0]["adviser_name"];
						$Grades[$i] = [];

						$grades = query("select * from captureform137_grades where form137_id = ?",$row["id"]);
						foreach($grades as $g):
							$Grades[$i][$g["subject_head_id"]] = $g;
						endforeach;



					elseif($row["type"] == "ENROLLMENT"):


					$enrollment = query("select concat(teacher_firstname, ' ', teacher_lastname) as adviser_name,
											e.*, sec.section, sy.school_year from enrollment e
											left join advisory a on a.advisory_id = e.advisory_id
											left join section sec on sec.section_id = a.section_id
											left join teacher t on t.teacher_id = a.teacher_id
											left join school_year sy on sy.syid = e.syid
											where e.enrollment_id = ?", $row["id"]);
					$enrollment = $enrollment[0];
					// dump($enrollment);
						$SchoolDetails[$i]["school_name"] = "Sunbeam Christian School of Panabo Inc.";
						$SchoolDetails[$i]["school_id"] = "405592";
						$SchoolDetails[$i]["district"] = "Panabo Central";
						$SchoolDetails[$i]["division"] = "Panabo";
						$SchoolDetails[$i]["region"] = "XI";
						$SchoolDetails[$i]["grade_level"] = $enrollment["grade_level"];
						$SchoolDetails[$i]["section"] = $enrollment["section"];
						$SchoolDetails[$i]["school_year"] = $enrollment["school_year"];
						$SchoolDetails[$i]["adviser_name"] = $enrollment["adviser_name"];

						$grades = query("select sg.*, sg.average as final_rating,  sm.subject_head_id from student_grades sg
											left join subjects sub on sub.subject_id = sg.subject_id
											left join subject_main sm on sm.subject_head_id = sub.subject_head_id
											where advisory_id = ? and student_id = ?",$enrollment["advisory_id"], $enrollment["student_id"]);
											$mapeh = query("SELECT
											sg.student_id,
											sub.subject_id,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) AS first_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) AS second_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) AS third_grading,
											AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END) AS fourth_grading,
											sg.advisory_id,
											8.0 AS subject_head_id, -- This will show 8.0 as the subject_head_id for the averaged row
											ROUND(
												(
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
												) / 4, 2
											) AS final_rating, -- Average of all grading periods (rounded to 2 decimal places)
											CASE
												WHEN ROUND(
													(
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
													) / 4, 2
												) >= 75 THEN 'Passed'
												ELSE 'Failed'
											END AS remarks
											
										FROM
											student_grades sg
										JOIN
											subjects sub ON sub.subject_id = sg.subject_id
										JOIN
											subject_main sm ON sm.subject_head_id = sub.subject_head_id
										WHERE
											sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4)
											AND sg.advisory_id = ?
										GROUP BY
											sg.advisory_id
						", $enrollment["advisory_id"]);
	// dump($mapeh);
						
						foreach($grades as $g):
							$Grades[$i][$g["subject_head_id"]] = $g;
						endforeach;
						foreach($mapeh as $g):
							$Grades[$i][$g["subject_head_id"]] = $g;
						endforeach;
						// if($Grades )
						// dump($Grades);

					endif;
					$front->setCellValue("X23", strtoupper($SchoolDetails[$i]["school_name"]));
					$front->setCellValue("AW23", $SchoolDetails[$i]["school_id"]);
					$front->setCellValue("X24", $SchoolDetails[$i]["district"]);
					$front->setCellValue("AD24", $SchoolDetails[$i]["division"]);
					$front->setCellValue("AX24", $SchoolDetails[$i]["region"]);
					$front->setCellValue("Z25", $SchoolDetails[$i]["grade_level"]);
					$front->setCellValue("AE25", $SchoolDetails[$i]["section"]);
					$front->setCellValue("AU25", $SchoolDetails[$i]["school_year"]);
					$front->setCellValue("AC26", $SchoolDetails[$i]["adviser_name"]);
					foreach($Grades[$i] as $myGrades):
						// dump($myGrades);
						$theRow = 0;
						switch ($myGrades["subject_head_id"]) {
							case 1.0:
								$theRow = 30;
								break;
							case 2.0:
								$theRow = 31;
								break;
							case 3.0:
								$theRow = 32;
								break;
							case 4.0:
								$theRow = 33;
								break;
							case 5.0:
								$theRow = 34;
								break;
							case 6.0:
								$theRow = 35;
								break;
							case 7.0:
								$theRow = 36;
								break;
							case 8.0:
								$theRow = 37;
								break;
							case 8.1:
								$theRow = 38;
								break;
							case 8.2:
								$theRow = 39;
								break;
							case 8.3:
								$theRow = 40;
								break;
							case 8.4:
								$theRow = 41;
								break;
							case 9.0:
								$theRow = 42;
								break;
							default:
								echo "Unknown version";
								break;
						}
						$front->setCellValue("AJ".$theRow, $myGrades["first_grading"]);
						$front->setCellValue("AM".$theRow, $myGrades["second_grading"]);
						$front->setCellValue("AO".$theRow, $myGrades["third_grading"]);
						$front->setCellValue("AR".$theRow, $myGrades["fourth_grading"]);
						$front->setCellValue("AT".$theRow, $myGrades["final_rating"]);
						$front->setCellValue("AW".$theRow, $myGrades["remarks"]);
					endforeach;









					elseif($i==3):

						if($row["type"] == "CAPTURE"):
							$form137 = query("select * from captureform137 where form137_id = ?", $row["id"]);
							$SchoolDetails[$i]["school_name"] = $form137[0]["school_name"];
							$SchoolDetails[$i]["school_id"] = $form137[0]["school_id"];
							$SchoolDetails[$i]["district"] = $form137[0]["district"];
							$SchoolDetails[$i]["division"] = $form137[0]["division"];
							$SchoolDetails[$i]["region"] = $form137[0]["region"];
							$SchoolDetails[$i]["grade_level"] = $form137[0]["grade_level"];
							$SchoolDetails[$i]["section"] = $form137[0]["section"];
							$SchoolDetails[$i]["school_year"] = $form137[0]["school_year"];
							$SchoolDetails[$i]["adviser_name"] = $form137[0]["adviser_name"];
							$Grades[$i] = [];
	
							$grades = query("select * from captureform137_grades where form137_id = ?",$row["id"]);
							foreach($grades as $g):
								$Grades[$i][$g["subject_head_id"]] = $g;
							endforeach;
	
	
	
						elseif($row["type"] == "ENROLLMENT"):
	
	
						$enrollment = query("select concat(teacher_firstname, ' ', teacher_lastname) as adviser_name,
												e.*, sec.section, sy.school_year from enrollment e
												left join advisory a on a.advisory_id = e.advisory_id
												left join section sec on sec.section_id = a.section_id
												left join teacher t on t.teacher_id = a.teacher_id
												left join school_year sy on sy.syid = e.syid
												where e.enrollment_id = ?", $row["id"]);
						$enrollment = $enrollment[0];
						// dump($enrollment);
							$SchoolDetails[$i]["school_name"] = "Sunbeam Christian School of Panabo Inc.";
							$SchoolDetails[$i]["school_id"] = "";
							$SchoolDetails[$i]["district"] = "Panabo";
							$SchoolDetails[$i]["division"] = "Panabo";
							$SchoolDetails[$i]["region"] = "XI";
							$SchoolDetails[$i]["grade_level"] = $enrollment["grade_level"];
							$SchoolDetails[$i]["section"] = $enrollment["section"];
							$SchoolDetails[$i]["school_year"] = $enrollment["school_year"];
							$SchoolDetails[$i]["adviser_name"] = $enrollment["adviser_name"];
	
							$grades = query("select sg.*, sg.average as final_rating,  sm.subject_head_id from student_grades sg
												left join subjects sub on sub.subject_id = sg.subject_id
												left join subject_main sm on sm.subject_head_id = sub.subject_head_id
												where advisory_id = ? and student_id = ?",$enrollment["advisory_id"], $enrollment["student_id"]);
												$mapeh = query("SELECT
												sg.student_id,
												sub.subject_id,
												AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) AS first_grading,
												AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) AS second_grading,
												AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) AS third_grading,
												AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END) AS fourth_grading,
												sg.advisory_id,
												8.0 AS subject_head_id, -- This will show 8.0 as the subject_head_id for the averaged row
												ROUND(
													(
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
														AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
													) / 4, 2
												) AS final_rating, -- Average of all grading periods (rounded to 2 decimal places)
												CASE
													WHEN ROUND(
														(
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
														) / 4, 2
													) >= 75 THEN 'Passed'
													ELSE 'Failed'
												END AS remarks
												
											FROM
												student_grades sg
											JOIN
												subjects sub ON sub.subject_id = sg.subject_id
											JOIN
												subject_main sm ON sm.subject_head_id = sub.subject_head_id
											WHERE
												sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4)
												AND sg.advisory_id = ?
											GROUP BY
												sg.advisory_id
							", $enrollment["advisory_id"]);
		// dump($mapeh);
							
							foreach($grades as $g):
								$Grades[$i][$g["subject_head_id"]] = $g;
							endforeach;
							foreach($mapeh as $g):
								$Grades[$i][$g["subject_head_id"]] = $g;
							endforeach;
							// if($Grades )
							// dump($Grades);
	
						endif;
						$front->setCellValue("D52", strtoupper($SchoolDetails[$i]["school_name"]));
						$front->setCellValue("S52", $SchoolDetails[$i]["school_id"]);
						$front->setCellValue("D53", $SchoolDetails[$i]["district"]);
						$front->setCellValue("I53", $SchoolDetails[$i]["division"]);
						$front->setCellValue("T53", $SchoolDetails[$i]["region"]);
						$front->setCellValue("F54", $SchoolDetails[$i]["grade_level"]);
						$front->setCellValue("J54", $SchoolDetails[$i]["section"]);
						$front->setCellValue("S54", $SchoolDetails[$i]["school_year"]);
						$front->setCellValue("H55", $SchoolDetails[$i]["adviser_name"]);
						foreach($Grades[$i] as $myGrades):
							// dump($myGrades);
							$theRow = 0;
							switch ($myGrades["subject_head_id"]) {
								case 1.0:
									$theRow = 60;
									break;
								case 2.0:
									$theRow = 61;
									break;
								case 3.0:
									$theRow = 62;
									break;
								case 4.0:
									$theRow = 63;
									break;
								case 5.0:
									$theRow = 64;
									break;
								case 6.0:
									$theRow = 65;
									break;
								case 7.0:
									$theRow = 66;
									break;
								case 8.0:
									$theRow = 67;
									break;
								case 8.1:
									$theRow = 68;
									break;
								case 8.2:
									$theRow = 69;
									break;
								case 8.3:
									$theRow = 70;
									break;
								case 8.4:
									$theRow = 71;
									break;
								case 9.0:
									$theRow = 72;
									break;
								default:
									echo "Unknown version";
									break;
							}
							$front->setCellValue("K".$theRow, $myGrades["first_grading"]);
							$front->setCellValue("L".$theRow, $myGrades["second_grading"]);
							$front->setCellValue("N".$theRow, $myGrades["third_grading"]);
							$front->setCellValue("O".$theRow, $myGrades["fourth_grading"]);
							$front->setCellValue("P".$theRow, $myGrades["final_rating"]);
							$front->setCellValue("S".$theRow, $myGrades["remarks"]);
						endforeach;




						elseif($i==4):

							if($row["type"] == "CAPTURE"):
								$form137 = query("select * from captureform137 where form137_id = ?", $row["id"]);
								$SchoolDetails[$i]["school_name"] = $form137[0]["school_name"];
								$SchoolDetails[$i]["school_id"] = $form137[0]["school_id"];
								$SchoolDetails[$i]["district"] = $form137[0]["district"];
								$SchoolDetails[$i]["division"] = $form137[0]["division"];
								$SchoolDetails[$i]["region"] = $form137[0]["region"];
								$SchoolDetails[$i]["grade_level"] = $form137[0]["grade_level"];
								$SchoolDetails[$i]["section"] = $form137[0]["section"];
								$SchoolDetails[$i]["school_year"] = $form137[0]["school_year"];
								$SchoolDetails[$i]["adviser_name"] = $form137[0]["adviser_name"];
								$Grades[$i] = [];
		
								$grades = query("select * from captureform137_grades where form137_id = ?",$row["id"]);
								foreach($grades as $g):
									$Grades[$i][$g["subject_head_id"]] = $g;
								endforeach;
		
		
		
							elseif($row["type"] == "ENROLLMENT"):
		
		
							$enrollment = query("select concat(teacher_firstname, ' ', teacher_lastname) as adviser_name,
													e.*, sec.section, sy.school_year from enrollment e
													left join advisory a on a.advisory_id = e.advisory_id
													left join section sec on sec.section_id = a.section_id
													left join teacher t on t.teacher_id = a.teacher_id
													left join school_year sy on sy.syid = e.syid
													where e.enrollment_id = ?", $row["id"]);
							$enrollment = $enrollment[0];
							// dump($enrollment);
								$SchoolDetails[$i]["school_name"] = "Sunbeam Christian School of Panabo Inc.";
								$SchoolDetails[$i]["school_id"] = "";
								$SchoolDetails[$i]["district"] = "Panabo";
								$SchoolDetails[$i]["division"] = "Panabo";
								$SchoolDetails[$i]["region"] = "XI";
								$SchoolDetails[$i]["grade_level"] = $enrollment["grade_level"];
								$SchoolDetails[$i]["section"] = $enrollment["section"];
								$SchoolDetails[$i]["school_year"] = $enrollment["school_year"];
								$SchoolDetails[$i]["adviser_name"] = $enrollment["adviser_name"];
		
								$grades = query("select sg.*, sg.average as final_rating,  sm.subject_head_id from student_grades sg
													left join subjects sub on sub.subject_id = sg.subject_id
													left join subject_main sm on sm.subject_head_id = sub.subject_head_id
													where advisory_id = ? and student_id = ?",$enrollment["advisory_id"], $enrollment["student_id"]);
													$mapeh = query("SELECT
													sg.student_id,
													sub.subject_id,
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) AS first_grading,
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) AS second_grading,
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) AS third_grading,
													AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END) AS fourth_grading,
													sg.advisory_id,
													8.0 AS subject_head_id, -- This will show 8.0 as the subject_head_id for the averaged row
													ROUND(
														(
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
															AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
														) / 4, 2
													) AS final_rating, -- Average of all grading periods (rounded to 2 decimal places)
													CASE
														WHEN ROUND(
															(
																AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.first_grading END) +
																AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.second_grading END) +
																AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.third_grading END) +
																AVG(CASE WHEN sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4) THEN sg.fourth_grading END)
															) / 4, 2
														) >= 75 THEN 'Passed'
														ELSE 'Failed'
													END AS remarks
													
												FROM
													student_grades sg
												JOIN
													subjects sub ON sub.subject_id = sg.subject_id
												JOIN
													subject_main sm ON sm.subject_head_id = sub.subject_head_id
												WHERE
													sm.subject_head_id IN (8.1, 8.2, 8.3, 8.4)
													AND sg.advisory_id = ?
												GROUP BY
													sg.advisory_id
								", $enrollment["advisory_id"]);
			// dump($mapeh);
								
								foreach($grades as $g):
									$Grades[$i][$g["subject_head_id"]] = $g;
								endforeach;
								foreach($mapeh as $g):
									$Grades[$i][$g["subject_head_id"]] = $g;
								endforeach;
								// if($Grades )
								// dump($Grades);
		
							endif;
							$front->setCellValue("X52", strtoupper($SchoolDetails[$i]["school_name"]));
							$front->setCellValue("AW52", $SchoolDetails[$i]["school_id"]);
							$front->setCellValue("X53", $SchoolDetails[$i]["district"]);
							$front->setCellValue("AD53", $SchoolDetails[$i]["division"]);
							$front->setCellValue("AU53", $SchoolDetails[$i]["region"]);
							$front->setCellValue("Z54", $SchoolDetails[$i]["grade_level"]);
							$front->setCellValue("AE54", $SchoolDetails[$i]["section"]);
							$front->setCellValue("AU4", $SchoolDetails[$i]["school_year"]);
							$front->setCellValue("AC55", $SchoolDetails[$i]["adviser_name"]);
							foreach($Grades[$i] as $myGrades):
								// dump($myGrades);
								$theRow = 0;
								switch ($myGrades["subject_head_id"]) {
									case 1.0:
										$theRow = 60;
										break;
									case 2.0:
										$theRow = 61;
										break;
									case 3.0:
										$theRow = 62;
										break;
									case 4.0:
										$theRow = 63;
										break;
									case 5.0:
										$theRow = 64;
										break;
									case 6.0:
										$theRow = 65;
										break;
									case 7.0:
										$theRow = 66;
										break;
									case 8.0:
										$theRow = 67;
										break;
									case 8.1:
										$theRow = 68;
										break;
									case 8.2:
										$theRow = 69;
										break;
									case 8.3:
										$theRow = 70;
										break;
									case 8.4:
										$theRow = 71;
										break;
									case 9.0:
										$theRow = 72;
										break;
									default:
										echo "Unknown version";
										break;
								}
								$front->setCellValue("AJ".$theRow, $myGrades["first_grading"]);
								$front->setCellValue("AM".$theRow, $myGrades["second_grading"]);
								$front->setCellValue("AO".$theRow, $myGrades["third_grading"]);
								$front->setCellValue("AR".$theRow, $myGrades["fourth_grading"]);
								$front->setCellValue("AT".$theRow, $myGrades["final_rating"]);
								$front->setCellValue("AW".$theRow, $myGrades["remarks"]);
							endforeach;







				endif;
				$i++;
			endforeach;
			// dump($student);

			$fullname = $student["lastname"] . ", " . $student["firstname"];

			$writer = new Xlsx($spreadsheet);
			$filename = "Form 137 - ".$fullname.".xlsx";
			$path = 'reports/'.$filename;
			$writer->save($path);
			$res_arr = [
				"result" => "success",
				"title" => "Downloaded Successfully",
				"message" => "You have successfully downloaded the Form 137! Please click OK to continue",
				"link" => $path,
				"newlink" => "newlink",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

			
		endif;	


		

    }
	else {

		if($_GET["action"] == "getGrades"):
			// dump($_GET);
			$grades = query("select * from captureform137_grades where form137_id = ? order by subject_head_id asc", $_GET["id"]);
			$data = array();
			foreach($grades as $row):
				$datum = array(
					"subject" => $row["subject"],
					"subject_head_id" => $row["subject_head_id"],
					"order_grades" => $row["order_grades"],
					"first_grading" => $row["first_grading"],
					"second_grading" => $row["second_grading"],
					"third_grading" => $row["third_grading"],
					"fourth_grading" => $row["fourth_grading"],
					"final_rating" => $row["final_rating"],
					"remarks" => $row["remarks"]
				);
				$data[] = $datum;
			endforeach;
			echo json_encode($data);

		else:
			render("public/form137_system/form137Form.php",[
			]);
		endif;

		
	}
?>
