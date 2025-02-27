<?php


    require("includes/config.php");
    require("includes/uuid.php");
    require("includes/checkhit.php");
	require("PHPMailer/PHPMailerAutoload.php");
	ini_set('max_execution_time', '300');
		$request = $_SERVER['REQUEST_URI'];
	
		$constants = get_defined_constants();
		$request = explode('/sunbeam_app',$request);
		// dump($request);
		$request = $request[1];
		$request = explode('?',$request);
		$request = $request[0];
		$request = explode('/',$request);
		$request = $request[1];
		$countering = array("login", "register");






		// dump($_SESSION);
		if (!in_array($request, $countering)){
			if(empty($_SESSION["sunbeam_app"]["userid"]) && empty($_SESSION["sunbeam_app"]["application"])){
				require 'public/login_system/login.php';
			}
			else{
			if($request == 'index' || $request == '/' || $request== "")
				require 'public/dashboard_system/main.php';
			else if ($request == 'users')
				require 'public/users_system/users.php';
			else if ($request == 'subjects')
				require 'public/subjects_system/subjects.php';
			else if ($request == 'student')
				require 'public/student_system/student.php';
			else if ($request == 'teacher')
				require 'public/teacher_system/teacher.php';
			else if ($request == 'schedule')
				require 'public/schedule_system/schedule.php';
			else if ($request == 'enrollment')
				require 'public/enrollment_system/enrollment.php';
			else if ($request == 'notifications')
				require 'public/notifications_system/notifications.php';
			else if ($request == 'section')
				require 'public/section_system/section.php';
			else if ($request == 'parents')
				require 'public/parents_system/parents.php';
			else if ($request == 'advisory')
				require 'public/advisory_system/advisory.php';
			else if ($request == 'grade')
				require 'public/grade_system/grade.php';

			else if ($request == 'fees')
				require 'public/fees_system/fees.php';

			else if ($request == 'form137')
				require 'public/form137_system/form137.php';

			else if ($request == 'cashier')
				require 'public/cashier_system/cashier.php';
			else if ($request == 'bank_settings')
				require 'public/bank_settings_system/bank_settings.php';

			else if ($request == 'announcement')
				require 'public/announcement_system/announcement.php';

			else if ($request == 'onlinePayment')
				require 'public/onlinePayment_system/onlinePayment.php';
			else if ($request == 'payment')
				require 'public/payment_system/payment.php';

			else if ($request == 'documentRequest')
				require 'public/documentRequest_system/documentRequest.php';
			else if ($request == 'onlinePaymentCashier')
				require 'public/onlinePaymentCashier_system/onlinePaymentCashier.php';
			else if ($request == 'studentAccounts')
				require 'public/studentAccounts_system/studentAccounts.php';
			else if ($request == 'teacherAdvisory')
				require 'public/teacherAdvisory_system/teacherAdvisory.php';

			else if ($request == 'installment')
				require 'public/installment_system/installment.php';
			else if ($request == 'settings')
				require 'public/settings_system/settings.php';
			else if ($request == 'static')
				require 'public/static_system/index.php';
			else if ($request == 'logout'){
			require 'logout.php';
		}
			else
				require 'public/404_system/404.php';
			
			}
		}
		else{
			if ($request == 'login')
				require 'public/login_system/login.php';
		}
?>
