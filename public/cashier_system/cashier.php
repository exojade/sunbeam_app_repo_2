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



			// Step 1: Get the payment amounts for the current payment
			$payment_id = $_POST["payment_id"];

// Fetch the selected payment's info
$thepayment = query("SELECT enrollment_id, date_paid FROM payment WHERE payment_id = ?", $payment_id);

$enrollment_id = $thepayment[0]['enrollment_id'];
$date_paid = $thepayment[0]['date_paid'];

// Fetch all fees for the enrollment
$fees = query("SELECT fee_id, fee, type, amount AS original_fee_amount, priority 
               FROM enrollment_fees 
               WHERE enrollment_id = ?", $enrollment_id);

// Build Fee Tracker
$FeeTracker = [];
foreach ($fees as $fee) {
    $FeeTracker[$fee['fee_id']] = [
        'fee_id' => $fee['fee_id'],
        'fee' => $fee['fee'],
        'priority' => $fee['priority'],
        'type' => $fee['type'],
        'original_fee_amount' => $fee['original_fee_amount'],
        'paid_amount' => 0,
        'remaining_balance' => $fee['original_fee_amount']
    ];
}

// Fetch all payments up to and including this one
$Payments = query("SELECT p.*, u.fullname as cashier FROM payment p left join users u
					on u.id = p.cashier WHERE enrollment_id = ? AND payment_id <= ? ORDER BY payment_id ASC", $enrollment_id, $payment_id);

// Initialize breakdown
$PaymentBreakdown = [];

foreach ($Payments as $payment) {
    $payment_amount = $payment['amount_paid'];
    $allocation = [];

    // Step 1: Allocate to Priority = YES first (normal, not proportional)
    foreach ($FeeTracker as &$fee) {
        if ($fee['priority'] !== 'YES') {
            continue;
        }

        if ($payment_amount <= 0) {
            break;
        }

        if ($fee['remaining_balance'] <= 0) {
            continue;
        }

        $to_pay = min($payment_amount, $fee['remaining_balance']);

        $fee['paid_amount'] += $to_pay;
        $fee['remaining_balance'] -= $to_pay;
        $payment_amount -= $to_pay;

        $allocation[] = [
            'fee_id' => $fee['fee_id'],
            'fee' => $fee['fee'],
            'priority' => $fee['priority'],
            'original_fee_amount' => $fee['original_fee_amount'],
            'allocated_payment' => $to_pay,
            'remaining_balance_after' => $fee['remaining_balance']
        ];
    }
    unset($fee); // Important: break reference

    // Step 2: Allocate remaining balance to non-priority fees proportionally
    if ($payment_amount > 0) {
    // Get total of remaining non-priority balances
    $non_priority_fees = [];
    $non_priority_total = 0;

    foreach ($FeeTracker as $fee) {
        if ($fee['priority'] !== 'YES' && $fee['remaining_balance'] > 0) {
            $non_priority_fees[] = &$FeeTracker[$fee['fee_id']];
            $non_priority_total += $fee['remaining_balance'];
        }
    }

    if ($non_priority_total > 0) {
        $remaining_to_allocate = $payment_amount;
        $count = count($non_priority_fees);

        foreach ($non_priority_fees as $index => &$fee) {
            if ($index === $count - 1) {
                // Last fee absorbs the remaining amount
                $to_pay = $remaining_to_allocate;
            } else {
                $allocation_ratio = $fee['remaining_balance'] / $non_priority_total;
                $to_pay = round($allocation_ratio * $payment_amount, 2);
                $to_pay = min($to_pay, $fee['remaining_balance']);
                $remaining_to_allocate -= $to_pay;
            }

            $fee['paid_amount'] += $to_pay;
            $fee['remaining_balance'] -= $to_pay;

            $allocation[] = [
                'fee_id' => $fee['fee_id'],
                'fee' => $fee['fee'],
                'priority' => $fee['priority'],
                'original_fee_amount' => $fee['original_fee_amount'],
                'allocated_payment' => $to_pay,
                'remaining_balance_after' => $fee['remaining_balance']
            ];
        }
        unset($fee);
    }
}

    $PaymentBreakdown[] = [
        'payment_id' => $payment['payment_id'],
        'or_number' => $payment['or_number'],
        'date_paid' => $payment['date_paid'],
        'amount_paid' => $payment['amount_paid'],
        'paid_by' => $payment['paid_by'],
        'method_of_payment' => $payment['method_of_payment'],
        'cashier' => $payment['cashier'],
        'allocation' => $allocation
    ];
}

// --- Output nicely ---

// dump($FeeTracker);
// dump($PaymentBreakdown);
$perAllocation = [];

foreach($PaymentBreakdown as $row):
	foreach($allocation as $a):
		$perAllocation[$row["payment_id"]][$a["fee_id"]] = $a;
	endforeach;
endforeach;
// dump($perAllocation);


// foreach ($PaymentBreakdown as $payment) {
//     echo "<h3>Payment ID: {$payment['payment_id']} | Date: {$payment['date_paid']} | Amount Paid: ₱" . number_format($payment['amount_paid'], 2) . "</h3>";
//     echo "<table border='1' cellpadding='5' cellspacing='0'>";
//     echo "<tr>
//             <th>Fee</th>
//             <th>Priority</th>
//             <th>Original Amount</th>
//             <th>Allocated</th>
//             <th>Remaining After</th>
//          </tr>";

//     foreach ($payment['allocation'] as $alloc) {
//         echo "<tr>
//             <td>{$alloc['fee']}</td>
//             <td>{$alloc['priority']}</td>
//             <td>₱" . number_format($alloc['original_fee_amount'], 2) . "</td>
//             <td>₱" . number_format($alloc['allocated_payment'], 2) . "</td>
//             <td>₱" . number_format($alloc['remaining_balance_after'], 2) . "</td>
//         </tr>";
//     }

//     echo "</table><br>";
// }
// exit();

$html.='
			<div class="background">
			<br>
			<div class="row">
			<div class="col-xs-6">
					<h5><b>Official Receipt No.</b> '.$PaymentBreakdown[0]["or_number"].'</h5>
				</div>
				<div class="col-xs-4">
					<h5><b>Paid By</b> '.$PaymentBreakdown[0]["paid_by"].'</h5>
				</div>
				
			
				<div class="col-xs-6">
					<h5><b>Date Paid</b> '.date('F d, Y h:i a', strtotime($PaymentBreakdown[0]["date_paid"])).'</h5>
				</div>
				<div class="col-xs-4">
					<h5><b>Payment: </b> '.$PaymentBreakdown[0]["method_of_payment"].'</h5>
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
					<td style="padding:15px 0 15px 0;" width="30%"><b>Fee</b></td>
					<td width="17%"><b>Original Amount</b></td>
					<td width="17%"><b>Cumulative</b></td>
					<td width="17%"><b>Payment</b></td>
					<td width="17%"><b>Remaining Balance</b></td>
				</tr>
				';	
				$total = 0;
				$original_fee_amount = 0;
				$cumulative_allocation = 0;
				$allocated_payment = 0;
				$remaining_balance = 0;
				foreach($FeeTracker as $row):
					// dump($perAllocation);
					// $payment = $

					// dump(date("F d, Y", strtotime($row["date_paid"])));

					$original_fee_amount +=floatval($row["original_fee_amount"]);
					$allocated = 0;
					if(isset($perAllocation[$PaymentBreakdown[0]["payment_id"]][$row["fee_id"]])):
						// dump($perAllocation);
						$allocated = $perAllocation[$PaymentBreakdown[0]["payment_id"]][$row["fee_id"]]["allocated_payment"];
					endif;


					$allocated_payment +=$allocated;
					$cumulative_allocation +=floatval($row["paid_amount"]);
					$remaining_balance +=floatval($row["remaining_balance"]);
					$html.='<tr>';
						$html.='<td >'.($row["fee"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["original_fee_amount"]).'</td>';
						$html.='<td class="text-right">'.to_peso($row["paid_amount"]).'</td>';
						$html.='<td class="text-right">'.to_peso($allocated).'</td>';
						$html.='<td class="text-right">'.to_peso($row["remaining_balance"]).'</td>';
					$html.='</tr>';
				endforeach;
			$html.='</tbody>
			<tfoot>
				<tr>
					<td><b>Total</b></td>
					<td class="text-right"><b>'.to_peso($original_fee_amount).'</b></td>
					<td class="text-right"><b>'.to_peso($cumulative_allocation).'</b></td>
					<td class="text-right"><b>'.to_peso($allocated_payment).'</b></td>
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
                                            <td class="center nw" width="50%" style="border-bottom:1px solid black;"><strong>'.$PaymentBreakdown[0]["cashier"].'</strong></td>
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
			$filename = "Invoice - " . $student["lastname"] . ", " . $student["firstname"] . " - " . $PaymentBreakdown[0]["or_number"];
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
