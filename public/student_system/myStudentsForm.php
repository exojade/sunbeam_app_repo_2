<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
<!-- <style>
  #sectionTable td{
    border: 0px;
    padding: 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 0px;
  }


  #advisorySection td{
    border: 0px;
    padding: 0px;
  }
  #advisorySection th{
    border: 0px;
    padding: 0px;
  }
</style> -->
<div class="content-wrapper">

<?php
// $enrollment = query("select e.*, s.section from 
//                         enrollment e left join advisory a
//                         on a.advisory_id = e.advisory_id
//                         left join section s
//                         on s.section_id = a.section_id
//                       where e.enrollment_id = ?", $_GET["id"]);
// $enrollment = $enrollment[0];

$student = query("select s.*, sy.school_year, e.grade_level, e.status as enrollment_status from student s
                        left join enrollment e
                        on e.enrollment_id = s.current_enrollment_id
                        left join school_year sy
                        on sy.syid = e.syid
                        where s.student_id = ?", $_GET["id"]);
                        $student = $student[0];


                        $StudentEnrollment = query("select * from enrollment where student_id = ?", $_GET["id"]);
                        // dump($school_year[0]);
                        $boolEnrolled = 0;
                        foreach($StudentEnrollment as $s):
                          if($s["syid"] == $school_year[0]["syid"]):
                            $boolEnrolled = 1;
                          endif;
                        endforeach;

$enrollment = query("select * from enrollment e
                    left join advisory a
                    on a.advisory_id = e.advisory_id
                    left join section s
                    on s.section_id = a.section_id
                    where e.enrollment_id = ?", $student["current_enrollment_id"]);
$enrollment = $enrollment[0];


$enrollmentList = query("select e.*, sy.school_year from enrollment e
                          left join school_year sy
                          on sy.syid = e.syid
                          where student_id = ?
                          order by sy.school_year desc
                          ", $_GET["id"]);


?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
          <?php if($boolEnrolled == 0): ?>
          <div class="alert alert-warning alert-block">
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            Student Not Enrolled in this School Year
          </div>
          <?php endif; ?>
            <!-- Profile Image -->



            <?php 

            // dump(get_defined_vars());
            // if($currentInstallmentNumber != 0)
            $payment_balance = query("
            SELECT 
                SUM(CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END) AS total_amount
            FROM 
                installment ins
            left join enrollment e
            on e.enrollment_id = ins.enrollment_id
            WHERE 
                ins.installment_number <= ?
                and ins.syid = ?
                and e.student_id = ?
            ", $currentInstallmentNumber, $sy["syid"], $_GET["id"]);
              ?>

            <?php if(floatval($payment_balance[0]["total_amount"]) != 0): ?>
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>₱ <?php echo(number_format(floatval($payment_balance[0]["total_amount"]),2)); ?></h3>
                <p>Due on <?php echo(date('F d, Y', strtotime($payment_settings[0]["dueDate"]))); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
            <?php endif; ?>



            <div class="small-box bg-info">
              <div class="inner">

       
              <?php 

            // dump(get_defined_vars());
            // if($currentInstallmentNumber != 0)
            $payment_balance = query("
            SELECT 
                SUM(CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END) AS total_amount
            FROM 
                installment ins
            left join enrollment e
            on e.enrollment_id = ins.enrollment_id
            WHERE 
                ins.installment_number <= ?
                and ins.syid = ?
                and e.student_id = ?
            ", $currentInstallmentNumber, $sy["syid"], $_GET["id"]);


            $outstanding_balance = query("
            SELECT 
                SUM(CASE WHEN is_paid = 'CREDIT' OR is_paid = 'NOT DONE' THEN amount_due ELSE 0 END) AS total_amount
            FROM 
                installment ins
            left join enrollment e
            on e.enrollment_id = ins.enrollment_id
            WHERE 
                ins.installment_number <= 11
                and ins.syid = ?
                and e.student_id = ?
            ", $sy["syid"], $_GET["id"]);
              ?>
                <h3>₱ <?php echo(number_format(floatval($outstanding_balance[0]["total_amount"]),2)); ?></h3>
                <p>Outstanding Balance as of <?php echo(date("F d, Y")); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>



            <div class="card card-primary card-outline">
            <div class="card-header bg-primary">
                <h3 >Student Info</h3>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="AdminLTE_new/dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo($student["lastname"].", ".$student["firstname"]); ?></h3>

                <p class="text-muted text-center"><?php echo($student["student_id"]); ?></p>

                <hr>

             

                
                <div class="text-center">

                <strong> Grade Level</strong>
                <p class="text-muted">
                  <?php echo($enrollment["grade_level"]); ?>
                </p>


                <strong> Section</strong>
                <p class="text-muted">
                  <?php echo($enrollment["section"]); ?>
                </p>
        </div>



              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile Info</a></li>
                  <li class="nav-item"><a class="nav-link " href="#grades" data-toggle="tab">Grades</a></li>
                  <li class="nav-item"><a class="nav-link " href="#payment_history" data-toggle="tab">Payment History</a></li>
             
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="profile">

                  <table class="table table-bordered" id="sectionTable">
                 
                    <tr>
                      <th>Student Code:</th>
                      <td colspan="3"><?php echo($student["student_id"]); ?></td>
                    </tr>
                    <tr>
                      <th>Student Name:</th>
                      <td colspan="3"><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                    </tr>
                    
                    <tr>
                      <th>Birth Date:</th>
                      <td><?php echo($student["birthDate"]); ?></td>
                      <th>Birth Place:</th>
                      <td><?php echo($student["birthPlace"]); ?></td>
                    </tr>
                    <tr>
                      <th>Religion:</th>
                      <td><?php echo($student["religion"]); ?></td>
                      <th>Sex:</th>
                      <td><?php echo($student["sex"]); ?></td>
                    </tr>
                    <tr>
                      <th>Address:</th>
                      <td colspan="3"><?php echo($student["province"] . " , " . $student["city_mun"] . " , " . $student["barangay"] . " , " . $student["address"]); ?></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Father:</th>
                      <td><?php echo($student["father_lastname"] . ", " . $student["father_firstname"]); ?></td>
                      <th>Contact / FB:</th>
                      <td><?php echo($student["father_contact"] . " / " . $student["father_fb"]); ?></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><?php echo($student["father_occupation"]); ?></td>
                      <th>Education:</th>
                      <td><?php echo($student["father_education"]); ?></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Mother:</th>
                      <td><?php echo($student["mother_lastname"] . ", " . $student["mother_firstname"]); ?></td>
                      <th>Contact / FB:</th>
                      <td><?php echo($student["mother_contact"] . " / " . $student["mother_fb"]); ?></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><?php echo($student["mother_occupation"]); ?></td>
                      <th>Education:</th>
                      <td><?php echo($student["mother_education"]); ?></td>
                    </tr>
                  </table>

                 

             
                  </div>

                  <div class=" tab-pane" id="grades">
                  <div class="row">
                
                    
                    <div class="col-12">
                      <div class="row">
                        <div class="col-3">
                        <select style="width: 100%;" required id="enrollmentSelect" class="form-control select2 selectFilter">
                        <?php foreach($enrollmentList as $eList):?>

<?php
  if($sy["syid"] == $eList["syid"]):
?>
<option selected value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  else: ?>

<option value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  endif;
  ?>
<?php endforeach; ?>
                        </select>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <br>

                    <h5 class="bg-teal p-2">Advisory Details</h5>

                  <table class="table table-bordered" id="advisorySection">
                 <tr>
                   <th>Grade Level:</th>
                   <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                   <th>Section:</th>
                   <td><?php echo($student["student_id"]); ?></td>
                 </tr>

                 <tr>
                   <th>Adviser:</th>
                   <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                   <th>Year Level:</th>
                   <td><?php echo($student["student_id"]); ?></td>
                 </tr>
               </table>

               <?php if($student["grade_settings"] == "ACTIVE"): ?>
                  <table style="width: 100%;" id="ajaxDatatable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Subject</th>
                        <th>G1</th>
                        <th>G2</th>
                        <th>G3</th>
                        <th>G4</th>
                        <th>Final</th>
                      </tr>
                    </thead>
                  </table>
               <?php else: ?>

                <div class="alert alert-danger alert-dismissible">
                  <h5><i class="icon fas fa-ban"></i> System Notification!</h5>
                  Your child's grade(s) are subject for revision due some data error. We ask for an apology on this concern. Once the the grade(s) are finally done, 
                  we will enable it again so that you will see the final and updated grades(s) of your child.
                </div>

               <?php endif; ?>



                  


                 

             
                  </div>

                  <div class=" tab-pane" id="payment_history">
                  <form class="generic_form_trigger" data-url="enrollment">
                  <div class="row mb-2">
                  <input type="hidden" name="action" value="printSOA">
                <div class="col-6">
                  <div class="form-group">
                  <select style="width:100%;" name="enrollment_id" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                  <?php foreach($enrollmentList as $eList):?>

<?php
  if($sy["syid"] == $eList["syid"]):
?>
<option selected value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  else: ?>

<option value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  endif;
  ?>
<?php endforeach; ?>
                          </select>
                  </div>
                          
                     
                    </div>
                    
                    <div class="col-6">
                      <button type="submit" class="btn btn-info float-right" >Print Statement of Account</button>
                    </div>
                    
                  </div>
                  </form>
                  <div class="table-responsive">
                  <table style="width: 100%;" id="ajaxDatatable2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>School Year</th>
                        <th>Date Paid</th>
                        <th>OR Number</th>
                        <th>Paid</th>
                        <th>Type</th>
                      </tr>
                    </thead>
                  </table>
                            </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <script src="AdminLTE_new/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="AdminLTE_new/plugins/jszip/jszip.min.js"></script>
  <script src="AdminLTE_new/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="AdminLTE_new/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>




            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }
        </script>


<script>


loadDetails()

// $('.select2').select2({
//     });


var enrollment_id = $('#enrollmentSelect').val() || "";
var datatable = 
            $('#ajaxDatatable').DataTable({
                "searching": false,
                "pageLength": 9999,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": false,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'student',
                     'type': "POST",
                     "data": function (data){
                        data.action = "gradeList";
                        data.enrollment_id = enrollment_id;
                     }
                },
                'columns': [
                    // { data: 'action', "orderable": false  },
                    { data: 'subject', "orderable": false  },
                    { data: 'first_grading', "orderable": false  },
                    { data: 'second_grading', "orderable": false  },
                    { data: 'third_grading', "orderable": false  },
                    { data: 'fourth_grading', "orderable": false  },
                    { data: 'average', "orderable": false  },


                ],
                "footerCallback": function (row, data, start, end, display) {
    var api = this.api();

    // Remove the formatting to get integer data for summation
    var intVal = function (i) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
                i : 0;
    };

    // Total over all pages
    var received = api
        .column(2)
        .data()
        .reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0);

    // Calculate installment
    var installment = received / 10;

    // Format the output
    var formattedReceived = '₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    var formattedInstallment = '₱ ' + installment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });



    // Update the footer
    $('#feeTotal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#totalVal').val(received);
}
            });


  function loadDetails(){
  // alert("awit");

  var enrollment_id = $('#enrollmentSelect').val() || "";
  // alert(enrollment_id);

  Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'student', //Here you will fetch records 
            data: {
              enrollment_id: enrollment_id, action: "advisoryDetailsHTML"
            },
            success : function(data){
                $('#advisorySection').html(data);
         
                // $(".select2").select2();//Show fetched data from database
            }
        });
        Swal.close();
 
}  

            $('.selectFilter').on('change', function() {
              loadDetails();

              var thisEnrollmentID = $('#enrollmentSelect').val() || "";
              // alert(thisEnrollmentID);
              datatable.ajax.url('student?action=gradeList&thisEnrollmentID='+thisEnrollmentID).load();
 
              });



























              var datatable2 = 
            $('#ajaxDatatable2').DataTable({
                "searching": false,
                "pageLength": 9999,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": false,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'studentAccounts',
                     'type': "POST",
                     "data": function (data){
                        data.action = "paymentHistoryList";
                        data.enrollment_id = enrollment_id;
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'school_year', "orderable": false  },
                    
                    { data: 'date_paid', "orderable": false  },
                    { data: 'or_number', "orderable": false  },
                    // {
                    //     data: 'from_balance', 
                    //     orderable: false,
                    //     render: function (data, type, row) {
                    //         return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                    //     }
                    // },
                    {
                        data: 'amount_due', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    // {
                    //     data: 'to_balance', 
                    //     orderable: false,
                    //     render: function (data, type, row) {
                    //         return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                    //     }
                    // },
                    { data: 'type', "orderable": false  },

                ],
                "footerCallback": function (row, data, start, end, display) {
    var api = this.api();

    // Remove the formatting to get integer data for summation
    var intVal = function (i) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
                i : 0;
    };

    // Total over all pages
    var received = api
        .column(1)
        .data()
        .reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0);

    // Calculate installment
    var installment = received / 10;

    // Format the output
    var formattedReceived = '₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    // var formattedInstallment = '₱ ' + installment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    // Update the footer
    $('#feeTotal').html(formattedReceived);
    // $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#totalVal').val(received);
}
            });
            $('.selectFilter2').on('change', function() {
              var enrollmentFilterID = $('#enrollmentSelect2').val() || "";
              datatable2.ajax.url('studentAccounts?action=paymentHistoryList&enrollmentFilterID='+enrollmentFilterID).load();
              });



            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }
        </script>


  <?php require("layouts/footer.php") ?>