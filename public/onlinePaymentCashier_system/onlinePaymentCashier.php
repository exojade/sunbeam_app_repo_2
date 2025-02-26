<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "verifyOnlinePaymentModal"):
			// dump($_POST);

			$onlinePayment = query("select op.*, b.bankName from onlinepayment op
									left join bankdetails b
									on b.tblid = op.bankDetailsId
									where op.tblid = ?", $_POST["tblid"]);	
			$onlinePayment = $onlinePayment[0];


			// $parentId = $_SESSION["sunbeam_app"]["userid"];
			$myStudents = query("select s.student_id from student s
									left join enrollment e
									on e.student_id = s.student_id
									where s.parent_id = ?
									and e.syid = ?", $onlinePayment["paidBy"], $onlinePayment["syid"]);
			// dump($myStudents);

			$studentIds = array_map(function($item) {
				return $item['student_id'];
			}, $myStudents);

			$studentIdsString = "'".implode("','", $studentIds)."'";
			$currentInstallmentNumber = $onlinePayment["installment_number"];
			$payment_balance = query("
				SELECT 
					e.student_id,
					CONCAT(s.lastname, ', ', s.firstname) AS fullname,
					-- Urgent amount for specified installment number
					SUM(CASE 
							WHEN ins.installment_number <= ?
							THEN CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END 
							ELSE 0 
						END) AS urgent_amount,
					
					-- Total outstanding balance (all installments regardless of installment number)
					SUM(CASE 
							WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' 
							THEN amount_due 
							ELSE 0 
						END) AS total_outstanding_balance
					
				FROM 
					installment ins
				LEFT JOIN 
					enrollment e ON e.enrollment_id = ins.enrollment_id
				LEFT JOIN 
					student s ON s.student_id = e.student_id

				WHERE 
					ins.syid = ?
					AND e.student_id IN (".$studentIdsString.")
				GROUP BY 
					e.student_id
					", $currentInstallmentNumber, $onlinePayment["syid"]);

				$PaymentBalance = [];
				foreach($payment_balance as $row):
					$PaymentBalance[$row["student_id"]] = $row;
				endforeach;

				// dump($PaymentBalance);









			$onlinePaymentStudents = query("
			select ops.*, concat(s.lastname, ', ', s.firstname) as fullname from 
				onlinepaymentstudents ops
			left join student s
			on s.student_id = ops.student_id
			where ops.transactionCode = ?
			", $onlinePayment["transactionCode"]);
			// dump($onlinePaymentStudents);

			$hint='
			<input type="hidden" name="action" value="acceptPayment">
			<input type="hidden" name="tblid" value="'.$onlinePayment["tblid"].'">
			<table class="table table-bordered">
				<thead>
					<th>Student</th>
					<th>Due Amount</th>
					<th>Balance</th>
					<th>To Pay</th>
					<th>OR Number</th>
				</thead>
				<tbody>
			';
			foreach($onlinePaymentStudents as $row):
				if(isset($PaymentBalance[$row["student_id"]])):
					$hint.='<tr>';
						$hint.='<td>'.$row["fullname"].'</td>';
						$hint.='<td>₱ '.number_format($PaymentBalance[$row["student_id"]]["urgent_amount"], 2).'</td>';
						$hint.='<td>₱ '.number_format($PaymentBalance[$row["student_id"]]["total_outstanding_balance"],2).'</td>';
						$hint.='<td><input class="form-control" type="number" value="'.$row["amount_paid"].'" step="0.01" name="'.$row["student_id"].'" max="'.$PaymentBalance[$row["student_id"]]["total_outstanding_balance"].'" required placeholder="Enter amount to Pay"></td>';
						$hint.='<td><input class="form-control" type="text" required step="0.01" name="OR_'.$row["student_id"].'" required placeholder="Enter OR Number..."></td>';
					$hint.='</tr>';
				endif;
			endforeach;
			$hint.='</tbody>';
			$hint.='<tfoot>';
				$hint.='<th colspan="3">Total</th>';
				$hint.='<th>₱ '.number_format($onlinePayment["amount"],2).'</th>';
				$hint.='<th>OR</th>';
			$hint.='</tfoot>';
			$hint.='</table>';

			$hint.='
			<div class="row">
				<div class="col">
					<div class="form-group">
							<input class="form-control" disabled value="'.$onlinePayment["bankName"].'" placeholder="Enter amount to Pay">
                      </div>
				</div>

				<div class="col">
					<a href="'.$onlinePayment["proofPayment"].'" target="_blank" class="btn btn-info btn-block">View Proof of Payment</a>
				</div>

			</div>
			';
			echo($hint);


			// dump($onlinePaymentStudents);


		elseif($_POST["action"] == "acceptPayment"):
			// dump($_POST);



			$onlinePayment = query("select op.*, b.bankName from onlinepayment op
									left join bankdetails b
									on b.tblid = op.bankDetailsId
									where op.tblid = ?", $_POST["tblid"]);	
			$onlinePayment = $onlinePayment[0];


			$myStudents = query("select s.student_id from student s
									left join enrollment e
									on e.student_id = s.student_id
									where s.parent_id = ?
									and e.syid = ?", $onlinePayment["paidBy"], $onlinePayment["syid"]);

			$studentIds = array_map(function($item) {
				return $item['student_id'];
			}, $myStudents);
			$studentIdsString = "'".implode("','", $studentIds)."'";
			$currentInstallmentNumber = $onlinePayment["installment_number"];
			$payment_balance = query("
				SELECT 
					e.student_id,
					CONCAT(s.lastname, ', ', s.firstname) AS fullname,
					-- Urgent amount for specified installment number
					SUM(CASE 
							WHEN ins.installment_number <= ?
							THEN CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END 
							ELSE 0 
						END) AS urgent_amount,
					
					-- Total outstanding balance (all installments regardless of installment number)
					SUM(CASE 
							WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' 
							THEN amount_due 
							ELSE 0 
						END) AS total_outstanding_balance
					
				FROM 
					installment ins
				LEFT JOIN 
					enrollment e ON e.enrollment_id = ins.enrollment_id
				LEFT JOIN 
					student s ON s.student_id = e.student_id

				WHERE 
					ins.syid = ?
					AND e.student_id IN (".$studentIdsString.")
				GROUP BY 
					e.student_id
					", $currentInstallmentNumber, $onlinePayment["syid"]);
				$PaymentBalance = [];
				foreach($payment_balance as $row):
					$PaymentBalance[$row["student_id"]] = $row;
				endforeach;


		$onlinePaymentStudents = query("
			select ops.*, concat(s.lastname, ', ', s.firstname) as fullname from 
				onlinepaymentstudents ops
			left join student s
			on s.student_id = ops.student_id
			where ops.transactionCode = ?
			", $onlinePayment["transactionCode"]);
		// dump($PaymentBalance);
		// dump($PaymentBalance);

			function handleInstallmentPayments($enrollment_id, $amount_paid, $or_number, $paid_by, $latest_payment, $school_year, $theInstallmentId,$theDueBalance, $onlinePayment) {
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
				$Theamount_paid =  $amount_paid;
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
						$Theamount_paid -= $installment_amount_due;
						$theDueBalance -= $installment_amount_due;
					
					} else {
						// dump($i);q

						if($remaining_amount != 0):
							// dump($theInstallmentId);
							if($row["installment_id"] > $theInstallmentId):
								

								// if($row["installment_id"] <= $theInstallmentId):


								// if()
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
								// dump($theInstallmentId);
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
				if ($Theamount_paid < $theDueBalance) {
					$is_promissory = true;
					// dump($is_promissory);
				}
			
				// Insert the payment record
				$payment_type = $is_promissory ? 'PROMISSORY' : 'INSTALLMENT';
				$query = "INSERT INTO payment (enrollment_id, amount_paid, date_paid, method_of_payment, or_number, type, paid_by, syid, onlinePaymentId, cashier) VALUES ('".$enrollment_id."', '".$amount_paid."', NOW(), 'BANK', '".$or_number."', '".$payment_type."', '".$paid_by."', '".$school_year."', '".$onlinePayment["tblid"]."', '".$_SESSION["sunbeam_app"]["userid"]."')";
				
				
				// $stmt = $conn->prepare($query);
				// $stmt->bind_param("dds", $enrollment_id, $amount_paid, $payment_type);
				// $stmt->execute();
				query($query);
				$payment_id = query("SELECT LAST_INSERT_ID() as payment_id");
				$payment_id = $payment_id[0]["payment_id"];
				// dump($paid_installments);




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

		foreach($onlinePaymentStudents as $student):
			if(isset($PaymentBalance[$student["student_id"]])):
				// dump($student);


			$latest_payment = query("select * from payment_installment where enrollment_id = ? order by tbl_id desc", $student["enrollment_id"]);
			$latest_payment = $latest_payment[0];

			$amount_paid = $_POST[$student["student_id"]];
			$enrollment_id = $student["enrollment_id"];
			$theOr = "OR_" . $student["student_id"];
			$or_number = $_POST[$theOr];
			$paid_by = $onlinePayment["paidBy"];
			$school_year = $student["sy_id"];
			$myInstallmentId = $onlinePayment["installment_number"];
			// Call the function to handle installment payments
			handleInstallmentPayments($enrollment_id, $amount_paid, $or_number, $paid_by, $latest_payment, $school_year, $myInstallmentId,$PaymentBalance[$student["student_id"]]["urgent_amount"],$onlinePayment);
			endif;
		endforeach;
		query("update onlinepayment set status = 'DONE' where tblid = ?", $_POST["tblid"]);
		$res_arr = [
			"result" => "success",
			"title" => "Success",
			"message" => "PAYMENT SUCCCESS",
			"link" => "onlinePaymentCashier",
			// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
			];
			echo json_encode($res_arr); exit();






			

			

			
		elseif($_POST["action"] == "onlinePaymentList"):
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			$where = " where 1=1";
			$baseQuery = "select o.*, u.fullname from onlinepayment o
							left join users u
							on u.id = o.paidBy
			" . $where;

			$bank = query("select * from bankdetails");
			$Bank = [];
			foreach($bank as $row):
				$Bank[$row["tblid"]] = $row;
			endforeach;
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


				if($row["status"] == "PENDING"):
					$data[$i]["action"] = '<a href="#" data-id="'.$row["tblid"].'" data-target="#verifyOnlinePaymentModal" data-toggle="modal" class="btn btn-block btn-warning">Verify</a>';
				else:
					$data[$i]["action"] = '<a href="#" class="btn btn-block btn-info">Details</a>';
				endif;


				$data[$i]["bank"] = $Bank[$row["bankDetailsId"]]["bankName"];
                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);


		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/onlinePaymentCashier_system/onlinePaymentCashierList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/teacher_system/teacherSpecific.php",[
				]);
			endif;
		endif;
	}
?>
