<?php   
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
// dump($_REQUEST); asdasdasdasdasdasdasddddd
    include('apps/attendance/attendance_app/attendance_functions.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if($_POST["action"] == "payrollPermanent"):
            // dump($_POST);
            $draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];
            $where=" and 1=1";
            $pg = query("select * from payroll_group where barcode = ?", $_POST["barcode"]);
            $pa = query("select * from payroll_actual pa
                            left join tblemployee emp
                            on emp.Employeeid = pa.employee_id
                            where pa.payroll_id = ?
                            order by emp.LastName ASC, emp.FirstName ASC", $pg[0]["payroll_id"]);

            $coopAccount = query("select * from coop_account where year = ? and month = ?", $pg[0]["year"], $pg[0]["month"]);
            $CoopAccount = [];
            foreach($coopAccount as $row):
                $CoopAccount[$row["employee_id"]] = $row;
            endforeach;


            if($search != ""):
                $pa = query("select * from payroll_actual pa
                            left join tblemployee emp
                            on emp.Employeeid = pa.employee_id
                            where pa.payroll_id = ?
                            and (emp.FirstName like '%".$search."%' or emp.LastName like '%".$search."%')
                            order by emp.LastName ASC, emp.FirstName ASC", $pg[0]["payroll_id"]);
            endif;
            // dump($pa);


            
            $loans = query("select * from loans_management");
            $Loans = [];
            foreach($loans as $row):
                $Loans[$row["employee_id"]][$row["loans_id"]] = $row;
            endforeach;
            $lenders = query("select * from lenders_management");
            $Lenders = [];
            foreach($lenders as $row):
                $Lenders[$row["lenders_id"]] = $row;
            endforeach;

            $coop_mortuary = query("select * from coop_mortuary where year = ? and month = ?", $pg[0]["year"], $pg[0]["month"]);
            $pchgea_burial = query("select * from pchgea_burial where year = ? and month = ?", $pg[0]["year"], $pg[0]["month"]);

            $mandatory = query("select * from employee_mandatory");
            $Mandatory = [];
            foreach($mandatory as $row):
                $Mandatory[$row["employee_id"]] = $row;
            endforeach;
            $salary = query("select * from tbl_salary_sched sched
                            left join tbl_salary_grade grade
                            on grade.salary_schedule_id = sched.salary_schedule_id");
            $Salary = [];
            foreach($salary as $row):
                $Salary[$row["schedule"]][$row["salary_grade"]][$row["step"]]["salary"] = $row["salary"];
            endforeach;

            $data = $pa;
            $i=0;
            // dump($data);
            foreach($data as $row):
                $salary = ($Salary[$row["salary_class"]][$row["salary_grade"]][$row["salary_step"]]["salary"]);
                      $salary_earned = round($salary - (($salary / 22) * to_amount($row["lwop"])),2);

                    //   dump($salary_earned);
                      $pera = 2000;
                      $days = 22 - (to_amount($row["leave_days"]) + to_amount($row["lwop"]));
                      $pera = round($pera - (($pera / 22) * to_amount($row["lwop"])),2);

                      $ra = rata($row["representation_allowance"], $days);
                      $ta = rata($row["travel_allowance"], $days);
                      //gs
                      $philhealth = philhealth($salary);
                      
                      // $gsis_gs = gsis_gs();

                      if($row["gsis_option"] == "FORMULA"):
                        
                        if($row["lwop"] == "")
                            $row["lwop"] = 0;
                        //dump($row["lwop"]);
                        //dump($pg[0]);
                        $gsis_gs = gsis_gs($salary, $row["lwop"], $pg[0]["default_days"]);
                      elseif($row["gsis_option"] == "DEFAULT"):
                        $gsis_gs = $salary * .12;
                      endif;

                      $philhealth_gs = round($philhealth, 2) / 2;
                      $philhealth = round($philhealth, 2);
                      $philhealth_gs = round($philhealth_gs, 2);


                      $ecc = 100;
                      $hdmf_gs = 200;
                      $gs = $philhealth_gs + $hdmf_gs + $gsis_gs + $ecc;
                      //endgs

                      // dump($payroll_group);

                      if($row["gsis_option"] == "FORMULA")
                        $gsis_ps = gsis_ps($salary, $row["lwop"], $pg[0]["default_days"]);
                      else if($row["gsis_option"] == "DEFAULT")
                        $gsis_ps = $salary * 0.09;
                      $hdmf_ps = 200;
                      $philhealth_ps = $philhealth - $philhealth_gs;
                      $ps = $gsis_ps + ($philhealth_ps) + $hdmf_ps;
                      // dump($Mandatory);
                      if(isset($Mandatory[$row["employee_id"]])):

                        
                        
                        $mandatory = $Mandatory[$row["employee_id"]];

                        if($mandatory["sss_ps"] != ""):
                            if($pg[0]["month"] == "03" || $pg[0]["month"] == "06" || $pg[0]["month"] == "09" || $pg[0]["month"] == "12"):
                                // dump($pg[0]["month"]);
                                $mandatory["sss_ps"] = 0;
                            else:
                                $mandatory["sss_ps"] = ($mandatory["sss_ps"] * 3) / 2;
                            endif;
                        endif;


                        $ps = $ps + to_amount($mandatory["sss_ps"]) + to_amount($mandatory["hdmf_mp2"]) + to_amount($mandatory["witholding_tax"]);
                        if($mandatory["hdmf_ps"] != ""):
                          $ps = $ps + $mandatory["hdmf_ps"] - $hdmf_ps;
                        endif;
                      endif;

      // dump($Loans);
                      $total_loans = 0;
                      if(isset($Loans[$row["employee_id"]])):
                        $loans = $Loans[$row["employee_id"]];
                        foreach($loans as $l):
                          if($l["active_status"] == "active")
                          $total_loans = $total_loans + trim($l["loans_amount"]);
                        endforeach;
                      endif;
                      // dump($total_loans);
                      $pchgea_total = 0;

                      $othersTotal = 0;
                    //   $pchgea_dues = 0;
                    //   $pchgea_burial = 0;
                    //   $coop_mortuary = 0;

                    // dump($row);
                    if(trim($row["member_coop"]) != ""){
                        // dump(trim($row["member_coop"]));
                        if(trim($row["member_coop"]) == "ACTIVE"){
                            $othersTotal += $coop_mortuary[0]["amount"];
                        }
                    }
                        
                    //     if(!empty($coop_mortuary))
                    //     
                    //   endif;
                      if($row["pchgea_dues"] == "ACTIVE"):
                          $othersTotal += + 175;
                      endif;
                      if($row["pchgea_burial"] == "ACTIVE"):
                          $othersTotal += $pchgea_burial[0]["amount"];
                      endif;

                      if($row["above_65"] == "ACTIVE"):
                        $gs = $gs - $gsis_gs - $philhealth_gs - $ecc - $hdmf_gs;
                        $ps = $ps - $gsis_ps - $philhealth_ps - $hdmf_ps;

                        $gsis_gs = 0;
                        $philhealth_gs = 0;
                        $ecc = 0;
                        $hdmf_gs = 0;

                        $gsis_ps = 0;
                        $philhealth_ps = 0;
                        $hdmf_ps = 0;
                      endif;
                     

// 
                      if(isset($CoopAccount[$row["Employeeid"]]))
                        $othersTotal += $CoopAccount[$row["Employeeid"]]["amount"];
                        
                

                      $total_deductions = $total_loans + $othersTotal + $ps;
                      $net = $salary_earned + $pera - $total_deductions;
                      $net_ra_ta = $net + to_amount($ra) + to_amount($ta);
                      $q1 = first_quincena($net) + to_amount($ra) + to_amount($ta);
                      $q2 = $net_ra_ta - $q1;

                      $data[$i]["action"] = '

                      <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <i class="fa fa-cog"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" data-employee_id="'.$row["Employeeid"].'" data-payroll_id="'.$pg[0]["payroll_id"].'" data-toggle="modal" data-target="#modal_employee" href="#">Update</a>
                            <form class="generic_form_trigger" style="display:inline;" data-url="payroll_permanent" autocomplete="off">
                                <input type="hidden" name="action" value="delete_employee">
                                <input type="hidden" name="payroll_id" value="'.$row["payroll_id"].'">
                                <input type="hidden" name="employee_id" value="'.$row["Employeeid"].'">
                                <button type="submit" class="dropdown-item">Delete</button>
                            </form>
                        </div>
                    </div>



                            
    
                      
                      ';

                      if($row["MiddleName"] != ""):
                        $name = $row["LastName"] . " " . $row["NameExtension"] . ", " . $row["FirstName"] . " " . $row["MiddleName"][0] . ".";
                      else:
                        $name = $row["LastName"] . " " . $row["NameExtension"] . ", " . $row["FirstName"];
                      endif;

                      $name = $name . " - " . $row["Fingerid"];


                      $data[$i]["name"] = $name;
                      $data[$i]["modalLeave"] = '<a href="#" class="btn  btn-info" data-toggle="modal" data-target="#modal_leave" data-employee_id="'.$row["Employeeid"].'" data-payroll_id="'.$row["payroll_id"].'"><i class="fa fa-edit"></a>';
                      $data[$i]["leave_days"] = $row["leave_days"];
                      $data[$i]["lwop"] = $row["lwop"];
                      $data[$i]["salary_earned"] = to_peso($salary_earned);
                      $data[$i]["pera"] = to_peso($pera);
                      $data[$i]["ra"] = to_peso($ra);
                      $data[$i]["ta"] = to_peso($ta);
                      $data[$i]["modal_gs"] = '<a href="#" data-toggle="modal" data-target="#modal_gs"
                                data-gsis_gs="'.$gsis_gs.'" 
                                data-hdmf_gs="'.$hdmf_gs.'" 
                                data-ecc="'.$ecc.'" 
                                data-philhealth="'.$philhealth.'"
                                data-phic_gs="'.$philhealth_gs.'">'.to_peso($gs).'</a>';
                      $data[$i]["modal_ps"] = '<a href="#" data-toggle="modal" data-target="#modal_ps"
                                data-gsis_ps="'.$gsis_ps.'" 
                                data-phic_ps="'.$philhealth_ps.'" 
                                data-employee_id="'.$row["Employeeid"].'">'.to_peso($ps).'</a>';

                    $data[$i]["modal_others"] = "
                    <a href='javascript:void(0);' onclick='openLoansModal(\"".$row["Employeeid"]."\")' >".to_peso($total_loans)."</a>
                    ";

                    $data[$i]["pchgea_total"] = '<a href="#" data-toggle="modal" data-target="#modalOthers" data-employee_id="'.$row["Employeeid"].'" data-payroll_id="'.$row["payroll_id"].'">'.to_peso($othersTotal).'</a>';

                    //   $data[$i]["modal_others"] = '
                    //         <a href="#" data-toggle="modal" data-target="#modalUpdateLoans"
                    //         data-payroll_id="'.$pg[0]["payroll_id"].'"
                    //         data-employee_id="'.$row["Employeeid"].'">'.to_peso($total_loans).'</a>';
                    //   $data[$i]["pchgea_total"] = to_peso($othersTotal);
                      $data[$i]["total_deductions"] = to_peso($total_deductions);
                      $data[$i]["net_ra_ta"] = to_peso($net_ra_ta);
                      $data[$i]["q1"] = to_peso($q1);
                      $data[$i]["q2"] = to_peso($q2);
                      $i++;
            endforeach;


            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($json_data);






        endif;

        if($_POST["action"] == "modalOthers"):
            // dump($_POST);
            $payrollGroup = query("select * from payroll_group where payroll_id = ?", $_POST["payroll_id"]);
            $employee = query("select pchgea_dues, pchgea_burial, member_coop from tblemployee where Employeeid = ?", $_POST["employee_id"]);
            $employee = $employee[0];
            $payrollGroup = $payrollGroup[0];
            

            $text = "";
            $text.='<table class="table table-bordered">';
            $text.='<thead>';
             $text.='<th>Title</th>';
             $text.='<th>Amount</th>';
            $text.='</thead>';
            $total = 0;

            if($employee["pchgea_burial"] == "ACTIVE"):
                $pchgea_burial = query("select * from pchgea_burial where month = ? and year = ?", $payrollGroup["month"], $payrollGroup["year"]);
                if(!empty($pchgea_burial)):
                    $total+=$pchgea_burial[0]["amount"];
                    $text.='<tr>';
                        $text.='<td>PCHGEA BURIAL</td>';
                        $text.='<td class="text-right">'.to_peso($pchgea_burial[0]["amount"]).'</td>';
                    $text.='</tr>';
                endif;
            endif;

            if($employee["pchgea_dues"] == "ACTIVE"):
                $total+=175;
                    $text.='<tr>';
                        $text.='<td>PCHGEA DUES</td>';
                        $text.='<td class="text-right">175.00</td>';
                    $text.='</tr>';
            endif;

            if(trim($employee["member_coop"]) == "ACTIVE"):
                $coop_mortuary = query("select * from coop_mortuary where month = ? and year = ?", $payrollGroup["month"], $payrollGroup["year"]);
                if(!empty($coop_mortuary)):
                    $total+=$coop_mortuary[0]["amount"];
                    $text.='<tr>';
                        $text.='<td>Coop Mortuary</td>';
                        $text.='<td class="text-right">'.to_peso($coop_mortuary[0]["amount"]).'</td>';
                    $text.='</tr>';
                endif;
            endif;
            $coopAccount = query("select * from coop_account where month = ? and year = ? and employee_id = ?", $payrollGroup["month"], $payrollGroup["year"], $_POST["employee_id"]);
            if(!empty($coopAccount)):
                $total+=$coopAccount[0]["amount"];
                $text.='<tr>';
                    $text.='<td>Coop Account</td>';
                    $text.='<td class="text-right">'.to_peso($coopAccount[0]["amount"]).'</td>';
                $text.='</tr>';
            endif;
            $text.='<tr>';
                    $text.='<td><b>Total</b></td>';
                    $text.='<td class="text-right"><b>'.to_peso($total).'</b></td>';
                $text.='</tr>';
            $text.='</table>';

            $text.='
            <input type="hidden" name="employee_id" value="'.$_POST["employee_id"].'">
            <input type="hidden" name="payroll_id" value="'.$_POST["payroll_id"].'">
            <div class="form-group">
                <label>COOP ACCOUNT</label>';
            if(!empty($coopAccount)):
                $text.='<input name="coopAccount" type="text" class="form-control" value="'.$coopAccount[0]["amount"].'">';
            else:
                $text.='<input name="coopAccount" type="text" class="form-control" placeholder="0.00">';
            endif;
            $text.='
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            ';



            echo($text);

        endif;

        if($_POST["action"] == "saveCoop"):
            // dump($_POST);
            $payrollGroup = query("select * from payroll_group where payroll_id = ?", $_POST["payroll_id"]);
            query("delete from coop_account where employee_id = ? and year = ? and month = ?",
                    $_POST["employee_id"], $payrollGroup[0]["year"], $payrollGroup[0]["month"]);
            if($_POST["coopAccount"] == 0 || $_POST["coopAccount"] == ""):
            else:
                $query_string = "insert into coop_account 
                (employee_id,year,month,amount) 
                VALUES(
                        '".$_POST["employee_id"]."',
                        '".$payrollGroup[0]["year"]."',
                        '".$payrollGroup[0]["month"]."',
                        '".$_POST["coopAccount"]."'
                        )";
                    // dump($query_string);
            if (query($query_string
            ) === false)
            {
                $res_arr = [
                    "message" => "Employee already been created payroll on this month and year!",
                    "status" => "failed",
                    // "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();
            }
            endif;
            $res_arr = [
                "message" => "Successfully Added",
                "status" => "success",
                "link" => "refresh",
                ];
                echo json_encode($res_arr); exit();
        endif;


        if($_POST["action"] == "modal_leave"):
            $leave = query("select lwop, leave_days from payroll_actual where payroll_id = ?
                            and employee_id = ?", $_POST["payroll_id"], $_POST["employee_id"]);
            $hint = "";
            $hint = $hint . '
            <input type="hidden" name="employee_id" value="'.$_POST["employee_id"].'">
            <input type="hidden" name="payroll_id" value="'.$_POST["payroll_id"].'">
            <div class="form-group">
                <label for="exampleInputPassword1">Leave with Pay</label>
                <input value="'.$leave[0]["leave_days"].'" type="number" name="leave_days" step="0.01" class="form-control" placeholder="---">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Leave without Pay</label>
                <input value="'.$leave[0]["lwop"].'" type="number" name="lwop" step="0.01" class="form-control" placeholder="---">
            </div>
            ';
            echo($hint);

        elseif($_POST["action"] == "delete_payroll"):
            // dump($_POST);
            query("delete from payroll_group where payroll_id = ?", $_POST["payroll_id"]);
            query("delete from payroll_actual where payroll_id = ?", $_POST["payroll_id"]);
            $res_arr = [
                "message" => "Successfully Added",
                "status" => "success",
                "link" => "refresh",
                ];
                echo json_encode($res_arr); exit();

        elseif($_POST["action"] == "modal_employee"):
            //dump($_POST);

            $employee = query("select * from tblemployee where Employeeid = ?", $_POST["employee_id"]);
            $salsched = query("select sg.salary_grade_id, sg.salary_grade, sg.step, s.schedule, sg.salary FROM tbl_salary_sched s LEFT JOIN tbl_salary_grade sg
            ON sg.salary_schedule_id = s.salary_schedule_id
            WHERE s.status = 'active'");
            $e = $employee[0];

            $payroll_actual = query("select * from payroll_actual where employee_id = ?
                                        and payroll_id=?", $_POST["employee_id"], $_POST["payroll_id"]);
            $pa = $payroll_actual[0];
            // dump($pa);



                $hint = "";
                $hint = $hint . '
                <input type="hidden" name="employee_id" value="'.$_POST["employee_id"].'">
                <input type="hidden" name="payroll_id" value="'.$_POST["payroll_id"].'">
                <div class="form-group">
                  <label>Salary</label>
                  <select name="salary" class="form-control" id="salary_select" style="width: 100%;">
                    ';
                    foreach($salsched as $row):
                        // dump($e);
                        if($row["salary_grade"] == $e["salary_grade"] && $row["step"] == $e["salary_step"] && $row["schedule"] == $e["salary_class"]):
                            $hint = $hint . '<option selected value="'.$row["salary_grade_id"].'">'.$row["salary"].' (SG: '.$row["salary_grade"].' Step '.$row["step"].' '.$row["schedule"].') ' . '</option>';
                        else:
                            $hint = $hint . '<option value="'.$row["salary_grade_id"].'">'.$row["salary"]. ' (SG: '.$row["salary_grade"].' Step '.$row["step"].' '.$row["schedule"].') ' . '</option>';
                        endif;
                    endforeach;
                    $hint = $hint . '
                  </select>
                </div>
                

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Rep. Allowance</label>
                            <input name="representation_allowance" value="'.$e["representation_allowance"].'" type="number" step="0.01" class="form-control" placeholder="---">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Travel Allowance</label>
                            <input name="travel_allowance" value="'.$e["travel_allowance"].'" type="number" step="0.01" class="form-control" placeholder="---">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">GSIS Option</label>
                                <select name="gsis_option" class="form-control select2" style="width: 100%;">
                                ';
                                    if($pa["gsis_option"] == "FORMULA"):
                                        $hint = $hint . '<option value="DEFAULT">DEFAULT</option>
                                                        <option selected value="FORMULA">FORMULA</option>';
                                    else:
                                        $hint = $hint . '<option value="FORMULA">FORMULA</option>
                                                        <option selected value="DEFAULT">DEFAULT</option>';
                                    endif;
                                $hint = $hint . '
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">ATM Payroll</label>
                            <input name="lbp_number" value="'.$e["lbp_number"].'" type="number" class="form-control" placeholder="---">
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-md-6">
                    <label for="exampleInputPassword1">PCHGEA Dues</label>
                    <select name="pchgea_dues" class="form-control select2" style="width: 100%;">
                    ';
                        if($e["pchgea_dues"] == "ACTIVE"):
                            $hint = $hint . '<option value="INACTIVE">🔴 INACTIVE</option>
                                             <option selected value="ACTIVE">🟢 ACTIVE</option>';
                        else:
                            $hint = $hint . '<option selected value="INACTIVE">🔴 INACTIVE</option>
                                             <option value="ACTIVE">🟢 ACTIVE</option>';
                        endif;
                    $hint = $hint . '
                  </select>
                       
                    </div>
                    <div class="col-md-6">
                    <label for="exampleInputPassword1">PCHGEA Burial</label>
                    <select name="pchgea_burial" class="form-control select2" style="width: 100%;">
                    ';
                        if($e["pchgea_burial"] == "ACTIVE"):
                            $hint = $hint . '<option value="INACTIVE">🔴 INACTIVE</option>
                                             <option selected value="ACTIVE">🟢 ACTIVE</option>';
                        else:
                            $hint = $hint . '<option selected value="INACTIVE">🔴 INACTIVE</option>
                                             <option value="ACTIVE">🟢 ACTIVE</option>';
                        endif;
                    $hint = $hint . '
                  </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    <label for="exampleInputPassword1">MEMBER COOP</label>
                    <select name="member_coop" class="form-control select2" style="width: 100%;">
                    ';


                    // if(!empty($coop_mortuary)):
                    //     if(trim($row["member_coop"]) == "ACTIVE"){
                    //         $Others[$i]["id"] = "";
                    //         $Others[$i]["employee_id"] = $row["Employeeid"];
                    //         $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                    //         $Others[$i]["title"] = "COOP MORTUARY";
                    //         $Others[$i]["amount"] = $pchgea_burial[0]["amount"];
                    //         //$pchgea_total = $pchgea_total + $Others[$i]["amount"];
                    //         $i++;
                    //     }
                    //   endif;


                        if(trim($row["member_coop"]) == "ACTIVE"):
                            $hint = $hint . '<option value="INACTIVE">🔴 INACTIVE</option>
                                             <option selected value="ACTIVE">🟢 ACTIVE</option>';
                        else:
                            $hint = $hint . '<option selected value="INACTIVE">🔴 INACTIVE</option>
                                             <option value="ACTIVE">🟢 ACTIVE</option>';
                        endif;
                    $hint = $hint . '
                  </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                    <label for="exampleInputPassword1">ABOVE 65</label>
                    <select name="above_65" class="form-control select2" style="width: 100%;">
                    ';
                        if($e["above_65"] == "ACTIVE"):
                            $hint = $hint . '<option value="INACTIVE">🔴 INACTIVE</option>
                                             <option selected value="ACTIVE">🟢 ACTIVE</option>';
                        else:
                            $hint = $hint . '<option selected value="INACTIVE">🔴 INACTIVE</option>
                                             <option value="ACTIVE">🟢 ACTIVE</option>';
                        endif;
                    $hint = $hint . '
                  </select>
                    </div>
                </div>
                <br>
                <script>
               
                </script>
                ';
                echo($hint);
            
        elseif($_POST["action"] == "update_employee"):
           // dump($_POST);
            $salsched = query("select sg.salary_grade, sg.step, s.schedule from tbl_salary_sched s
                                left join tbl_salary_grade sg
                                on sg.salary_schedule_id = s.salary_schedule_id
                                where sg.salary_grade_id = ?
                                ", $_POST["salary"]);
            $salary=$salsched[0];
            query("update tblemployee set 
                    representation_allowance = '".$_POST["representation_allowance"]."', 
                    travel_allowance = '".$_POST["travel_allowance"]."', 
                    salary_grade = '".$salary["salary_grade"]."', 
                    salary_step = '".$salary["step"]."', 
                    salary_class = '".$salary["schedule"]."', 
                    pchgea_dues = '".$_POST["pchgea_dues"]."',
                    pchgea_burial = '".$_POST["pchgea_burial"]."',
                    lbp_number = '".$_POST["lbp_number"]."',
                    above_65 = '".$_POST["above_65"]."',
                    member_coop = '".$_POST["member_coop"]."'
                    where Employeeid= '".$_POST["employee_id"]."'
                    ");
            query("update payroll_actual set gsis_option = ? where
                    employee_id = ? and payroll_id = ?", $_POST["gsis_option"], $_POST["employee_id"], $_POST["payroll_id"]);
            
                    $res_arr = [
                "message" => "Successfully Added",
                "status" => "success",
                "link" => "refresh",
                ];
                echo json_encode($res_arr); exit();
        
        elseif($_POST["action"] == "new_payroll"):
                // dump($_POST);
                $default_days=cal_days_in_month(CAL_GREGORIAN,$_POST["month"],$_POST["year"]);
                $payroll_id = create_trackid("PAYROLL");
                $query_string = "insert into payroll_group 
                (payroll_id,barcode,year,month,department_fund,remarks,payroll_type,payroll_design,employment_status,working_days,default_days,
                date_created, time_created
                ) 
				VALUES(
                        '".$payroll_id."',
                        '".$_POST["barcode"]."',
                        '".$_POST["year"]."',
                        '".$_POST["month"]."',
                        '".$_POST["department"]."',
                        '".$_POST["remarks"]."',
                        'SALARY',
                        'standard',
                        'PERMANENT',
                        '".$_POST["working_days"]."',
                        '".$default_days."',
                        '".date("Y-m-d")."',
                        '".date("H:i:s")."'
                        )";
                        // dump($query_string);
                if (query($query_string
                ) === false)
				{
					$res_arr = [
                        "message" => "Employee already been created payroll on this month and year!",
                        "status" => "failed",
                        // "link" => "refresh",
                        ];
                        echo json_encode($res_arr); exit();
				}
                $res_arr = [
                    "message" => "Successfully Added",
                    "status" => "success",
                    "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();

        elseif($_POST["action"] == "update_leave"):
            // dump($_POST);
            $pg = query("select * from payroll_group where payroll_id = ?", $_POST["payroll_id"]);
            query("update payroll_actual set leave_days = ?, lwop = ?
                    where payroll_id = ? and employee_id = ?",
                    $_POST["leave_days"], $_POST["lwop"],
                    $_POST["payroll_id"], $_POST["employee_id"]);
            $res_arr = [
                "message" => "Successfully Processed",
                "status" => "success",
                "link" => "payroll_permanent?action=barcode&barcode=".$pg[0]["barcode"],
                ];
                echo json_encode($res_arr); exit();
        elseif($_POST["action"] == "modal_gs"):
            // dump($_POST);

            $hint = '
                  <table class="table table-bordered">
                    <thead>
                        <th>Share</th>
                        <th>Amount</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>GSIS</td>
                            <td>'.to_peso($_POST["gsis_gs"]).'</td>
                        </tr>
                        <tr>
                            <td>Philhealth</td>
                            <td>'.to_peso($_POST["phic_gs"]).'</td>
                        </tr>
                        <tr>
                            <td>HDMF (PAGIBIG)</td>
                            <td>'.to_peso($_POST["hdmf_gs"]).'</td>
                        </tr>
                        <tr>
                            <td>ECC</td>
                            <td>'.to_peso($_POST["ecc"]).'</td>
                        </tr>
                        <tr>
                            <th><b>TOTAL</b></th>
                            <th>'.to_peso($_POST["ecc"] + $_POST["hdmf_gs"] + $_POST["phic_gs"] + $_POST["gsis_gs"]).'</th>
                        </tr>
                    </tbody>    

                  </table>
            ';
            echo($hint);
            elseif($_POST["action"] == "modal_ps"):
            // dump($_POST);
            $mandatory = query("select m.* FROM tblemployee e LEFT JOIN
            employee_mandatory m
            ON m.employee_id = e.Employeeid
            WHERE e.Employeeid = ?", $_POST["employee_id"]);
            // dump($mandatory[0]["hdmf_ps"]);
            
            $hint = '
            <input type="hidden" name="employee_id" value="'.$_POST["employee_id"].'">
            <table class="table table-bordered">
                <thead>
                    <th>Share</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    <tr>
                        <td>GSIS</td>
                        <td>'.to_peso($_POST["gsis_ps"]).'</td>
                    </tr>
                    <tr>
                        <td>PHIC</td>
                        <td>'.to_peso($_POST["phic_ps"]).'</td>
                    </tr>
                    <tr>
                        <td>HDMF (Pagibig)</td>
                        <td><input name="hdmf_ps" value="'.$mandatory[0]["hdmf_ps"].'" type="number" step="0.01" min="200" class="form-control" placeholder="200.00"></td>
                    </tr>
                    <tr>
                        <td>SSS</td>
                        <td><input name="sss_ps" value="'.$mandatory[0]["sss_ps"].'" type="number" step="0.01" class="form-control" placeholder="---"></td>
                    </tr>
                    <tr>
                        <td>HDMF MP2</td>
                        <td><input name="hdmf_mp2" value="'.$mandatory[0]["hdmf_mp2"].'" type="number" step="0.01" class="form-control" placeholder="---"></td>
                    </tr>
                    <tr>
                        <td>Witholding Tax</td>
                        <td><input name="witholding_tax" value="'.trim($mandatory[0]["witholding_tax"]).'" type="number" step="0.01" class="form-control" placeholder="---"></td>
                    </tr>
                </tbody>
            </table>
            
            ';
            echo($hint);
            
            // if()
            elseif($_POST["action"] == "update_ps"):
                // dump($_POST);
                query("delete from employee_mandatory where employee_id = ?", $_POST["employee_id"]);
                $queryFormat = '("%s","%s","%s","%s","%s")';
                        $inserts[] = sprintf( 
                            $queryFormat, 
                            $_POST["employee_id"], $_POST["sss_ps"], $_POST["hdmf_ps"], 
                            $_POST["hdmf_mp2"], $_POST["witholding_tax"]
                        );
                $query = implode( ",", $inserts );
                query('insert into employee_mandatory(employee_id, sss_ps, hdmf_ps, hdmf_mp2, witholding_tax) VALUES '.$query);
                $res_arr = [
                    "message" => "Successfully Processed",
                    "status" => "success",
                    "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();
            
            // elseif($_POST["action"] == "modal_others"):
            //     //dump($_POST);

            //     $employee = query("select pchgea_dues, pchgea_burial, member_coop from tblemployee where Employeeid = ?", $_POST["employee_id"]);
            //     $pg = query("select * from payroll_group where payroll_id = ?", $_POST["payroll_id"]);
            //     $pg = $pg[0];

               
            //     $emp = $employee[0];




            //     $pchgea_dues = 0;
            //     $coop_mortuary = 0;
            //     $pchgea_burial_amount = 0;
            //     // if($emp["pchgea_dues"] == "ACTIVE")
            //     //     $pchgea_dues = 175;
            //     // if($emp["pchgea_burial"] == "ACTIVE"):
            //     //     $pchgea_burial = query("select * from pchgea_burial where month = ? and year = ?", $pg["month"], $pg["year"]);
            //     //     if(isset($pchgea_burial[0])):
            //     //         $pchgea_burial_amount = $pchgea_burial[0]["amount"];
            //     //     endif;
            //     //     //$amount = "";
            //     // endif;

            //     // if($emp["member_coop"] == "ACTIVE"):
            //     //     $coopMortuary = query("select * from coop_mortuary where month = ? and year = ?", $pg["month"], $pg["year"]);
            //     //     if(isset($coopMortuary[0])):
            //     //         $coop_mortuary = $coopMortuary[0]["amount"];
            //     //     endif;
            //     // endif;
          

            //     $loans = query("select * from loans_management loans
            //                         left join lenders_management lenders   
            //                         on loans.lenders_id = lenders.lenders_id
            //                         where loans.employee_id = ? and loans.active_status = 'active'", $_POST["employee_id"]);
            //     // dump($loans);
            //     // $lenders = query("select * from lenders_management order by loan_name ASC");
            //     // $loans_employee = query("select * from loans_management where employee_id = ?", $_POST["employee_id"]);
            //     // $LoansEmployee = [];
            //     // foreach($loans_employee as $row):
            //     //     $LoansEmployee[$row["lenders_id"]] = $row;
            //     // endforeach;

            //     $hint = '
            //     <input type="hidden" name="employee_id" value="'.$_POST["employee_id"].'">
            //     <table class="table table-bordered" id="loans_datatable">
            //         <thead>
            //             <th>Title</th>
            //             <th>Start</th>
            //             <th>End</th>
            //             <th>Amount</th>
            //         </thead>
            //         <tbody>
            //     ';
            //     $total_others=0;
            //     foreach($loans as $row):
            //         $total_others += $row["loans_amount"];
            //         $hint = $hint . '
            //         <tr>
            //             <td>'.$row["loan_name"].'</td>
            //             <td>'.$row["from_date"].'</td>
            //             <td>'.$row["to_date"].'</td>
            //             <td class="text-right">'.to_peso($row["loans_amount"]).'</td>
            //         </tr>
            //       ';
            //     endforeach;

            //     if($coop_mortuary != 0):
            //         $hint.='
            //         <tr>
            //             <td>Coop Mortuary</td>
            //             <td></td>
            //             <td></td>
            //             <td class="text-right">'.to_peso($coop_mortuary).'</td>
            //         </tr>
            //         ';
            //     endif;
                
            //     if($pchgea_dues != 0):
            //         $hint.='
            //         <tr>
            //             <td>PCHGEA Dues</td>
            //             <td></td>
            //             <td></td>
            //             <td class="text-right">'.to_peso($pchgea_dues).'</td>
            //         </tr>
            //         ';
            //     endif;

            //     if($pchgea_burial_amount != 0):
            //         $hint.='
            //         <tr>
            //             <td>PCHGEA Burial</td>
            //             <td></td>
            //             <td></td>
            //             <td class="text-right">'.to_peso($pchgea_burial_amount).'</td>
            //         </tr>
            //         ';
            //     endif;
                
                

            //     // $total_others += $pchgea_dues + $coop_mortuary + $pchgea_burial_amount;
                
            //     $hint = $hint . '
            //     <tr>
            //         <th>Total</th>
            //         <td></td>
            //         <td></td>
            //         <th class="text-right">'.to_peso($total_others).'</th>
            //     </tr>
            //     ';


            //     $hint = $hint . '
            //     </tbody>
            //     </table>
            //     ';
            //     echo($hint);
            elseif($_POST["action"] == "save_loan"):
            // dump($_POST);
            query("delete from loans_management where employee_id = ?", $_POST["employee_id"]);
            $inserts = array();
            $insertsOthersDeduction = [];
            $insertsPersonalDeduction = [];
            $insertGovernmentDeduction = [];
            $queryFormat = '("%s","%s","%s","%s","%s","%s","%s","%s")';
            $lenders = query("select * from lenders_management");
            foreach($lenders as $row):
                if($_POST["loan_amount_".$row["lenders_id"]] != ""):
                    $loans_id = create_uuid("LOAN");
                    $inserts[] = sprintf( 
                        $queryFormat, 
                        $loans_id, $row["loan_name"], $_POST["employee_id"], 
                        $_POST["loan_amount_".$row["lenders_id"]],
                        $_POST["from_date_".$row["lenders_id"]],
                        $_POST["to_date_".$row["lenders_id"]],
                        $_POST["active_status_".$row["lenders_id"]],
                        $row["lenders_id"]
                    );
                endif;
            endforeach;
            $query = implode( ",", $inserts );
            $query_string = 'insert into loans_management(loans_id, loan_title, employee_id, loans_amount, from_date, to_date, active_status ,lenders_id) VALUES '.$query;
            query($query_string);
            $res_arr = [
                "message" => "Successfully Processed",
                "status" => "success",
                "link" => "refresh",
                ];
                echo json_encode($res_arr); exit();
            elseif($_POST["action"] == "delete_employee"):
                // dump($_POST);
                query("delete from payroll_actual where employee_id = ?
                        and payroll_id = ?", $_POST["employee_id"], $_POST["payroll_id"]);
                $res_arr = [
                    "message" => "Successfully Processed",
                    "status" => "success",
                    "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();
            elseif($_POST["action"] == "add_all_employees"):
                $pg = query("select * from payroll_group where barcode = ?", $_POST["barcode"]);
                $pg = $pg[0];
                $Pa = [];
                $pa = query("select employee_id from payroll_actual where year = ? and month = ?", $pg["year"], $pg["month"]);
                foreach($pa as $row):
                    $Pa[$row["employee_id"]] = $row;
                endforeach;
                $employees = query("select Employeeid from tblemployee where Deptid = ? and JobType in ('PERMANENT', 'COTERMINOUS', 'ELECTIVE') and active_status = 1", $pg["department_fund"]);
                $Include = [];
                foreach($employees as $row):
                    if(!isset($Pa[$row["Employeeid"]])):
                        $Include[] = $row["Employeeid"];
                    endif; 
                endforeach;
                // dump($Include);
                $in = "('" . implode("','",$Include) . "')";
                $inserts = array();
                $queryFormat = '("%s","%s","%s","%s","%s","%s")';
               if(!empty($Include)):
                foreach($Include as $row):
                    $inserts[] = sprintf( 
                        $queryFormat, 
                        $pg["payroll_id"], $row, $pg["year"], 
                        $pg["month"], $pg["payroll_type"], 'DEFAULT'
                    );
                endforeach;
                $query = implode( ",", $inserts );
                query('insert into payroll_actual(payroll_id, employee_id, year, month, payroll_type, gsis_option) VALUES '.$query);
               endif;
               
                $res_arr = [
                    "message" => "Successfully Processed",
                    "status" => "success",
                    "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();

            elseif($_POST["action"] == "add_employee"):
                $pg = query("select * from payroll_group where barcode = ?", $_POST["barcode"]);
                $pg = $pg[0];
                $query_string = "insert into payroll_actual 
                (payroll_id,employee_id,year,month,payroll_type,gsis_option) 
				VALUES(
                        '".$pg["payroll_id"]."',
                        '".$_POST["employee"]."',
                        '".$pg["year"]."',
                        '".$pg["month"]."',
                        '".$pg["payroll_type"]."',
                        'DEFAULT'
                        
                        )";
                        // dump($query_string);
                if (query($query_string
                ) === false)
				{
					$res_arr = [
                        "message" => "Employee already been created payroll on this month and year!",
                        "status" => "failed",
                        // "link" => "refresh",
                        ];
                        echo json_encode($res_arr); exit();
				}
                $res_arr = [
                    "message" => "Successfully Added",
                    "status" => "success",
                    "link" => "refresh",
                    ];
                    echo json_encode($res_arr); exit();
                elseif($_POST["action"] == "save_payroll"):
                    $Emp = [];
                    $pg = query("select * from payroll_group where barcode = ?", $_POST["barcode"]);
                    $coopAccount = query("select * from coop_account where year = ? and month = ?", $pg[0]["year"], $pg[0]["month"]);
                    $CoopAccount = [];
                    foreach($coopAccount as $row):
                        $CoopAccount[$row["employee_id"]] = $row;
                    endforeach;
                    
                    $pa = query("
                    select 
                    pa.payroll_id, pa.lwop, pa.leave_days,
                    pa.year, pa.month, pa.gsis_option,
                    e.Employeeid, e.Fingerid,
                    e.salary_grade, e.salary_step, e.salary_class, e.salary_id,
                    e.travel_allowance, e.representation_allowance, e.Positionid,
                    e.DeptAssignment, e.pchgea_dues, e.pchgea_burial, e.lbp_number,
                    e.above_65,
                    e.member_coop,
                    p.Positionid, p.PositionName
                    from payroll_actual pa 
                    left join tblemployee e
                    on pa.employee_id = e.Employeeid
                    left join tblposition p
                    on p.Positionid = e.Positionid
                    where pa.payroll_id = ?
                    order by e.LastName ASC, e.FirstName ASC
                    ", $pg[0]["payroll_id"]);
                    foreach($pa as $row):
                        $Emp[] = $row["Employeeid"];
                    endforeach;
                    $Emp = implode( "','", $Emp );
                    $Emp = "('" . $Emp . "')";
                    $Mandatory=[];
                    $Loans=[];
                    $mandatory = query("select m.* from 
                                        tblemployee e
                                        left join employee_mandatory m
                                        on m.employee_id = e.Employeeid
                                        where employee_id in " . $Emp);

                    // dump($mandatory);
                    $loans = query("select * from loans_management
                                        where active_status = 'active' and
                                        employee_id in " . $Emp . "
                                        order by loan_title
                                        ");
                    foreach($mandatory as $row):
                        $Mandatory[$row["employee_id"]] = $row;
                    endforeach;
                    foreach($loans as $row):
                        $Loans[$row["employee_id"]][$row["loans_id"]] = $row;
                    endforeach;

                    $salary = query("select * from tbl_salary_sched sched
                                    left join tbl_salary_grade sg
                                    on sg.salary_schedule_id = sched.salary_schedule_id
                                    where sched.status = 'active'");
                                    
                    
                    $queryFormat = "(
                        '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
                        '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
                        '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
                        '%s','%s','%s'
                        )"; // 36

                    $PayrollOthersDeductionsQueryFormat = "(
                        '%s','%s','%s','%s','%s','%s'
                        )";

                    $PayrollPersonalDeductionsQueryFormat = "(
                        '%s','%s','%s','%s','%s','%s'
                        )";
                    $PayrollGovernmentDeductionsQueryFormat = "(
                        '%s','%s','%s','%s','%s','%s'
                        )";
                    
                    $pchgea_burial = query("select * from pchgea_burial where year = ?
                        and month = ?", $pg[0]["year"], $pg[0]["month"]);

                    $coop_mortuary = query("select * from coop_mortuary where year = ?
                        and month = ?", $pg[0]["year"], $pg[0]["month"]);


                    foreach($pa as $row):
                    // dump($row);
                    $my_salary = salary($salary, $row["salary_id"], $row["salary_grade"], $row["salary_step"], $row["salary_class"]);
                    // dump($my_salary);
                    $salary_earned = $my_salary - (($my_salary / 22) * to_amount($row["lwop"]));
                    $pera = 2000;
                    $days = 22 - (to_amount($row["leave_days"]) + to_amount($row["lwop"]));
                    $pera = $pera - (($pera / 22) * to_amount($row["lwop"]));
                    $ra = rata($row["representation_allowance"], $days);
                    $ta = rata($row["travel_allowance"], $days);

                    $government_share = [];
                    $philhealth = philhealth($my_salary);
                  
                    $philhealth_gs = round($philhealth, 2) / 2;
                    $philhealth = round($philhealth, 2);
                    $philhealth_gs = round($philhealth_gs, 2);
             
                    if($row["gsis_option"] == "FORMULA"):
                        
                        if($row["lwop"] == "")
                            $row["lwop"] = 0;
                        //dump($row["lwop"]);
                        //dump($pg[0]);
                        $gsis_gs = gsis_gs($my_salary, $row["lwop"], $pg[0]["default_days"]);
                      elseif($row["gsis_option"] == "DEFAULT"):
                        $gsis_gs = $my_salary * .12;
                      endif;


                    // if($row["gsis_option"] == "FORMULA"):
                    //     $gsis_gs = gsis_gs($my_salary, $row["lwop"], $pg[0]["default_days"]);
                    // elseif($row["gsis_option"] == "DEFAULT"):
                    //     $gsis_gs = $my_salary * .12;
                    // endif;
                    
                    // $gsis_gs = $my_salary * .12;

                    $row["above_65"] = strtoupper($row["above_65"]);

                    if($row["above_65"] == "INACTIVE" || $row["above_65"] == ""):
                        $ecc = 100;
                        $hdmf_gs = 200;
                        $gs = $philhealth_gs + $hdmf_gs + $gsis_gs + $ecc;
                        $government["title"] = "GSIS GS";
                        $government["amount"] = $gsis_gs;
                        $government_share[] = $government;
                        $government["title"] = "ECC";
                        $government["amount"] = $ecc;
                        $government_share[] = $government;
                        $government["title"] = "HDMF GS";
                        $government["amount"] = $hdmf_gs;
                        $government_share[] = $government;
                        $government["title"] = "PHIC GS";
                        $government["amount"] = $philhealth_gs;
                        $government_share[] = $government;
                        $gs_total = 0;
                        foreach($government_share as $gs):
                            $gs_total = $gs_total + $gs["amount"];
                        endforeach;
                    else:

                    endif;

                    $mandatory = $Mandatory[$row["Employeeid"]];
                    // dump($mandatory);
                    $personal_share = [];


                    if($row["above_65"] == "INACTIVE" || $row["above_65"] == ""):
                     

                        if($row["gsis_option"] == "FORMULA")
                            $gsis_ps = gsis_ps($my_salary, $row["lwop"], $pg[0]["default_days"]);
                        else if($row["gsis_option"] == "DEFAULT")
                            $gsis_ps = $my_salary * 0.09;
                        else;



                        $phic_ps = $philhealth - $philhealth_gs;
                        $hdmf_ps = 200;

                        if($mandatory["hdmf_ps"] != ""):
                            $hdmf_ps = $mandatory["hdmf_ps"];
                        endif;

                        if($pg[0]["month"] == "04"):
                            if($mandatory["sss_ps"] != ""):
                                if($pg[0]["month"] == "03" || $pg[0]["month"] == "06" || $pg[0]["month"] == "09" || $pg[0]["month"] == "12"):
                                    // dump($pg[0]["month"]);
                                    $mandatory["sss_ps"] = 0;
                                else:
                                    $mandatory["sss_ps"] = ($mandatory["sss_ps"] * 3) / 2;
                                endif;
                            else:
                            
                            endif;
    
                        endif;

                       
                        
                    $personal["title"] = "GSIS PS";
                    $personal["amount"] = $gsis_ps;
                    $personal_share[] = $personal;
                    $personal["title"] = "PHIC PS";
                    $personal["amount"] = $phic_ps;
                    $personal_share[] = $personal;
                    $personal["title"] = "HDMF PS";
                    $personal["amount"] = $hdmf_ps;
                    $personal_share[] = $personal;
                    $personal["title"] = "SSS PS";
                    $personal["amount"] = $mandatory["sss_ps"];
                    $personal_share[] = $personal;
                    $personal["title"] = "HDMF MP2";
                    $personal["amount"] = $mandatory["hdmf_mp2"];
                    $personal_share[] = $personal;
                    $personal["title"] = "Witholding Tax";
                    $personal["amount"] = $mandatory["witholding_tax"];
                    // dump($personal);
                    $personal_share[] = $personal;
                    $ps_total = 0;
                    // dump($personal_share);
                    foreach($personal_share as $ps):
                        $ps_total = $ps_total + to_amount($ps["amount"]);
                    endforeach;


                    else:

     
                    $personal["title"] = "Witholding Tax";
                    $personal["amount"] = $mandatory["witholding_tax"];
                    $personal_share[] = $personal;
                    $ps_total = 0;
                    // dump($personal_share);
                    foreach($personal_share as $ps):
                        $ps_total = $ps_total + to_amount($ps["amount"]);
                    endforeach;

                    endif;



                    //$government_share = serialize($government_share);
                    // dump($government_share);
                   
                    // dump($Mandatory[$row["Employeeid"]]);
                 

                  

                        // dump($personal_share);

                    
                
                 

                


                    // dump($government_share);
                    //$personal_share = serialize($personal_share);
                    // dump($Loans[$row["Employeeid"]]);
                    $Others = [];
                    $i = 0;
                    $others_total = 0;
                    if(isset($Loans[$row["Employeeid"]])):
                    foreach($Loans[$row["Employeeid"]] as $others):
                        $Others[$i]["id"] = $others["lenders_id"];
                        $Others[$i]["title"] = $others["loan_title"];
                        $Others[$i]["amount"] = $others["loans_amount"];
                        $Others[$i]["employee_id"] = $row["Employeeid"];
                        $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                        $others_total = $others_total + $others["loans_amount"];
                        $i++;
                    endforeach;
                    endif;
                    
                    $others_total = 0;
                      $pchgea_total = 0;
                      if($row["pchgea_dues"] == "ACTIVE"){
                        $Others[$i]["id"] = "";
                        $Others[$i]["employee_id"] = $row["Employeeid"];
                        $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                        $Others[$i]["title"] = "PCHGEA Dues";
                        $Others[$i]["amount"] = 175;
                        //$pchgea_total = $pchgea_total + 175;
                        $i++;
                      }
                          
                      if(!empty($pchgea_burial)):
                        if($row["pchgea_burial"] == "ACTIVE"){
                            $Others[$i]["id"] = "";
                            $Others[$i]["employee_id"] = $row["Employeeid"];
                            $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                            $Others[$i]["title"] = "PCHGEA Burial";
                            $Others[$i]["amount"] = $pchgea_burial[0]["amount"];
                            //$pchgea_total = $pchgea_total + $Others[$i]["amount"];
                            $i++;
                        }
                      endif;
                      
                      if(!empty($coop_mortuary)):
                        // dump($coop_mortuary);
                        if(trim($row["member_coop"]) == "ACTIVE"){
                            $Others[$i]["id"] = "";
                            $Others[$i]["employee_id"] = $row["Employeeid"];
                            $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                            $Others[$i]["title"] = "COOP MORTUARY";
                            $Others[$i]["amount"] = $coop_mortuary[0]["amount"];
                            //$pchgea_total = $pchgea_total + $Others[$i]["amount"];
                            $i++;
                        }
                      endif;

                      if(isset($CoopAccount[$row["Employeeid"]])):
                        $Others[$i]["id"] = "";
                        $Others[$i]["employee_id"] = $row["Employeeid"];
                        $Others[$i]["payroll_id"] = $pg[0]["payroll_id"];
                        $Others[$i]["title"] = "COOP ACCOUNT";
                        $Others[$i]["amount"] = $CoopAccount[$row["Employeeid"]]["amount"];
                        //$pchgea_total = $pchgea_total + $Others[$i]["amount"];
                        $i++;
                      endif;



                      foreach($Others as $o):
                        $others_total = $others_total + to_amount($o["amount"]);
                      endforeach;
                    //   dump($Others);
                      //$Others=serialize($Others);
                      //dump($Others);
                      $total_deductions = $others_total + $ps_total;
                      $net = $salary_earned + $pera - $total_deductions;
                      $net_ra_ta = $net + to_amount($ra) + to_amount($ta);
                      $q1 = first_quincena($net) + to_amount($ra) + to_amount($ta);
                      $q2 = $net_ra_ta - $q1;

                      $negative_salary = "";

                      if($q1 < 0 || $q2 < 0):
                        $whole = $q1 + $q2;

                        $negative_salary = 1;
                       
                        $q1 = ($whole) /2;
                        $q1 = round($q1, 2);
                        $q2 = ($whole) - $q1;

                 
                      endif;
                      $my_payroll = $pg[0];
                    //   dump($row);
                    $inserts[] = sprintf( 
                        $queryFormat, 
                        $my_payroll["payroll_id"], $my_payroll["year"], $my_payroll["month"], 
                        $row["Employeeid"], $row["Fingerid"], $row["DeptAssignment"],$row["Positionid"],$row["PositionName"],
                        $row["lbp_number"], $my_salary, $row["salary_id"], $row["salary_class"],
                        $row["salary_grade"],$row["salary_step"],"2000", $row["representation_allowance"], $row["travel_allowance"],
                        $row["lwop"], $row["leave_days"], 22, "SALARY", $gs_total, $ps_total, $others_total, $net, $q1, $q2,
                        $ra,$ta,$salary_earned,$pera,$row["gsis_option"],$negative_salary
                    );


                        
                        foreach($Others as $o):
                            $insertsOthersDeduction[] = sprintf( 
                                $PayrollOthersDeductionsQueryFormat, 
                                $o["title"], $o["amount"], "OTHERS", $o["employee_id"], $o["payroll_id"], $o["id"]
                            );
                        endforeach;
                        foreach($personal_share as $o):
                            $insertsPersonalDeduction[] = sprintf( 
                                $PayrollPersonalDeductionsQueryFormat, 
                                $o["title"], $o["amount"], "PERSONAL", $row["Employeeid"], $my_payroll["payroll_id"], ""
                            );
                        endforeach;
                        foreach($government_share as $o):
                            $insertGovernmentDeduction[] = sprintf( 
                                $PayrollGovernmentDeductionsQueryFormat, 
                                $o["title"], $o["amount"], "GOVERNMENT", $row["Employeeid"], $my_payroll["payroll_id"], ""
                            );
                        endforeach;
                    endforeach;
                    $query = implode( ",", $inserts );
                    // dump($query);
                    $query_string = 'insert into payroll_actual
                    (
                        payroll_id, year, month, employee_id, finger_id,
                        department_assigned, position_id, position_title,
                        lbp_number, salary, salary_sched_id,salary_class,
                        salary_grade,salary_step,pera,
                        representation_allowance,travel_allowance,
                        lwop,leave_days,actual_days,payroll_type,government_total,personal_total,other_total,net_amount,
                        first_quincena, second_quincena,
                        accrued_ra, accrued_ta, accrued_salary, accrued_pera, gsis_option, negative_salary
                    ) VALUES ' . $query;
                    // dump($query_string);
                    query("delete from payroll_actual where payroll_id = ?", $pg[0]["payroll_id"]);
                    query($query_string);
                    query("delete from payroll_deductions where payroll_id = ?", $pg[0]["payroll_id"]);
                    if(!empty($insertsOthersDeduction)):
                        $query = implode( ",", $insertsOthersDeduction);
                        $query_string = 'insert into payroll_deductions
                        (
                            title, amount, deduction_type, employee_id, payroll_id, lenders_id
                        ) VALUES ' . $query;
                        query($query_string);
                    endif;

                    if(!empty($insertsPersonalDeduction)):
                        $query = implode( ",", $insertsPersonalDeduction);
                        $query_string = 'insert into payroll_deductions
                        (
                            title, amount, deduction_type, employee_id, payroll_id, lenders_id
                        ) VALUES ' . $query;
                        query($query_string);
                    endif;
                    

               

                    if(!empty($insertGovernmentDeduction)):
                        $query = implode( ",", $insertGovernmentDeduction);
                        $query_string = 'insert into payroll_deductions
                        (
                            title, amount, deduction_type, employee_id, payroll_id, lenders_id
                        ) VALUES ' . $query;
                        query($query_string);
                    endif;

                  
                    // dump($query_string);
                    //query("delete from payroll_actual where payroll_id = ?", $pg[0]["payroll_id"]);
                    


                    // query('insert into payroll_actual
                    // (
                    //     payroll_id, year, month, employee_id, finger_id,
                    //     department_assigned, position_id, position_title,
                    //     lbp_number, salary, salary_sched_id,salary_class,
                    //     salary_grade,salary_step,pera,
                    //     representation_allowance,travel_allowance,
                    //     lwop,leave_days,actual_days,payroll_type,
                    //     government_deductions,government_total,
                    //     personal_deductions,personal_total,
                    //     other_deductions,other_total,net_amount,
                    //     first_quincena, second_quincena
                    // ) VALUES '.$query);
                    query("update payroll_group set payroll_status = 'done', date_created = ?, time_created = ?
                        where payroll_id = ?", date("Y-m-d"), date("H:i:s"), $pg[0]["payroll_id"]);
                        $res_arr = [
                            "message" => "Successfully Added",
                            "status" => "success",
                            "link" => "payroll_permanent?action=done&barcode=".$pg[0]["barcode"],
                            ];
                            echo json_encode($res_arr); exit();
                    
              

                    elseif($_POST["action"] == "revert_payroll"):
                        query("update payroll_group set payroll_status = '', date_created = ?, time_created = ? where barcode = ?", date("Y-m-d"), date("H:i:s"), $_POST["barcode"]);
                        $res_arr = [
                            "message" => "Successfully Added",
                            "status" => "success",
                            "link" => "payroll_permanent?action=barcode&barcode=".$_POST["barcode"],
                            ];
                            echo json_encode($res_arr); exit();

                    elseif($_POST["action"] == "modal_gs_done"):

                    $payrollDeductions = query("select * from payroll_deductions where payroll_id = ?
                                                and employee_id = ? and deduction_type = 'GOVERNMENT'",
                                                $_POST["payroll_id"], $_POST["employee_id"]);
                  
                    $hint = '
                    <table class="table table-bordered">
                      <thead>
                          <th>Share</th>
                          <th>Amount</th>
                      </thead>
                      <tbody>
                      ';
                    $total = 0;
                    foreach($payrollDeductions as $g):
                        $total = $total + to_amount($g["amount"]);
                        $hint = $hint . '
                        <tr>
                            <td>'.$g["title"].'</td>
                            <td>'.to_peso($g["amount"]).'</td>
                        </tr>
                        ';
                    endforeach;
                    $hint = $hint . '
                    <tr>
                        <th>Total</th>
                        <th>'.to_peso($total).'</th>
                    </tr>
                    ';
                      $hint = $hint . '
                      </tbody>    
                    </table>
              ';
              echo($hint);


              elseif($_POST["action"] == "modal_ps_done"):
            //   dump($_POST);

                $payrollDeductions = query("select * from payroll_deductions where payroll_id = ? and employee_id = ?
                                            and deduction_type = 'PERSONAL' ", $_POST["payroll_id"], $_POST["employee_id"]);

             
                $hint = '
                <table class="table table-bordered">
                  <thead>
                      <th>Deductions</th>
                      <th>Amount</th>
                  </thead>
                  <tbody>
                  ';
                $total = 0;
                foreach($payrollDeductions as $p):
                    $total = $total + to_amount($p["amount"]);
                    $hint = $hint . '
                    <tr>
                        <td>'.$p["title"].'</td>
                        <td>'.to_peso($p["amount"]).'</td>
                    </tr>
                    ';
                endforeach;
                $hint = $hint . '
                <tr>
                    <th>Total</th>
                    <th>'.to_peso($total).'</th>
                </tr>
                ';
                  $hint = $hint . '
                  </tbody>    
                </table>
                ';
                echo($hint);


                elseif($_POST["action"] == "modal_others_done"):
                   
                        $payrollDeductions = query("select * from payroll_deductions where payroll_id = ? and employee_id = ?
                                                        and deduction_type = 'OTHERS'",  $_POST["payroll_id"], $_POST["employee_id"]);
                        $hint = '
                        <table class="table table-bordered">
                          <thead>
                              <th>Share</th>
                              <th>Amount</th>
                          </thead>
                          <tbody>
                          ';
                        $total = 0;
                        foreach($payrollDeductions as $o):
                            $total = $total + to_amount($o["amount"]);
                            $hint = $hint . '
                            <tr>
                                <td>'.$o["title"].'</td>
                                <td>'.to_peso($o["amount"]).'</td>
                            </tr>
                            ';
                        endforeach;
                        $hint = $hint . '
                        <tr>
                            <th>Total</th>
                            <th>'.to_peso($total).'</th>
                        </tr>
                        ';
                          $hint = $hint . '
                          </tbody>    
                        </table>
                        ';
                        echo($hint);


                    elseif($_POST["action"] == "pacs"):
                        // dump($_POST);
                        $pg = query("select payroll_id from payroll_group where barcode = ?", $_POST["barcode"]);
                        $employees = query("select pa.*, e.FirstName, e.LastName, e.MiddleName from tblemployee e
                                            left join payroll_actual pa
                                            on pa.employee_id = e.Employeeid
                                            where payroll_id = ?
                                            order by LastName, FirstName
                                            ", $pg[0]["payroll_id"]);
                        $fileLocation = "file_folder/pacs/" . $_POST["barcode"] . $_POST["pacs"] . ".txt";
                        $file = fopen($fileLocation,"w");
                        $my_string = "";
                        foreach($employees as $row):
                        $string = $row["lbp_number"] . $row["LastName"] . ", " . $row["FirstName"] . " " . $row["MiddleName"][0] . ".";
                        if($_POST["pacs"] == "q1")
                            $amount = to_findes_amount($row["first_quincena"]);
                        else
                            $amount = to_findes_amount($row["second_quincena"]);
                        // $amount = to_findes_amount($f["net"]);
                        $string = str_pad($string, 50, " ", STR_PAD_RIGHT) . $amount . $string[0] . $string[1] . $string[2] . "00001";
                        $string = str_pad($string, 80, " ", STR_PAD_RIGHT);
                        $string = $string . "\n";
                        $my_string = $my_string . $string;
                        $my_string = str_replace('Ñ','N',$my_string);
                        $my_string = str_replace('-',' ',$my_string);
                        endforeach;

                        fwrite($file,$my_string);
                        fclose($file);
                        $res_arr = [
                            "message" => "Successfully Added",
                            "status" => "success",
                            "option" => "new_tab",
                            "link" => $fileLocation,
                            ];
                            echo json_encode($res_arr); exit();

                        elseif($_POST["action"] == "generate_excel"):
                            // dump($_POST);
                            $pg = query("select pg.*, d.DeptCode, d.DeptName from payroll_group pg
                            left join tbldepartment d
                            on d.Deptid = pg.department_fund
                            where pg.barcode = ?", $_POST["barcode"]);
                            $pg = $pg[0];
                            $department = query("select * from tbldepartment where Deptid = ?", $pg["department_fund"]);
                            $d = $department[0];
                            $payroll_actual = query("select e.Employeeid, e.above_65, Gender, concat(LastName, ' ', NameExtension, ', ', FirstName) as fullname, e.MiddleName, p.* from payroll_actual p
                                                        left join tblemployee e
                                                        on e.Employeeid = p.employee_id
                                                        where payroll_id = ?
                                                        order by LastName asc, FirstName asc", $pg["payroll_id"]);

                            $payrollDeductions = query("select * from payroll_deductions where payroll_id = ?", $pg["payroll_id"]);
                            $PayrollDeductions = [];
                            foreach($payrollDeductions as $row):
                                $PayrollDeductions[$row["employee_id"]][$row["deduction_type"]][$row["id"]] = $row;
                            endforeach; 
                            //dump($PayrollDeductions);

                            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("file_folder/payroll/payroll_permanent.xlsx");
                            $sheet = $spreadsheet->getActiveSheet();
                            $start_row = 15;
                            $beginner_row = $start_row;
                            $number = 1;
                            // dump($payroll);
                            $month = date("F", strtotime($pg["year"] . "-" . $pg["month"] ."-" . "01" ));
                            $end_date = date("t", strtotime($pg["year"] . "-" . $pg["month"] ."-" . "01" ));
                            $year = date("Y", strtotime($pg["year"] . "-" . $pg["month"] ."-" . "01" ));
                            $date_prepared = date("F d, Y", strtotime($pg["date_created"]));
                            $Rows=[];


                            if($pg["department_fund"] == "Dept0005" || $pg["department_fund"] == "Dept0028" || $pg["department_fund"] == "Dept0020" || $pg["department_fund"] == "Dept0021" || $pg["department_fund"] == "Dept0027"):
                                $sheet->setCellValue("A29", "Gregorio U. Dujali III, MPA, MDMG");
                                $sheet->setCellValue("A30", "City Vice Mayor");
                                $sheet->setCellValue("A31", "");
                            endif;

                            $sheet->setCellValue("A4", "For the period " . $month . " 01-" . $end_date . ", " . $year);
                            $sheet->setCellValue("B7", $d["DeptCode"]);
                            $sheet->setCellValue("AG11", strtoupper(to_month($pg["month"])));
                            $sheet->setCellValue("AH11", strtoupper(to_month($pg["month"])));
                            $sheet->setCellValue("AG12", "1-15");
                            $sheet->setCellValue("AH12", "16-".$end_date);
                            $sheet->setCellValue("AF8", $date_prepared);
                            $sheet->setCellValue("AH8", $pg["time_created"]);
                            // $sheet->setCellValue("AA8", $payroll["time_saved"]);
                            // $sheet->setCellValue("Z11", $month);
                            // $sheet->setCellValue("AA11", $month);
                            // $sheet->setCellValue("Z12", "1-15");
                            // $sheet->setCellValue("AA12", "16-".$end_date);
                            // dump($payroll_actual);
                            foreach($payroll_actual as $p):

                                $gsis_gs=0;
                                // dump($p);

                                if($p["above_65"] == "INACTIVE"):
                                    $government_deductions = $PayrollDeductions[$p["employee_id"]]["GOVERNMENT"];
                                    foreach($government_deductions as $g):
                                        if($g["title"] == "GSIS GS")
                                            $gsis_gs = $g["amount"];
                                    endforeach;
                                endif;

                                $name = "";
                                if($p["MiddleName"] != ""):
                                    $name = $p["fullname"] . " " . $p["MiddleName"][0] . ".";
                                else:
                                    $name = $p["fullname"];
                                endif;

                                
                                $employee_start_row = $start_row;
                                $sheet->insertNewRowBefore($start_row);
                                $sheet->setCellValue('A'.$start_row, $number);
                                $sheet->setCellValue('B'.$start_row, $name);
                                $sheet->setCellValue('C'.$start_row, $p["position_title"]);
                                $male = $p["Gender"] == "MALE" ? 1 : "";
                                $female = $p["Gender"] == "FEMALE" ? 1 : "";
                                $sheet->setCellValue('D'.$start_row, $male);
                                $sheet->setCellValue('E'.$start_row, $female);
                                $sheet->setCellValue('F'.$start_row ,$p["finger_id"]);
                                $sheet->setCellValue('G'.$start_row ,$p["salary"]);
                                $sheet->setCellValue('H'.$start_row ,to_amount($p["lwop"]));
                                $sheet->setCellValue('I'.$start_row ,"=ROUND(((G".$start_row."/22))*H".$start_row.",2)");
                                $sheet->setCellValue('J'.$start_row ,"=G".$start_row."-I".$start_row."");
                                $sheet->setCellValue('K'.$start_row ,$p["pera"]);
                                $sheet->setCellValue('L'.$start_row ,"=ROUND(((K".$start_row."/22))*H".$start_row.",2)");
                                $sheet->setCellValue('M'.$start_row ,"=K".$start_row."-L".$start_row."");
                                $sheet->setCellValue('N'.$start_row ,to_amount($p["representation_allowance"]));
                                $sheet->setCellValue('O'.$start_row ,to_amount($p["travel_allowance"]));
                                $sheet->setCellValue('P'.$start_row ,"22");
                                $sheet->setCellValue('Q'.$start_row ,(to_amount($p["lwop"]) + to_amount($p["leave_days"])));
                                $sheet->setCellValue('R'.$start_row ,"=P".$start_row."-Q".$start_row);
                                $sheet->setCellValue('S'.$start_row ,"=ROUND(IF(R".$start_row.">=17,N".$start_row.",IF(R".$start_row.">=12,N".$start_row."*0.75,IF(R".$start_row.">=6,N".$start_row."*0.5,IF(R".$start_row.">=1,N".$start_row."*0.25,0)))),2)");
                                $sheet->setCellValue('T'.$start_row ,"=ROUND(IF(R".$start_row.">=17,O".$start_row.",IF(R".$start_row.">=12,O".$start_row."*0.75,IF(R".$start_row.">=6,O".$start_row."*0.5,IF(R".$start_row.">=1,O".$start_row."*0.25,0)))),2)");
                                $sheet->setCellValue('U'.$start_row ,"=J".$start_row."+M".$start_row."+S".$start_row."+T".$start_row."");
                                $sheet->setCellValue('V'.$start_row ,"=ROUND(IF(G".$start_row."=0,0,IF(G".$start_row."<=10000,400,IF(G".$start_row."<=100000,G".$start_row."*5%,IF(G".$start_row.">100000,5000)))),2)");
                                $sheet->setCellValue('W'.$start_row ,$gsis_gs);
                                // dump($p);
                                if($p["above_65"] == "INACTIVE"):
                                    $sheet->setCellValue('X'.$start_row ,"200");
                                    $sheet->setCellValue('Y'.$start_row ,"=ROUND(V".$start_row."/2,2)");
                                    $sheet->setCellValue('Z'.$start_row ,"=IF(G".$start_row.">=10000,100,G".$start_row."*0.01)");
                                else:
                                    $sheet->setCellValue('X'.$start_row ,"");
                                    $sheet->setCellValue('Y'.$start_row ,"");
                                    $sheet->setCellValue('Z'.$start_row ,"");
                                endif;


                          
                                $personal_deductions = $PayrollDeductions[$p["employee_id"]]["PERSONAL"];
                                $personal_limit = 0;
                                foreach($personal_deductions as $d):
                                    if($d["amount"] != ""):
                                        if($personal_limit!=0){
                                            $start_row++;
                                            $sheet->insertNewRowBefore($start_row);
                                        }
                                        $sheet->setCellValue('AA'.$start_row ,$d["title"]);
                                        $sheet->setCellValue('AB'.$start_row ,trim($d["amount"]));
                                        $personal_limit++;
                                    endif;
                                endforeach;

                            
                                $other_deductions = "";
                                if(isset($PayrollDeductions[$p["employee_id"]]["OTHERS"])):
                                    $other_deductions = $PayrollDeductions[$p["employee_id"]]["OTHERS"];
                                endif;
                                //unserialize($p["other_deductions"]);
                                $i = 1;
                                if($other_deductions != ""){
                                    foreach($other_deductions as $ded):
                                        if($i<=$personal_limit){
                                            $sheet->setCellValue('AC'.($employee_start_row +($i-1)) ,$ded["title"]);
                                            $sheet->setCellValue('AD'.($employee_start_row +($i-1)) ,$ded["amount"]);
                                        }
                                        else{
                                            $start_row++;
                                            $sheet->insertNewRowBefore($start_row);
                                            $sheet->setCellValue('AC'.($start_row) ,$ded["title"]);
                                            $sheet->setCellValue('AD'.($start_row) ,$ded["amount"]);
                                        }
                                        $i++;
                                    endforeach;
                                }
                                $i--;
                                if($i == 0 || $i == 1){
                                    $i = 0;
                                }
                                else{
                                    $i--;
                                }
                                $start_row++;
                                $sheet->insertNewRowBefore($start_row);
                                $sheet->setCellValue('AE'.($start_row) ,"=SUM(AB".$employee_start_row.":AB".($employee_start_row+($personal_limit-1)).",AD".$employee_start_row.":AD".($employee_start_row+$i).")");
                                $sheet->getStyle('AE'.($start_row))->getFont()->setBold( true );
                                $sheet->setCellValue('AF'.($start_row) ,"=U".$employee_start_row."-AE".$start_row."");
                                $sheet->getStyle('AF'.($start_row))->getFont()->setBold( true );
                                // $sheet->setCellValue('AG'.($start_row) ,"=ROUND(((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2),2)+S".$employee_start_row."+T".$employee_start_row."");
                                // dump($p);
                                if($p["negative_salary"] == "1"):
                                    $sheet->setCellValue('AG'.($start_row) ,$p["first_quincena"]);
                                $sheet->getStyle('AG'.($start_row))->getFont()->setBold( true );
                                // $sheet->setCellValue('AH'.($start_row) ,$p["first_quincena"]);
                                // $sheet->getStyle('AH'.($start_row))->getFont()->setBold( true );
                                $sheet->setCellValue('AH'.($start_row) ,"=AF".$start_row."-AG".$start_row."");
                                $sheet->getStyle('AH'.($start_row))->getFont()->setBold( true );

                                else:
                                    $sheet->setCellValue('AG'.($start_row) ,"=(TRUNC((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2,0) + (((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2 - TRUNC((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2)) + ((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2 - TRUNC((AF".$start_row."-(S".$employee_start_row."+T".$employee_start_row."))/2)))) + S".$employee_start_row." + T".$employee_start_row."");
                                    $sheet->getStyle('AG'.($start_row))->getFont()->setBold( true );
                                    $sheet->setCellValue('AH'.($start_row) ,"=AF".$start_row."-AG".$start_row."");
                                    $sheet->getStyle('AH'.($start_row))->getFont()->setBold( true );
                                    
                                
                                endif;
                                
                                
                                
                                // //total mandatory personal
                                // $sheet->setCellValue('U'.($start_row) ,"=SUM(U".($employee_start_row).":U".($employee_start_row+($mandatory_limit-1)).")");
                                // $sheet->getStyle('U'.($start_row))->getFont()->setBold( true );
                                // //end total mandatory personal
                                // $sheet->setCellValue('W'.($start_row) ,"=SUM(W".$employee_start_row.":W".($employee_start_row+$i).")");
                                // $sheet->getStyle('W'.($start_row))->getFont()->setBold( true );
                                
                                // $sheet->setCellValue('Y'.($start_row) ,"=N".$employee_start_row."-X".$start_row."");
                                // $sheet->getStyle('Y'.($start_row))->getFont()->setBold( true );
                                
                                // // $sheet->setCellValue('Z'.($start_row) ,"=(TRUNC((N".$employee_start_row."-X".$start_row.")/2,0) + (((N".$employee_start_row."-X".$start_row.")/2 - TRUNC((N".$employee_start_row."-X".$start_row.")/2)) + ((N".$employee_start_row."-X".$start_row.")/2 - TRUNC((N".$employee_start_row."-X".$start_row.")/2))))");
                                // $sheet->setCellValue('Z'.($start_row) ,"=(N".$employee_start_row."-X".$start_row.")/2");
                                // $sheet->getStyle('Z'.($start_row))->getFont()->setBold( true );
                                
                                // $sheet->setCellValue('AA'.($start_row) ,"=(N".$employee_start_row."-X".$start_row.")/2");
                                // // $sheet->setCellValue('AA'.($start_row) ,"=TRUNC((N".$employee_start_row."-X".$start_row.")/2,0)");
                                // $sheet->getStyle('AA'.($start_row))->getFont()->setBold( true );
                                // // $objPHPExcel->getActiveSheet()->getStyle( $cell_name )->getFont()->setBold( true );
                                
                                
                                
                                //other deductions end

                                $counter = $start_row - $employee_start_row;
                                // $excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                                $sheet->getRowDimension($employee_start_row)->setRowHeight(-1); 
               
                                for($c = 1; $c <= $counter; $c++):
                                    $sheet->getRowDimension($employee_start_row + $c)->setRowHeight(20); 
                                endfor;
                                
                                $Row[$p["Employeeid"]]["start_row"] = $employee_start_row;
                                $Row[$p["Employeeid"]]["end_row"] = $start_row;

                                $letters = array(
                                    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
                                    "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
                                    "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD",
                                    "AE", "AF", "AG", "AH"
                                );

                                foreach($letters as $l):
                                    $cell = $l .  $employee_start_row;
                                    $spreadsheet
                                    ->getActiveSheet()
                                    ->getStyle($cell)
                                    ->getBorders()
                                    ->getTop()
                                    ->setBorderStyle(Border::BORDER_THIN)
                                    ->setColor(new Color('000'));
                                endforeach;
                              


                                

                                


                                
                                
                                $start_row++;
                                $number++;
                                
                            endforeach;
                            // dump($payroll_actual);
                            $ending_row = $start_row;
                            $ender = $ending_row-1;

                            // $sheet->setCellValue("=D".$beginner_row);
                            $sheet->setCellValue('D'.($ending_row) ,"=SUM(D".$beginner_row.":D".$ender.")");
                            $sheet->setCellValue('E'.($ending_row) ,"=SUM(E".$beginner_row.":E".$ender.")");
                            // $sheet->setCellValue('F'.($ending_row) ,"=SUM(F".$beginner_row.":F".$ender.")");
                            $sheet->setCellValue('G'.($ending_row) ,"=SUM(G".$beginner_row.":G".$ender.")");
                            $sheet->setCellValue('H'.($ending_row) ,"=SUM(H".$beginner_row.":H".$ender.")");
                            $sheet->setCellValue('I'.($ending_row) ,"=SUM(I".$beginner_row.":I".$ender.")");
                            $sheet->setCellValue('J'.($ending_row) ,"=SUM(J".$beginner_row.":J".$ender.")");
                            $sheet->setCellValue('K'.($ending_row) ,"=SUM(K".$beginner_row.":K".$ender.")");
                            $sheet->setCellValue('L'.($ending_row) ,"=SUM(L".$beginner_row.":L".$ender.")");
                            $sheet->setCellValue('M'.($ending_row) ,"=SUM(M".$beginner_row.":M".$ender.")");
                            $sheet->setCellValue('S'.($ending_row) ,"=SUM(S".$beginner_row.":S".$ender.")");
                            $sheet->setCellValue('T'.($ending_row) ,"=SUM(T".$beginner_row.":T".$ender.")");
                            $sheet->setCellValue('U'.($ending_row) ,"=SUM(U".$beginner_row.":U".$ender.")");
                            $sheet->setCellValue('W'.($ending_row) ,"=SUM(W".$beginner_row.":W".$ender.")");
                            $sheet->setCellValue('X'.($ending_row) ,"=SUM(X".$beginner_row.":X".$ender.")");
                            $sheet->setCellValue('Y'.($ending_row) ,"=SUM(Y".$beginner_row.":Y".$ender.")");
                            $sheet->setCellValue('Z'.($ending_row) ,"=SUM(Z".$beginner_row.":Z".$ender.")");
                            $sheet->setCellValue('AE'.($ending_row) ,"=SUM(AE".$beginner_row.":AE".$ender.")");
                            $sheet->setCellValue('AF'.($ending_row) ,"=SUM(AF".$beginner_row.":AF".$ender.")");
                            $sheet->setCellValue('AG'.($ending_row) ,"=SUM(AG".$beginner_row.":AG".$ender.")");
                            $sheet->setCellValue('AH'.($ending_row) ,"=SUM(AH".$beginner_row.":AH".$ender.")");
                            $sheet->removeRow(14);
                            $sheet->removeRow(13);
                            


                            

                            



                            $writer = new Xlsx($spreadsheet);
                            $filename = $pg["DeptCode"]. "-" . $pg["barcode"] . ".xlsx";
                            $path = 'file_folder/payroll/'.$filename;


                            $writer->save($path);
                            $res_arr = [
                                "message" => "Successfully Added",
                                "status" => "success",
                                "option" => "new_tab",
                                "link" => $path,
                                ];
                                echo json_encode($res_arr); exit();
                                            
                        


        endif;

        
        
    
    }
    else
    {
        if(isset($_GET["action"])):
            if($_GET["action"] == "barcode"):
                // dump($_GET);
                $pg = query("select * from payroll_group where barcode = ?", $_GET["barcode"]);
                // dump($pg);
                $pa = query("select * from payroll_actual pa
                                left join tblemployee emp
                                on emp.Employeeid = pa.employee_id
                                where pa.payroll_id = ?
                                order by emp.LastName ASC, emp.FirstName ASC", $pg[0]["payroll_id"]);
                $loans = query("select * from loans_management");
                $Loans = [];
                foreach($loans as $row):
                    $Loans[$row["employee_id"]][$row["loans_id"]] = $row;
                endforeach;
                $lenders = query("select * from lenders_management");
                $Lenders = [];
                foreach($lenders as $row):
                    $Lenders[$row["lenders_id"]] = $row;
                endforeach;
                $pchgea_burial = query("select * from pchgea_burial where year = ?
                                and month = ?", $pg[0]["year"], $pg[0]["month"]);
                $mandatory = query("select * from employee_mandatory");
                $Mandatory = [];
                foreach($mandatory as $row):
                    $Mandatory[$row["employee_id"]] = $row;
                endforeach;
                $salary = query("select * from tbl_salary_sched sched
                                left join tbl_salary_grade grade
                                on grade.salary_schedule_id = sched.salary_schedule_id");
                $Salary = [];
                foreach($salary as $row):
                    $Salary[$row["schedule"]][$row["salary_grade"]][$row["step"]]["salary"] = $row["salary"];
                endforeach;
                // dump($Lenders);
                // dump($pa);
                // $burial = query("select * from pchgea_burial order by year desc, month desc");
                render("apps/payroll/payroll_permanent_app/payroll_permanent_barcode.php", 
                [
                    "title" => "Loans Management", 
                    "payroll_group" => $pg, 
                    "payroll_actual" => $pa, 
                    "Loans" => $Loans, 
                    "Lenders" => $Lenders, 
                    "Mandatory" => $Mandatory, 
                    "Salary" => $Salary, 
                    "pchgea_burial" => $pchgea_burial, 
                ],"payroll");
                // elseif($_GET["action"] == "mandatory_employee"):
                //     $employee = query("select Employeeid, Fingerid, concat(LastName, ', ', FirstName, ' ' , NameExtension) as name from tblemployee
                //                         where Employeeid = ?", $_GET["id"]);
                //     $employee = $employee[0];
                //     $mandatory = query("select * from employee_mandatory where employee_id = ?", $_GET["id"]);
                //     $mandatory = $mandatory[0];
                //     render("apps/payroll/mandatory_deductions_app/mandatory_employee.php", 
                //     [
                //         "title" => "Mandatory Employee", 
                //         "employee" => $employee, 
                //         "mandatory" => $mandatory, 
                
                //     ],"payroll");
                elseif($_GET["action"] == "done"):
                    $pg = query("select * from payroll_group where barcode = ?", $_GET["barcode"]);
                    $pg = $pg[0];
                    $payroll_actual = query("
                    select pa.*, e.FirstName, e.LastName from payroll_actual pa
                    left join tblemployee e
                    on pa.employee_id = e.Employeeid
                    where payroll_id = ?
                    order by e.LastName ASC, e.FirstName ASC
                    ", $pg["payroll_id"]);
                    // dump($payroll_actual);
                    render("apps/payroll/payroll_permanent_app/payroll_permanent_done.php", 
                    [
                        "title" => "Payroll Done", 
                        "payroll_actual" => $payroll_actual, 
                        "pg" => $pg, 
                    ],"payroll");
            endif;
        else:
            // dump($_GET);

            $department = query("select * from tbldepartment");

            $payroll_group = query("select pg.*, d.DeptCode from payroll_group pg
                                    left join tbldepartment d
                                    on d.Deptid = pg.department_fund
                                    where 
                                    employment_status in ('PERMANENT', 'COTERMINOUS', 'PERMANENT/COTERMINOUS')
                                    and payroll_design = 'standard'
                                    order by str_to_date(date_created, '%Y-%m-%d') desc, CAST(time_created as time) desc");
            // dump($payroll_group);

            render("apps/payroll/payroll_permanent_app/payroll_permanent_list.php", 
                ["title" => "PAYROLL PERMANENT",
                 "payroll_group" => $payroll_group,
                 "department" => $department,
                
                
                ],"payroll");
        endif;
       


        
    }
?>