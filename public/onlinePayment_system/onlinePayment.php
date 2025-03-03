<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "modalPayOnline"):
			// dump($sy);

			$school_year = query("select * from school_year where active_status = 'ACTIVE'");
			$syid = $school_year[0]["syid"];

			$parentId = $_SESSION["sunbeam_app"]["userid"];
			$myStudents = query("select s.student_id from student s
									left join enrollment e
									on e.student_id = s.student_id
									where s.parent_id = ?
									and e.syid = ?", $parentId, $syid);
			// dump($myStudents);

			$studentIds = array_map(function($item) {
				return $item['student_id'];
			}, $myStudents);

			$studentIdsString = "'".implode("','", $studentIds)."'";
			// dump($studentIdsString);


			$payment_settings = query("select * from payment_settings");
			$currentInstallmentNumber = 11;
			if(!empty($payment_settings)):
			  $currentInstallmentNumber = $payment_settings[0]["installment_number"];
			endif;
			
			$bank = query("select * from bankdetails");


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
            ", $currentInstallmentNumber, $syid);
			// dump($payment_balance);
			$hint = '<input type="hidden" name="action" value="onlinePayment">';
			$hint .= "<table class='table table-bordered'>";
			$hint .= "<thead>";
				$hint .= "<th>Student</th>";
				$hint .= "<th>Due Amount</th>";
				$hint .= "<th>Balance</th>";
				$hint .= "<th>To Pay</th>";
			$hint .= "</thead>";
			foreach($payment_balance as $row):
				if($row["total_outstanding_balance"] != 0):
					$hint.='<tr>';
						$hint.='<td>'.$row["fullname"].'</td>';
						$hint.='<td>₱ '.number_format($row["urgent_amount"], 2).'</td>';
						$hint.='<td>₱ '.number_format($row["total_outstanding_balance"], 2).'</td>';
						$hint.='<td><input class="form-control" type="number" step="0.01" name="'.$row["student_id"].'" max="'.$row["total_outstanding_balance"].'" required placeholder="Enter amount to Pay"></td>';
					$hint.='</tr>';
				endif;
			endforeach;

			$hint.="</table>";

			$hint.='
			<div class="row">
				<div class="col">
					<div class="form-group">
                        <label>Bank Account</label>
							<select required name="bank" class="form-control">
								<option value="" disabled selected>Select Bank</option>';
					foreach($bank as $row):
						$hint.='<option value="'.$row["tblid"].'">'.$row["bankName"].'</option>';
					endforeach;
							$hint.='</select>
                      </div>
				</div>

				<div class="col">
					<div class="form-group">
                    <label for="exampleInputFile">Proof of Payment</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input required name="proofPayment" type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
				</div>

			</div>
			';
			echo($hint);



		elseif($_POST["action"] == "onlinePayment"):
			// dump($_POST);
			$school_year = query("select * from school_year where active_status = 'ACTIVE'");
			$syid = $school_year[0]["syid"];

			$parentId = $_SESSION["sunbeam_app"]["userid"];
			$myStudents = query("select s.student_id from student s
									left join enrollment e
									on e.student_id = s.student_id
									where s.parent_id = ?
									and e.syid = ?", $parentId, $syid);
			// dump($myStudents);

			$studentIds = array_map(function($item) {
				return $item['student_id'];
			}, $myStudents);

			$studentIdsString = "'".implode("','", $studentIds)."'";
			// dump($studentIdsString);


			$payment_settings = query("select * from payment_settings");
			$currentInstallmentNumber = 11;
			if(!empty($payment_settings)):
			  $currentInstallmentNumber = $payment_settings[0]["installment_number"];
			endif;
			query("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
			$payment_balance = query("
           SELECT 
    e.student_id,
    CONCAT(s.lastname, ', ', s.firstname) AS fullname,
	e.enrollment_id,
	e.syid,
    
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
            ", $currentInstallmentNumber, $syid);

			$transactionCode = create_trackid("T");
			$target_pdf = "uploads/proofPayment/";

			if($_FILES["proofPayment"]["size"] != 0){
				
				$path_parts = pathinfo($_FILES["proofPayment"]["name"]);
				$extension = $path_parts['extension'];
				$target = $target_pdf . $transactionCode . "." . $extension;
                    if(!move_uploaded_file($_FILES['proofPayment']['tmp_name'], $target)){
                        echo("FAMILY Do not have upload files");
                        exit();
                    }
			}
		$totalAmount = 0;
		foreach($payment_balance as $row):
			
			if(isset($_POST[$row["student_id"]])):
				if($_POST[$row["student_id"]] != 0):
					$totalAmount += $_POST[$row["student_id"]];
					query("insert INTO onlinepaymentstudents (transactionCode, enrollment_id, sy_id, student_id, amount_paid) 
                    VALUES(?,?,?,?,?)", 
                	$transactionCode, $row["enrollment_id"], $row["syid"], $row["student_id"], $_POST[$row["student_id"]]);
				endif;
			endif;
		endforeach;

		query("insert INTO onlinepayment (transactionCode, amount, proofPayment, status, transactionDate,paidBy,bankDetailsId,installment_number,syid) 
                    VALUES(?,?,?,?,?,?,?,?,?)", 
                	$transactionCode, $totalAmount, $target, "PENDING", date("Y-m-d H:i:s"), $_SESSION["sunbeam_app"]["userid"], $_POST["bank"],$currentInstallmentNumber,$syid);
					
					
					$Message = [];
					$Message["message"] = $_SESSION["sunbeam_app"]["fullname"] . " have a new online payment request awaiting your acceptance. Please review and take action. Transaction Code : ".$transactionCode."";
					$Message["link"] = "onlinePaymentCashier";
					$theMessage = serialize($Message);
					$users = query("select * from users where role = 'cashier'");
					foreach($users as $row):
						addNotification($row["id"],$theMessage, $_SESSION["sunbeam_app"]["userid"]);
					endforeach;
					
					
					$res_arr = [
						"result" => "success",
						"title" => "Success",
						"message" => "Success on Online Payment",
						"link" => "onlinePayment",
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

			if(isset($_REQUEST["paidBy"])):
				$where .= " and paidBy = '".$_REQUEST["paidBy"]."'";
			endif;
			$baseQuery = "select * from onlinepayment " . $where . " order by status asc, transactionDate desc";

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

				if($row["status"] == "DONE"):
					$data[$i]["action"] = '<a href="#" data-toggle="modal" data-target="#modalViewDetails" data-id="'.$row["transactionCode"].'" class="btn btn-block btn-info btn-sm">View Details</a>';
				else:
					$data[$i]["action"] = '<a href="#" data-toggle="modal" data-target="#modalViewDetailsPending" data-id="'.$row["transactionCode"].'" class="btn btn-block btn-warning btn-sm">View Details</a>';
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

		elseif($_POST["action"] == "modalViewDetails"):

			$onlinePayment = query("select op.*, b.bankName from onlinepayment op
									left join bankdetails b
									on b.tblid = op.bankDetailsId
									where op.transactionCode = ?", $_POST["transactionCode"]);	
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
					<th>Payment</th>
					<th>OR Number</th>
				</thead>
				<tbody>
			';


			$payment = query("select * from payment where onlinePaymentId = ?", $onlinePayment["tblid"]);
			$Payment = [];
			foreach($payment as $row):
				$Payment[$row["enrollment_id"]] = $row;
			endforeach;
			// dump($Payment);


			foreach($onlinePaymentStudents as $row):
					$hint.='<tr>';
						$hint.='<td>'.$row["fullname"].'</td>';
						$hint.='<td>'.to_peso($row["amount_paid"]).'</td>';
						$hint.='<td>'.$Payment[$row["enrollment_id"]]["or_number"].'</td>';
					$hint.='</tr>';
			endforeach;
			$hint.='</tbody>';
			$hint.='<tfoot>';
				$hint.='<th>Total</th>';
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

		elseif($_POST["action"] == "modalViewDetailsPending"):
			$onlinePayment = query("select op.*, b.bankName from onlinepayment op
			left join bankdetails b
			on b.tblid = op.bankDetailsId
			where op.transactionCode = ?", $_POST["transactionCode"]);	
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
				$hint.='<td><input disabled class="form-control" type="number" value="'.$row["amount_paid"].'" step="0.01" name="'.$row["student_id"].'" max="'.$PaymentBalance[$row["student_id"]]["total_outstanding_balance"].'" required placeholder="Enter amount to Pay"></td>';
				$hint.='<td><input disabled class="form-control" type="text" required step="0.01" name="OR_'.$row["student_id"].'" required placeholder="Enter OR Number..."></td>';
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

		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/onlinePayment_system/onlinePaymentList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/teacher_system/teacherSpecific.php",[
				]);
			endif;
		endif;
	}
?>
