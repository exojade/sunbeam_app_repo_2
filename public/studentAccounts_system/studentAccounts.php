<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "studentAccountsList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			// $sy = query("select * from school_year where active_status = 'ACTIVE'");
			// $sy = $sy[0];

			// $where = " where syid = '".$sy["syid"]."'";

			$baseQuery = "select * from student";

			// $data = query($baseQuery . $limitString . $offsetString);
			// $all_data = query($baseQuery);



			if($search != ""):
				$baseQuery .= " where firstname like '%".$search."%' or lastname like '%".$search."%'";
				$data = query($baseQuery . $limitString . $offsetString);
			else:
				$data = query($baseQuery . $limitString . $offsetString);
				$all_data = query($baseQuery);
			endif;


			$i=0;
			foreach($data as $row):
				$data[$i]["action"] = '<a href="studentAccounts?action=specific&id='.$row["student_id"].'" class="btn btn-sm btn-block btn-info">Visit</a>';
				$data[$i]["name"] = $row["lastname"] . ", " . $row["firstname"];
				$data[$i]["address"] = $row["city_mun"] . ", " . $row["barangay"] . ", " . $row["address"];
				$i++;
			endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "paymentHistoryListCashier"):
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			$orderString = " order by tbl_id desc"; 
			// dump($_POST);


			// if()

			if(isset($_REQUEST["enrollmentFilterID"])):
				$_REQUEST["enrollment_id"] = $_REQUEST["enrollmentFilterID"];
			endif;



			$where1 = " where enrollment_id = '".$_REQUEST["enrollment_id"]."'";
			$where2 = " where p.enrollment_id = '".$_REQUEST["enrollment_id"]."'";
			$baseQuery = "
			SELECT 
				p.*,
				ef.total_fee,
				(ef.total_fee - SUM(p2.amount_paid)) AS running_balance
			FROM 
				payment p
			LEFT JOIN 
				-- Subquery to calculate the total fees for the specific enrollment_id
				(SELECT enrollment_id, SUM(amount) AS total_fee
				FROM enrollment_fees
				$where1 -- Filter for the specific enrollment_id
				GROUP BY enrollment_id) ef
			ON 
				ef.enrollment_id = p.enrollment_id
			LEFT JOIN 
				-- Self-join to calculate cumulative payments for the same enrollment_id
				payment p2 
			ON 
				p2.enrollment_id = p.enrollment_id AND p2.payment_id <= p.payment_id
			$where2 -- Filter for the specific enrollment_id
			GROUP BY 
				p.payment_id, p.enrollment_id, ef.total_fee, p.amount_paid
			ORDER BY 
				p.payment_id DESC;
			";
			// dump($baseQuery);

	



			$school_year = query("select * from school_year");
			$SY = [];
			foreach($school_year as $row):
				$SY[$row["syid"]] = $row;
			endforeach;

			$data=query($baseQuery);
			$all_data=query($baseQuery);

			$i=0;
			foreach($data as $row):

				$syid = $row["syid"];

				$data[$i]["action"]='<form class="generic_form_trigger" data-url="cashier">
											<input type="hidden" name="action" value="printInvoice">
											<input type="hidden" name="payment_id" value="'.$row["payment_id"].'">
											<button class="btn btn-block btn-info btn-sm">Print Invoice</button>
										</form>';
				$data[$i]["school_year"] = $SY[$syid]["school_year"];
				$data[$i]["date_paid"] = date("F d, Y", strtotime($row["date_paid"]));
				$data[$i]["amount_due"] = $row["amount_paid"];
				$i++;
			endforeach;


			$json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);


			elseif($_POST["action"] == "paymentHistoryList"):
				$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
	
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
				$orderString = " order by payment_id desc"; 
				// dump($_POST);
	
	
				// if()
	
				if(isset($_REQUEST["enrollmentFilterID"])):
					$_REQUEST["enrollment_id"] = $_REQUEST["enrollmentFilterID"];
				endif;
	
	
	
				$where = " where enrollment_id = '".$_REQUEST["enrollment_id"]."'";
				$baseQuery = "select * from payment";
				// dump($baseQuery);
	
				$school_year = query("select * from school_year");
				$SY = [];
				foreach($school_year as $row):
					$SY[$row["syid"]] = $row;
				endforeach;
	
				$data=query($baseQuery . $where . $orderString . $limitString . $offsetString);
				$all_data=query($baseQuery . $where . $orderString);
	
				$i=0;
				foreach($data as $row):
					$payment_id = $row["payment_id"];
					$data[$i]["action"]='<form class="generic_form_trigger" data-url="cashier" data-title="Print Invoice" data-message="Are you sure you want to download and print the invoice?">
												<input type="hidden" name="action" value="printInvoice">
												<input type="hidden" name="payment_id" value="'.$row["payment_id"].'">
												<button class="btn btn-block btn-info btn-sm">Print Invoice</button>
											</form>';
					$data[$i]["school_year"] = $SY[$row["syid"]]["school_year"];
					$data[$i]["date_paid"] = date('F d, Y h:i a', strtotime($row["date_paid"]));
					$data[$i]["or_number"] = $row["or_number"];
					$data[$i]["type"] = $row["method_of_payment"];
					$data[$i]["amount_due"] = $row["amount_paid"];
					$i++;
				endforeach;
	
	
				$json_data = array(
					"draw" => $draw + 1,
					"iTotalRecords" => count($all_data),
					"iTotalDisplayRecords" => count($all_data),
					"aaData" => $data
				);
				echo json_encode($json_data);

		elseif($_POST["action"] == "soaList"):
				$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
	
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
				// dump($_POST);

		
	
				$where = " where enrollment_id = '".$_REQUEST["enrollment_id"]."'";
				$baseQuery = "select * from enrollment_fees";
	
				$school_year = query("select * from enrollment e left join school_year sy
										on sy.syid = e.syid
										where e.enrollment_id = ?", $_REQUEST["enrollment_id"]);


			
	
				$data=query($baseQuery . $where . $limitString . $offsetString);
				$all_data=query($baseQuery . $where);
	
				$i=0;
				foreach($data as $row):
					$data[$i]["school_year"] = $school_year[0]["school_year"];
					$i++;
				endforeach;
	
	
				$json_data = array(
					"draw" => $draw + 1,
					"iTotalRecords" => count($all_data),
					"iTotalDisplayRecords" => count($all_data),
					"aaData" => $data
				);
				echo json_encode($json_data);


		elseif($_POST["action"] == "printSOA"):

			$enrollment_fees = query("select * from enrollment_fees where enrollment_id = ?", $_POST["enrollment_id"]);
			$enrollment = query("select * from enrollment where enrollment_id = ?", $_POST["enrollment_id"]);
			$enrollment = $enrollment[0];
			// dump($enrollment);
			$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
			$student = $student[0];
			$payment = query("select * from payment where enrollment_id = ?", $_POST["enrollment_id"]);
			$advisory = query("select a.*, s.section from advisory a
								left join section s
								on s.section_id = a.section_id
								where advisory_id = ?", $enrollment["advisory_id"]);

			if(!empty($advisory)):
				$advisory = $advisory[0];
			endif;

			
			$downpayment = query("select * from payment where enrollment_id = ? and remarks='DOWNPAYMENT'", $_POST["enrollment_id"]);
			$downpayment = $downpayment[0];
					$mpdf = new \Mpdf\Mpdf([
						'mode' => 'utf-8', 'format' => 'A4',
						'debug' => true,
						'margin_top' => 15,
						'margin_left' => 5,
						'margin_right' => 5,
						'margin_bottom' => 5,
						'margin_footer' => 1,
						'default_font' => 'helvetica'
					]);
					// dump($mpdf);
					$html = "";
					$html .='
					<link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
					<link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
					<link rel="stylesheet" href="AdminLTE/dist/css/skins/_all-skins.min.css">
					<style>
					.table, th, td, thead, tbody{
						border: 2px solid black !important;
						padding: 3px !important;
					}
					h5{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 15px !important;
						font-weight: 800;
					}
					h4{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 100px !important;
						font-weight: 800;
					}
					h5{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 90px !important;
					}

					b{
						font-weight: bold;
					}
					</style>
					<div class="row">
						<div class="col-xs-2">
							<div class="text-center"><img src="resources/logo.png" width="85" height="85" class="img-responsive"></div>
						</div>
						<div class="col-xs-7">
							<h4 class="text-center"><b>SUNBEAM CHRISTIAN SCHOOL OF PANABO INC.</b></h4>
							<h5 class="text-center"><b>San Isidro St., Prk. Daisy Brgy Gredu, Panabo City</b></h5>
							<h5 class="text-center"><b>"The School Where True Wisdom Begins"</b></h5>
						</div>
					</div>

					<div class="background">
					<hr>
					<h1 style="margin-top:-10px;" class="text-center"><b>STATEMENT OF ACCOUNT</b></h1>
					<br>
					<div class="row">
					<div class="col-xs-12">
							<h5><b>STUDENT LEARNER ID:</b> '.$student["student_id"].'</h5>
						</div>
						<div class="col-xs-6">
							<h5><b>STUDENT NAME:</b> '.$student["lastname"] . ", " . $student["firstname"].'</h5>
						</div>
						<div class="col-xs-4">';
						if(!empty($advisory)):
							$html.='<h5><b>CLASS:</b> '.$enrollment["grade_level"] . " - " . $advisory["section"].'</h5>';
						else:
							$html.='<h5><b>CLASS:</b> '.$enrollment["grade_level"].'</h5>';
						endif;

						$html.='
						</div>
					</div>
					<br>

					<table id="feeTable" class="table table-bordered">
							
						<tbody>
						<td colspan="2" class="text-center">Enrollment Fees</td>
						';
						$total = 0;
						foreach($enrollment_fees as $row):
							$total+=$row["amount"];
							$html.='<tr>';
								$html.='<td><b>'.$row["fee"].'</b></td>';
								$html.='<td class="text-right">'.to_peso($row["amount"]).'</td>';
							$html.='</tr>';
							

						endforeach;
						$html.='<tr>';
								$html.='<td class="text-right"><b>Total</b></td>';
								$html.='<td class="text-right">'.to_peso($total).'</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Downpayment (Upon Enrollment)</b></td>';
								$html.='<td class="text-right">('.to_peso($downpayment["amount_paid"]).')</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Balance (Total Enrollment Fee - Downpayment)</b></td>';
								$html.='<td class="text-right">'.to_peso($total - $downpayment["amount_paid"]).'</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Installment per Exam (total / 10)</b></td>';
								$html.='<td class="text-right">'.to_peso($enrollment["per_month"]).'</td>';
							$html.='</tr>';

					$html.='	</tbody>

					</table>
					
					<hr>
					<h3>Payment</h3>

					<table id="feeTable" class="table table-bordered">
				
						<tbody>
						<tr>
							<td><b>Date Paid</b></td>
							<td><b>Amount Paid</b></td>
							<td><b>Remarks</b></td>
							<td><b>OR Number</b></td>
							<td><b>Outstanding Balance</b></td>
						</tr>
						';	
						$total = 0;
						foreach($payment as $row):
							
							$html.='<tr>';
								$html.='<td>'.date("F d, Y", strtotime($row["date_paid"])).'</td>';
								$html.='<td >'.to_peso($row["amount_paid"]).'</td>';
								$html.='<td >'.($row["remarks"]).'</td>';
								$html.='<td >'.($row["or_number"]).'</td>';
								$html.='<td >'.to_peso($enrollment["balance"]).'</td>';
							$html.='</tr>';
							

						endforeach;
					

					$html.='	</tbody>

					</table>
					</div>

					<div style="position: absolute; bottom: 0; left: 0; right: 0; text-align: center; border-top:2px solid black;padding-top:20px; padding-bottom: 10px;">
					<div class="row">
						<div class="col-xs-10" style="padding-left: 30px;">
							<p style="text-align: left;"><b>For more info contact us:</b></p>
							<p style="text-align: left;"><b>Mobile:</b> 0910-6538-730 (<b>TNT</b>) / 0966-3524-915 (<b>GLOBE</b>)</p>
							<p style="text-align: left;"><b>FB Page:</b> Sunbeam Christian School of Panabo</p>
						</div>
					</div>
				</div>
					';

					$filename = "SOA";
					$path = "reports/".$filename.".pdf";
					$mpdf->WriteHTML($html);
					$mpdf->Output($path, \Mpdf\Output\Destination::FILE);

					$res_arr = [
						"result" => "success",
						"title" => "Success",
						"newlink" => "newlink",
						"message" => "PDF success",
						"link" => $path,
						// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
						];
						echo json_encode($res_arr); exit();
					// dump($mpdf);
		elseif($_POST["action"] == "payment"):
			// dump($_POST);

			$school_year= query("select * from enrollment where enrollment_id = ?", $_POST["enrollment_id"]);
			$student = $school_year[0]["student_id"];
			// dump($student);
			$school_year = $school_year[0]["syid"];
			
			// $latest_installment = query("select * from installment where is_paid = 'DONE' and enrollment_id = ? order by installment_number desc", $_POST["enrollment_id"]);
			// $latest_installment = $latest_installment[0];

			$latest_payment = query("select * from payment_installment where enrollment_id = ? order by tbl_id desc", $_POST["enrollment_id"]);
			$latest_payment = $latest_payment[0];
			if($latest_payment["to_balance"] == 0):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "NO BALANCE FOR THIS SCHOOL YEAR",
					// "link" => "teacher",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;

			if($latest_payment["to_balance"] < $_POST["amount"]):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Payment should not exceed " . to_peso($latest_installment["to_balance"]),
					// "link" => "teacher",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;

			// dump($_POST);


			$amount_paid = $_POST["amount"];
			$enrollment_id = $_POST["enrollment_id"];
			$or_number = $_POST["or_number"];
			$paid_by = $_POST["paid_by"];





			function handleInstallmentPayments($enrollment_id, $amount_paid, $or_number, $paid_by, $latest_payment, $school_year) {
				// Get the latest installment's details
				$result = query("SELECT * FROM installment WHERE enrollment_id = ? and is_paid IN ('DONE', 'PROMISSORY', 'CREDIT') ORDER BY installment_number DESC LIMIT 1", $enrollment_id);
				$result = $result[0];
				// dump($result);
				
				// $stmt = $conn->prepare($query);
				// $stmt->bind_param("s", $enrollment_id);
				// $stmt->execute();
				$latest_installment_id = $result["installment_id"];
				$amount_due = $result["amount_due"];
				// $credit_balance = $latest_payment["credit_balance"];
				$from_balance = $latest_payment["from_balance"];
				$to_balance = $latest_payment["to_balance"];

				// Add the credit balance to the amount paid
				// if ($credit_balance !== null) {
				// 	$amount_paid += $credit_balance;
				// }
			
				// Get unpaid installments for the enrollment_id


				$result = query("SELECT * FROM installment WHERE enrollment_id = ? AND is_paid in ('NOT DONE', 'PROMISSORY', 'CREDIT') ORDER BY installment_number", $enrollment_id);
				// dump($result);
				// Initialize variables
				$remaining_amount = $amount_paid;
				$paid_installments = [];
				$latest_credit_balance = 0;
				$is_credit_balance_applied = false;
				$is_promissory = false;
			
				// Process each unpaid installment
				// dump($amount_paid);
				$i = 0;
				foreach ($result as $row):
					// dump($result);
					$installment_id = $row['installment_id'];
					$installment_amount_due = $row['amount_due'];
					// dump($installment_amount_due);
					if ($remaining_amount >= $installment_amount_due) {
						// Full payment for this installment
						// dump($remaining_amount);
						$paid_installments[] = [
							'installment_id' => $installment_id,
							'amount_paid' => $installment_amount_due,
							'amount_due' => $installment_amount_due,
							'is_paid' => 'DONE',
							'actual_payment' => $installment_amount_due
						];
						$remaining_amount -= $installment_amount_due;
					
					} else {
						// dump($i);q

						if($remaining_amount != 0):
							if($i > 0):
								// dump($i);
								// Partial payment; remaining amount applied as credit balance
								
								$paid_installments[] = [
									'installment_id' => $installment_id,
									'amount_due' => $installment_amount_due,
									'amount_paid' => $installment_amount_due - $remaining_amount,
									'is_paid' => 'CREDIT',
									'actual_payment' => $remaining_amount
								];
								// $latest_installment_id = $paid_installments[$i-1]["installment_id"];
								// $latest_credit_balance = $remaining_amount;
								// $remaining_amount = 0;
								// $is_credit_balance_applied = true;
								break;
							else:
								$amountPromissory = $installment_amount_due - $remaining_amount;
								$paid_installments[] = [
									'installment_id' => $installment_id,
									'amount_due' => $installment_amount_due,
									'amount_paid' => $amountPromissory,
									'is_paid' => 'PROMISSORY',
									'actual_payment' => $remaining_amount
								];
								break;
							endif;
						else:
							break;
						endif;
					
					}
					$i++;
				endforeach;

				// dump($paid_installments);	
			
				// If there's any remaining amount, it becomes the credit balance of the latest installment
				// if ($remaining_amount > 0 && $latest_installment_id !== null) {
				// 	$latest_credit_balance = $remaining_amount;
				// }
			
				// Check if the payment was insufficient
				if ($amount_paid < $amount_due) {
					$is_promissory = true;
				}
				
			
				// Insert the payment record
				$payment_type = $is_promissory ? 'PROMISSORY' : 'INSTALLMENT';
				$query = "INSERT INTO payment (enrollment_id, amount_paid, date_paid, method_of_payment, or_number, type, paid_by, syid, cashier) VALUES ('".$enrollment_id."', '".$amount_paid."', NOW(), 'CASH', '".$or_number."', '".$payment_type."', '".$paid_by."', '".$school_year."', '".$_SESSION["sunbeam_app"]["userid"]."')";
				
				
				// $stmt = $conn->prepare($query);
				// $stmt->bind_param("dds", $enrollment_id, $amount_paid, $payment_type);
				// $stmt->execute();
				query($query);
				$payment_id = query("SELECT LAST_INSERT_ID() as payment_id");
				$payment_id = $payment_id[0]["payment_id"];

				if($payment_type == "PROMISSORY"):
					$theLatestInstallment = query("select * from installment where enrollment_id = ?
					and is_paid in ('PROMISSORY', 'NOT DONE', 'CREDIT')
					order by installment_id asc limit 1", $enrollment_id);
					$new_amountDue = $theLatestInstallment[0]["amount_due"] - $amount_paid;
					
					query("update installment set amount_due = ?, is_paid = ?, type = ?, payment_id = ?
					where installment_id = ?", $new_amountDue, "PROMISSORY", "INSTALLMENT", $payment_id,
					$theLatestInstallment[0]["installment_id"]	
				);
				endif;
				// dump($paid_installments);
				// Update the installments table
				// dump($paid_installments);
				foreach ($paid_installments as $installment) {
					
					$from_balance = $to_balance;
					$to_balance = $to_balance - $installment["actual_payment"];

					if($installment["is_paid"] != 'PROMISSORY'):
						$query = "UPDATE installment SET amount_due = '".$installment['amount_paid']."', is_paid = '".$installment['is_paid']."', payment_id = '".$payment_id."'
						WHERE installment_id = '".$installment['installment_id']."'";
						query($query);
					endif;
					$query = "INSERT INTO payment_installment (payment_id, installment_id, enrollment_id, from_balance, to_balance, paid, amount_due) VALUES 
					('".$payment_id."', '".$installment['installment_id']."', '".$enrollment_id."', '".$from_balance."', '".$to_balance."',  '".$installment["actual_payment"]."', '".$installment["amount_due"]."')";
					query($query);

				}
			
				// Update the credit balance for the latest installment
				// if ($latest_installment_id !== null) {
				// 	query("UPDATE installment SET credit_balance = '".$latest_credit_balance."' WHERE installment_id = '".$latest_installment_id."'");
				// }
			
				// $res_arr = [
				// 	"result" => "success",
				// 	"title" => "Success",
				// 	"message" => "PAYMENT SUCCCESS",
				// 	"link" => "studentAccounts?action=specific&id=".$student,
				// 	// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				// 	];
				// 	echo json_encode($res_arr); exit();
			}
			
			// Call the function to handle installment payments
			handleInstallmentPayments($enrollment_id, $amount_paid, $or_number, $paid_by, $latest_payment, $school_year);

			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "PAYMENT SUCCCESS",
				"link" => "studentAccounts?action=specific&id=".$student,
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();


		endif;
    }
	else {
		if(!isset($_GET["action"])):
			render("public/studentAccounts_system/studentAccountsList.php",[
			]);
		else:
			if($_GET["action"] == "new"):
				render("public/enrollment_system/newEnrollmentForm.php",[
				]);
			elseif($_GET["action"] == "specific"):
				render("public/studentAccounts_system/studentAccountsSpecific.php",[
				]);
			elseif($_GET["action"] == "profile"):
				render("public/enrollment_system/enrollmentProfileStudent.php",[
				]);
			elseif($_GET["action"] == "cashier"):
				render("public/enrollment_system/enrollmentCashier.php",[
				]);

			endif;
		endif;
	}
?>
