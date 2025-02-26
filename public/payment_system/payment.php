<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "paymentList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$where = " where syid = '".$_REQUEST["syid"]."'";


			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			$order_string = " order by date_paid desc ";
			// dump($_REQUEST);

			if(isset($_REQUEST["from"])):
				if($_REQUEST["from"] != ""):
					$where .= " and date_paid >= '".$_REQUEST["from"]." 00:00:00'";
				endif;
			endif;

			if(isset($_REQUEST["to"])):
				if($_REQUEST["to"] != ""):
					$where .= " and date_paid <= '".$_REQUEST["to"]." 23:59:59'";
				endif;
			endif;

			if(isset($_REQUEST["method"])):
				if($_REQUEST["method"] != ""):
					$where .= " and method_of_payment = '".$_REQUEST["method"]."'";
				endif;
			endif;
		



			$baseQuery = "select * from payment " . $where . $order_string;
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



			// dump($data);




			$i = 0;
			foreach($data as $row):
			

	


				


                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "deleteFee"):
			// dump($_POST);

			query("delete from fees where fees_id = ?", $_POST["fees_id"]);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Fee Deleted Successully",
				"link" => "fees",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		elseif($_POST["action"] == "modalUpdateFee"):

			$fee = query("select * from fees where fees_id = ?", $_POST["fees_id"]);
			// dump($fee);
			$fee = $fee[0];

			$html = '
				<input type="hidden" name="fees_id" value="'.$_POST["fees_id"].'">
				<div class="form-group">
					<label>Grade Level</label>
					<input type="text" class="form-control" disabled value="'.$fee["grade_level"].'">
				</div>
				<div class="form-group">
					<label>Title</label>
					<input required type="text" class="form-control" name="fee_title" value="'.$fee["fee_title"].'">
				</div>
				<div class="form-group">
					<label>Amount</label>
					<input type="number" class="form-control" name="fee_amount" value="'.$fee["fee_amount"].'">
				</div>
				<div class="form-group">
					<label>Type</label>
					<select required class="form-control" name="fee_type">
						<option value="'.$fee["fee_type"].'" selected>'.$fee["fee_type"].'</option>
						<option value="MAIN" >MAIN</option>
						<option value="OTHERS" >OTHERS</option>
					</select>
				</div>
				<div class="form-group">
					<label>Status</label>
					<select required class="form-control" name="status">
						<option value="'.$fee["status"].'" selected>'.$fee["status"].'</option>
						<option value="ACTIVE" >ACTIVE</option>
						<option value="INACTIVE" >INACTIVE</option>
					</select>
				</div>
			';

			echo($html);

		elseif($_POST["action"] == "updateFee"):

			query("update fees set
					fee_title = '".$_POST["fee_title"]."',
					fee_amount = '".$_POST["fee_amount"]."',
					fee_type = '".$_POST["fee_type"]."',
					status = '".$_POST["status"]."'
					where fees_id = '".$_POST["fees_id"]."'
			
			");


			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Fee Updated Successully",
				"link" => "fees",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

			dump($_POST);


		elseif($_POST["action"] == "addFees"):
			// dump($_POST);


			query("insert INTO fees (grade_level, fee_title, fee_type, fee_amount, status) 
			VALUES(?,?,?,?,?)", 
			$_POST["grade_level"],
			strtoupper($_POST["fee_title"]),
			$_POST["fee_type"],
			$_POST["fee_amount"],
			"ACTIVE",
		);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on updating data",
				"link" => "fees",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		endif;
    }
	else {
		if(!isset($_GET["action"])):
			render("public/payment_system/paymentPage.php",[
			]);
		else:
			if($_GET["action"] == "new"):
				render("public/enrollment_system/newEnrollmentForm.php",[
				]);
			elseif($_GET["action"] == "specific"):
				render("public/enrollment_system/enrollmentSpecific.php",[
				]);
			elseif($_GET["action"] == "profile"):
				render("public/enrollment_system/enrollmentProfileStudent.php",[
				]);
			endif;
		endif;
	}
?>
