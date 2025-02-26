<?php
    require_once("constants.php");

    function filterize($value){
        $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_SCIENTIFIC);
        $value = str_replace(',', '', $value);
        $value = (double) $value;
        return $value;
    }



    function hasConflict($existingSchedules, $teacher_id, $advisory_id, $start_time, $end_time, $days) {
        // Convert start and end times to timestamps
        $startTimestamp = (new DateTime($start_time))->getTimestamp();
        $endTimestamp = (new DateTime($end_time))->getTimestamp();
        // dump($startTimestamp);
    // 
        foreach ($existingSchedules as $schedule) {
            // Convert schedule times to timestamps
            $scheduleFromTimestamp = (new DateTime($schedule['from_time']))->getTimestamp();
            $scheduleToTimestamp = (new DateTime($schedule['to_time']))->getTimestamp();
    
            if ($schedule['teacher_id'] == $teacher_id || $schedule['advisory_id'] == $advisory_id) {
                foreach ($days as $day => $isSet) {
                    if ($isSet && $schedule[$day]) {
                        if (
                            ($startTimestamp >= $scheduleFromTimestamp && $startTimestamp < $scheduleToTimestamp) ||
                            ($endTimestamp > $scheduleFromTimestamp && $endTimestamp <= $scheduleToTimestamp) ||
                            ($startTimestamp <= $scheduleFromTimestamp && $endTimestamp >= $scheduleToTimestamp)
                        ) {
                            return $schedule;
                        }
                    }
                }
            }
        }
        return false;
    }


    function getInstallmentName($number) {
        $installmentNames = [
            2 => '1st installment',
            3 => '2nd installment',
            4 => '3rd installment',
            5 => '4th installment',
            6 => '5th installment',
            7 => '6th installment',
            8 => '7th installment',
            9 => '8th installment',
            10 => '9th installment',
            11 => '10th installment'
        ];
    
        return isset($installmentNames[$number]) ? $installmentNames[$number] : 'Invalid installment number';
    }




    function calculateAge($birthDate) {
        $birthDate = new DateTime($birthDate);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate);
    
        // Check if the birthday has occurred this year
        if ($currentDate < $birthDate->add(new DateInterval('P'.$age->y.'Y'))) {
            $age->y -= 1;
        }
    
        return $age->y;
    }
     function to_peso($number){
        if($number != ""){
            return("₱ " .number_format($number, 2, '.', ','));
        }
        else
        return($number);
    }

    function to_peso_with_no_prefix($number){
        if($number != ""){
            return(number_format($number, 2, '.', ','));
        }
        else
        return($number);
    }

    function add_log($activity, $user){

        $log_id = create_uuid("LOG");
        $ip = getIPAddress(); 
        $date = date("Y-m-d G:i:s a");

        if (query("insert INTO tbl_logs (logs_id, action, logs_date, user_id, ip_address, timestamp) 
                    VALUES(?,?,?,?,?,?)", 
                $log_id, $activity, $date, $user, $ip, time()) === false)
				{
					dump("Sorry, that username has already been taken!");
                }
        ;

      
    }

    function getIPAddress() {  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                   $ip = $_SERVER['HTTP_CLIENT_IP'];  
           }  
       elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
       else{  
                $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
   } 

    function dump($variable)
    {
        require("dump.php");
        exit;
    }
	
	function dumper($variable)
    {
        require("../../templates/dump.php");
        exit;
    }
	
	function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
	}

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);
				// $handle->exec("set names utf8");
				// $handle->exec("set character_set_results='utf8'");
				// $handle->exec("set collation_connection='utf8'");
				// $handle->exec("set character_set_client='utf8'");
                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function query_etracs(/* $sql [, ... ] */)
        {
            // SQL statement
            $sql = func_get_arg(0);
    
            // parameters, if any
            $parameters = array_slice(func_get_args(), 1);
    
            // try to connect to database
            static $handle;
            if (!isset($handle))
            {
                try
                {
                    // connect to database
                    $handle = new PDO("mysql:dbname=" . DATABASE_ETRACS . ";host=" . SERVER_ETRACS, USERNAME_ETRACS, PASSWORD_ETRACS);
                    $handle->exec("set names utf8");
                    $handle->exec("set character_set_results='utf8'");
                    $handle->exec("set collation_connection='utf8'");
                    $handle->exec("set character_set_client='utf8'");
                    // ensure that PDO::prepare returns false when passed invalid SQL
                    $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                }
                catch (Exception $e)
                {
                    // trigger (big, orange) error
                    trigger_error($e->getMessage(), E_USER_ERROR);
                    exit;
                }
            }
    
            // prepare SQL statement
            $statement = $handle->prepare($sql);
            if ($statement === false)
            {
                // trigger (big, orange) error
                trigger_error($handle->errorInfo()[2], E_USER_ERROR);
                exit;
            }
    
            // execute SQL statement
            $results = $statement->execute($parameters);
    
            // return result set's rows, if any
            if ($results !== false)
            {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                return false;
            }
        }


    

    function logout()
    {
        // unset any session variables
        $_SESSION["sunbeam_app"] = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        //session_destroy();
		unset($_SESSION["sunbeam_app"]);
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     * 
     * 
     * 
     */

    function strips($data) {
  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);
      if(empty($data)) {
        return null;
      }
      else {
        return $data;
      }
  	}



    function redirect($destination)
    {
		
		
		
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
			
			
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
			
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
			
			
        }
		
        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
		
        // if template exists, render it
        // if (file_exists("$template"))
        // {   // {   // {
            // extract variables into local scope
            extract($values);
            // render header
            require("layouts/header.php");
			
			// render sidebar
            require("layouts/sidebar.php");

            // render template
            require("$template");
        // }

        // else err
        // else
        // {
            // trigger_error("Invalid template: $template", E_USER_ERROR);
        // }
    }


    function renderFrontPage($template, $values = [])
    {
            extract($values);
            require("layouts/headerFrontPage.php");
            require("$template");
    }


    function renderview($template, $values = []) {
        extract($values);
        require("$template");
        
    }
	
	function check_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	
	function super_unique($array,$key)
	{
		$temp_array = array();
		foreach ($array as &$v) {
		if (!isset($temp_array[$v[$key]]))
		$temp_array[$v[$key]] =& $v;
			}
		$array = array_values($temp_array);
		return $array;
	}
	
	header('content-type:text/html;charset=utf-8');
	
	


?>
