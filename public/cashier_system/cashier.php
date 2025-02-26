<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "sendEmailNotification"):

			$payment_settings = query("select * from payment_settings");
			$currentInstallmentNumber = 11;
			if(!empty($payment_settings)):
				$currentInstallmentNumber = $payment_settings[0]["installment_number"];
			endif;
			$sy = query("select * from school_year where active_status = 'ACTIVE'");
			$sy = $sy[0];
			$PaymentBalance = [];
			$payment_balance = query("
            SELECT 
                SUM(CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END) AS total_amount,
				e.enrollment_id, s.parent_id, s.student_id, e.grade_level,
				concat(s.lastname, ', ' , s.firstname) as studentFullname
            FROM 
                installment ins
            left join enrollment e
            on e.enrollment_id = ins.enrollment_id
			left join student s
			on s.student_id= e.student_id
            WHERE 
                ins.installment_number <= ?
                and ins.syid = ?
				and s.parent_id != ''
			group by ins.enrollment_id
            ", $currentInstallmentNumber, $sy["syid"]);
			foreach($payment_balance as $row):
				$PaymentBalance[$row["parent_id"]][$row["student_id"]] = $row;
			endforeach;

			$parents = query("select * from users where role = 'parent'");
			foreach($parents as $row):
				if(isset($PaymentBalance[$row["id"]])):
					$theEmail = $row["username"];
					$message = '
					<html>
						<body>';

					$message.='
					Good Day Mr/Ms/Mrs '.$row["fullname"].'
					<br>
					Greetings from Sunbeam Christian School of Panabo!
					<br>
					<br>
					This email serves as a reminder regarding the outstanding balance for your child(ren) as of '.date('F d Y', strtotime($payment_settings[0]["dueDate"])).'. <br>Below are the details:
					<table>
						<thead>
							<th>Student Name</th>
							<th>Grade Level</th>
							<th>Outstanding Balance</th>
						</thead>
						<tbody>
						';	
					foreach($PaymentBalance[$row["id"]] as $theMessage):
						$message.='
						<tr>
							<td>'.$theMessage["studentFullname"].'</td>
							<td>'.$theMessage["grade_level"].'</td>
							<td>'.to_peso_with_no_prefix($theMessage["total_amount"]).'</td>
						</tr>
						';
					endforeach;
					$message.='
					</tbody>
					</table>
					';

					$message .='
						</body>
					</html>';

					$message .= '
					<br>
					<br>
					For any clarifications, feel free to visit our cashiers office or contact us at [Contact Number] or [Email Address].
<br>
<br>

If payments have already been made, please disregard this email.
<br>
<br>

						Thank you for your prompt attention to this matter.
<br>
<br>
						Sincerely,
						<br>
<br>
						Cashiers Office<br>
						Sunbeam Christian School of Panabo
							
						';

					// dump($message);
						$mail = new PHPMailer();
						try {
							$mail->isSMTP();
							$mail->SMTPAuth = true;
							$mail->SMTPSecure = "ssl";
							$mail->Host = "smtp.gmail.com";
							$mail->Port = "465";
							$mail->isHTML();
							$mail->Username = "bosspanabo2020@gmail.com";
							$mail->Password = "uxjwfplwregzmccz";
							$mail->SetFrom("no-reply@panabocity.gov.ph");
							$mail->Subject = "Outstanding Balance Notification";
							$mail->Body = $message;
							$mail->AddAddress($theEmail);
							$mail->Send();
							$res_arr = [
								"result" => "success",
								"title" => "Success",
								"message" => "Success on updating data",
								"link" => "refresh",
								// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
								];
								echo json_encode($res_arr); exit();
								} catch (phpmailerException $e) {
									$res_arr = [
										"result" => "success",
										"title" => "Success",
										"message" => $e->errorMessage(),
										"link" => "refresh",
										// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
										];
										echo json_encode($res_arr); exit();
								} catch (Exception $e) {
			
									$res_arr = [
										"result" => "success",
										"title" => "Success",
										"message" => $e->getMessage(),
										"link" => "refresh",
										// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
										];
										echo json_encode($res_arr); exit();
								}




				endif;
			endforeach;
      
//    dump($PaymentBalance);





elseif($_POST["action"] == "printInvoice"):
	// dump($_POST);
	$payment = query("SELECT 
    p.*, 
    u.fullname AS cashier, 
    CASE 
        WHEN p.method_of_payment = 'BANK' THEN u2.fullname 
        ELSE NULL 
    END AS paid_by
FROM 
    payment p
LEFT JOIN 
    users u ON u.id = p.cashier
LEFT JOIN 
    users u2 ON u2.id = p.paid_by AND p.method_of_payment = 'BANK'
WHERE 
    p.payment_id = ?", $_POST["payment_id"]);
	$_POST["enrollment_id"] = $payment[0]["enrollment_id"];
	$enrollment_fees = query("select * from enrollment_fees where enrollment_id = ?", $_POST["enrollment_id"]);
	$enrollment = query("select e.*, sy.school_year from enrollment e
	left join school_year sy on sy.syid = e.syid where enrollment_id = ?", $_POST["enrollment_id"]);
	$enrollment = $enrollment[0];
	// dump($enrollment);
	$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
	$student = $student[0];
	// $payment = query("select * from payment where enrollment_id = ?", $_POST["enrollment_id"]);
	$advisory = query("select a.*, s.section from advisory a
						left join section s
						on s.section_id = a.section_id
						where advisory_id = ?", $enrollment["advisory_id"]);

	$payment_installment = query("
	select * from payment_installment pi
	left join payment p
	on p.payment_id = pi.payment_id
	where pi.enrollment_id = ? order by tbl_id desc
	", $_POST["enrollment_id"]);


	// $installment = query("select * from installment i
	// 						left join payment p
	// 						on p.payment_id = i.payment_id
	// 						where i.enrollment_id = ? and is_paid IN ('DONE', 'PROMISSORY')
	// 						order by date_paid desc
	// 						", $_POST["enrollment_id"]);
	// 						dump($installment);
	if(!empty($advisory)):
		$advisory = $advisory[0];
	endif;

	
	$downpayment = query("select * from payment where enrollment_id = ? and type='DOWNPAYMENT'", $_POST["enrollment_id"]);
	// dump($downpayment);
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
			<h1 style="margin-top:-10px;" class="text-center"><b>PAYMENT INVOICE</b></h1>
			<br>
			<div class="row">
			<div class="col-xs-6">
					<h5><b>STUDENT LEARNER ID:</b> '.$student["student_id"].'</h5>
				</div>
				<div class="col-xs-4">
					<h5><b>SCHOOL YEAR:</b> '.$enrollment["school_year"].'</h5>
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
			';



		$breakdown = query("
    SELECT 
    ef.fee_id,
    ef.fee,
    ef.type,
    ef.amount AS original_fee_amount,
    -- Cumulative allocation for all payments up to the current payment
    ROUND((ef.amount / total.total_fee) * cumulative.total_paid_up_to_date, 2) AS cumulative_allocation, 
    -- Allocation of the specific payment
    ROUND((ef.amount / total.total_fee) * current_payment.current_payment, 2) AS allocated_payment,       
    -- Remaining balance after cumulative payments
    ROUND(ef.amount - ((ef.amount / total.total_fee) * cumulative.total_paid_up_to_date), 2) AS remaining_balance 
FROM 
    enrollment_fees ef
JOIN 
    (SELECT 
        enrollment_id,
        SUM(amount_paid) AS total_paid_up_to_date
     FROM 
        payment
     WHERE 
        enrollment_id = (SELECT enrollment_id FROM payment WHERE payment_id = ?)
        AND date_paid <= (SELECT date_paid FROM payment WHERE payment_id = ?)
    ) AS cumulative ON ef.enrollment_id = cumulative.enrollment_id
JOIN 
    (SELECT 
        enrollment_id,
        amount_paid AS current_payment
     FROM 
        payment
     WHERE 
        payment_id = ?
    ) AS current_payment ON ef.enrollment_id = current_payment.enrollment_id
JOIN 
    (SELECT 
        enrollment_id,
        SUM(amount) AS total_fee
     FROM 
        enrollment_fees
     WHERE 
        enrollment_id = (SELECT enrollment_id FROM payment WHERE payment_id = ?)
     GROUP BY 
        enrollment_id
    ) AS total ON ef.enrollment_id = total.enrollment_id
    
", $_POST["payment_id"], $_POST["payment_id"], $_POST["payment_id"], $_POST["payment_id"]);

$html.='
			<div class="background">
			<br>
			<div class="row">
			<div class="col-xs-6">
					<h5><b>Official Receipt No.</b> '.$payment[0]["or_number"].'</h5>
				</div>
				<div class="col-xs-4">
					<h5><b>Paid By</b> '.$payment[0]["paid_by"].'</h5>
				</div>
				
			
				<div class="col-xs-6">
					<h5><b>Date Paid</b> '.date('F d, Y h:i a', strtotime($payment[0]["date_paid"])).'</h5>
				</div>
				<div class="col-xs-4">
					<h5><b>Payment: </b> '.$payment[0]["method_of_payment"].'</h5>
				</div>
		
			</div>
			</div>
			';


			$html.='
			<hr>
			<h3>Payment Breakdown</h3>
			<table id="feeTable" class="table table-bordered">
				<tbody>
				<tr>
					<td style="padding:15px 0 15px 0;"><b>Fee</b></td>
					<td><b>Original Amount</b></td>
					<td><b>Cumulative</b></td>
					<td><b>Payment</b></td>
					<td><b>Remaining Balance</b></td>
				</tr>
				';	
				$total = 0;
				$original_fee_amount = 0;
				$cumulative_allocation = 0;
				$remaining_balance = 0;
				foreach($breakdown as $row):
					// dump($row);
					// $payment = $

					// dump(date("F d, Y", strtotime($row["date_paid"])));

					$original_fee_amount +=floatval($row["original_fee_amount"]);
					$cumulative_allocation +=floatval($row["cumulative_allocation"]);
					$remaining_balance +=floatval($row["remaining_balance"]);
					$html.='<tr>';
						$html.='<td >'.($row["fee"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["original_fee_amount"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["cumulative_allocation"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["allocated_payment"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["remaining_balance"]).'</td>';
					$html.='</tr>';
				endforeach;
			$html.='</tbody>
			<tfoot>
				<tr>
					<td><b>Total</b></td>
					<td class="text-right"><b>'.to_peso($original_fee_amount).'</b></td>
					<td class="text-right"><b>'.to_peso($cumulative_allocation).'</b></td>
					<td class="text-right"><b>'.to_peso($payment[0]["amount_paid"]).'</b></td>
					<td class="text-right"><b>'.to_peso($remaining_balance).'</b></td>
				</tr>
			</tfoot>
			</table>
			</div>';

			
			$html.='

			<style>
                                            .p-2 {
                                                padding: 3px;
                                            }
                                            .u {
                                                border-bottom: 1px solid black;
                                            }
                                            .nw {
                                                white-space:nowrap;
                                            }
                                            .w {
                                                width: 350;
                                            }
                                            #cashierTable th,td {
                                                border: none;
												font-size:13px;
												weight: 400;
                                            }
                                            .tbl {
                                                width: 100%;
                                                border-collapse: collapse;
                                            }
                                            .tbl tr th {
                                                border: 1px inset grey;
                                            }
                                            .tbl tr td {
                                                border: 1px inset grey;
                                                padding: 3px;
                                            }
                                            .center {
                                                text-align: center;
                                            }
                                            .grey {
                                                background-color: lightgrey;
                                            }
                                        </style>
			<br>							
			<br>							
			<br>							
			<table id="cashierTable" width="100%" style="padding-top: 20px;">
                                        <tr><td colspan="2" class="center">Prepared by:</td></tr>
                                        <tr><td colspan="2" class="center">&nbsp;</td></tr>
                                        <tr>
                                            <td></td>
                                            <td class="center nw" width="50%" style="border-bottom:1px solid black;"><strong>'.$payment[0]["cashier"].'</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="center nw" width="50%">CASHIER</td>
                                        </tr>
                                        <tr><td colspan="2">
                                        </td></tr>
                                        </table>
			';

			
			$html.='

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

				// dump($payment);
			$filename = "Invoice - " . $student["lastname"] . ", " . $student["firstname"] . " - " . $payment[0]["or_number"];
			$path = "reports/".$filename.".pdf";
			$mpdf->WriteHTML($html);
			$mpdf->Output($path, \Mpdf\Output\Destination::FILE);

			$res_arr = [
				"result" => "success",
				"title" => "Downloaded Successfully",
				"newlink" => "newlink",
				"message" => "You have successfully downloaded the invoice! Please click OK to continue.",
				"link" => $path,
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

			
			
			






		endif;
    }
?>
