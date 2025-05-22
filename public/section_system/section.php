<?php
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "addSection"):
			// dump($_POST);

			$sectionId = create_trackid("SEC");
				query("insert INTO section (section_id, section, status) 
				VALUES(?,?,?)", 
				$sectionId,
				$_POST["section"], "ACTIVE"
				);

		
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Success on updating data",
					"link" => "section",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
		elseif($_POST["action"] == "deleteSection"):
			$advisory = query("select * from advisory where section_id = ?", $_POST["section_id"]);
			if(!empty($advisory)):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Failed to Delete! Section already been added to an Advisory Class!",
					// "link" => "schedule?action=gradeTeacher&id=".$_POST["schedule_id"],
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			else:
				query("delete from section where section_id = ?", $_POST["section_id"]);
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Delete Successfully!",
					"link" => "section",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;

		elseif($_POST["action"] == "updateModal"):
			// dump($_POST);

			$html = "";
			$section = query("select * from section where section_id = ?", $_POST["section_id"]);
			$section = $section[0];
			$html.='<input type="hidden" name="section_id" value="'.$_POST["section_id"].'">';
			$html.='<div class="form-group">';
				$html.='<label>Section Name <span class="text-danger">*</span></label>';
				$html.='<input placeholder="Section Name Here!" type="text" class="form-control" name="section" value="'.$section["section"].'">';
			$html.='</div>';

			$active_status = ["ACTIVE", "INACTIVE"];
				$html .= '<div class="form-group">';
				$html .= '<label>Status <span class="text-danger">*</span></label>';
				$html .= '<select class="form-control" name="status">';

				foreach ($active_status as $row):
					$selected = ($section['status'] == $row) ? 'selected' : '';
					$html .= "<option value=\"$row\" $selected>$row</option>";
				endforeach;

				$html .= '</select>';
				$html .= '</div>';


			// dump($section);

			echo($html);

		elseif($_POST["action"] == "update_section"):
			// dump($_POST);

			query("update section set section = ?, status = ? where section_id = ?", $_POST["section"], $_POST["status"], $_POST["section_id"]);
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Updated Section Successfully!",
					"link" => "section",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();

		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/section_system/sectionList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/section_system/sectionSpecific.php",[
				]);
			endif;
		endif;
	}
?>
