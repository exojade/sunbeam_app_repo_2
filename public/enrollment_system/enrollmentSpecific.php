<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
<style>
  #sectionTable td{
    border: 0px;
    padding: 5px 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 5px 0px;
  }


  #advisorySection td{
    border: 0px;
    padding: 0px;
  }
  #advisorySection th{
    border: 0px;
    padding: 0px;
  }
</style>
<div class="content-wrapper">

<?php
$enrollment = query("select e.*, s.section, sy.school_year from 
                        enrollment e left join advisory a
                        on a.advisory_id = e.advisory_id
                        left join section s
                        on s.section_id = a.section_id
                        left join school_year sy
                        on sy.syid = e.syid
                      where e.enrollment_id = ?", $_GET["id"]);
$enrollment = $enrollment[0];

$student = query("select s.*, sy.school_year, e.grade_level, e.status as enrollment_status from student s
                        left join enrollment e
                        on e.enrollment_id = s.current_enrollment_id
                        left join school_year sy
                        on sy.syid = e.syid
                        where s.student_id = ?", $enrollment["student_id"]);
                        $student = $student[0];

// dump(get_defined_vars());





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
          <div class="col-md-3">
          <?php if($enrollment["status"] == "PENDING"): ?>
          <div class="alert alert-warning alert-block">
            <h5><i class="icon fas fa-ban"></i> PENDING !</h5>
          </div>
          <?php elseif($enrollment["status"] == "ENROLLED"): ?>
            <div class="alert alert-primary alert-block">
            <h5><i class="icon fas fa-check"></i> ENROLLED !</h5>
          </div>
          <?php elseif($enrollment["status"] == "CANCELLED"): ?>
            <div class="alert alert-danger alert-block">
            <h5><i class="icon fas fa-close"></i> CANCELLED !</h5>
          </div>
          <?php endif; ?>
            <!-- Profile Image -->




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
          <div class="col-md-9">
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


                  <div class="row">
                    <div class="col-7">


                    <div class="card p-3">

                    <table class="table" id="sectionTable">
                 
                 <tr>
                   <th>Student Name:</th>
                   <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                   </tr>
                   <tr>
                   <th>Student Code:</th>
                   <td><?php echo($student["student_id"]); ?></td>
                  </tr>
                 
                 <tr>
                   <th>Birth Date:</th>
                   <td><?php echo($student["birthDate"]); ?></td>
                  </tr>
                  <tr>
                   <th>Birth Place:</th>
                   <td><?php echo($student["birthPlace"]); ?></td>
                 </tr>
                 <tr>
                   <th>Religion:</th>
                   <td><?php echo($student["religion"]); ?></td>
          </tr>
          <tr>
                   <th>Sex:</th>
                   <td><?php echo($student["sex"]); ?></td>
                 </tr>
                 <tr>
                   <th>City:</th>
                   <td><?php echo($student["city_mun"]); ?></td>
                 </tr>
                 <tr>
                   <th>Barangay:</th>
                   <td><?php echo($student["barangay"] . " , " . $student["address"]); ?></td>
                 </tr>
                 <tr>
                   <th>Address:</th>
                   <td><?php echo($student["address"]); ?></td>
                 </tr>
              

                 
               </table>

                    </div>
                    </div>
                    <div class="col-5">

                    <div class="card p-3">
                    <h5 class="card-title text-black"><b><?php echo($student["father_lastname"] . ", " . $student["father_firstname"]); ?></b></h5>
                    <p class="card-text text-gray m-0">Father</p>
                    <p class="card-text text-gray m-0"><?php echo($student["father_occupation"]); ?></p>
                    <p class="card-text text-gray m-0"><?php echo($student["father_education"]); ?></p>
                    <p class="card-text text-gray mdd-0"><?php echo($student["father_contact"] . " / " . $student["father_fb"]); ?></p>
          </div>


          <div class="card p-3">
                    <h5 class="card-title text-black"><b><?php echo($student["mother_lastname"] . ", " . $student["mother_firstname"]); ?></b></h5>
                    <p class="card-text text-gray m-0">Mother</p>
                    <p class="card-text text-gray m-0"><?php echo($student["mother_occupation"]); ?></p>
                    <p class="card-text text-gray m-0"><?php echo($student["mother_education"]); ?></p>
                    <p class="card-text text-gray mdd-0"><?php echo($student["mother_contact"] . " / " . $student["mother_fb"]); ?></p>
          </div>
                    
                    <table class="table" id="sectionTable">

                    
       

          </table>
                    </div>
                  </div>

                 

                 

             
                  </div>

                  <div class=" tab-pane" id="grades">
                  <div class="row">
                
                    
                    <div class="col-12">
                      <div class="row">
                        <div class="col-3">
                        <select style="width: 100%;" required id="enrollmentSelect" class="form-control select2 selectFilter">
                            <option value="<?php echo($enrollment["enrollment_id"]); ?>"><?php echo($enrollment["school_year"]); ?></option>
                        </select>
                        </div>
                        <div class="col-9">
                          <form class="generic_form_trigger" data-url="enrollment">
                            <input type="hidden" name="action" value="printEnrollmentForm">
                            <input type="hidden" name="enrollmentId" value="<?php echo($_GET["id"]); ?>">
                            <button class="btn btn-info">Print Enrollment Form</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>

                    <h5 class="bg-teal p-2">Advisory Details</h5>

                  <table class="table" id="advisorySection">
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



                  <table style="width: 100%;" id="ajaxDatatable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Subject</th>
                        <th>G1</th>
                        <th>G2</th>
                        <th>G3</th>
                        <th>G4</th>
                        <th>Final</th>
                      </tr>
                    </thead>
                  </table>


                 

             
                  </div>

                  <div class=" tab-pane" id="payment_history">
                  <form class="generic_form_trigger" data-url="enrollment">
                  <div class="row mb-2">
                  <input type="hidden" name="action" value="printSOA">
                <div class="col-6">
                  <div class="form-group">
                  <select style="width:100%;" name="enrollment_id" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                              <option value="<?php echo($enrollment["enrollment_id"]); ?>"><?php echo($enrollment["school_year"]); ?></option>
                          </select>
                  </div>
                          
                     
                    </div>
                    
                    <div class="col-6">
                      <button type="submit" class="btn btn-info float-right" >PRINT Statement of Account</button>
                    </div>
                    
                  </div>
                  </form>
                  <table style="width: 100%;" id="ajaxDatatable2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>School Year</th>
                        <th>Date Paid</th>
                        <th>OR Number</th>
                        <th>From</th>
                        <th>Paid</th>
                        <th>Remaining</th>
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
    </section>
  </div>

  <script src="AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
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

$('.select2').select2({
    });


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
                    { data: 'action', "orderable": false  },
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

  Swal.fire({title: 'Please wait...',
    showClass: {
    popup: `
      animate__animated
      animate__bounceIn
      animate__faster
    `
  },
  hideClass: {
    popup: `
      animate__animated
      animate__bounceOut
      animate__faster
    `
  },
    
    imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
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
                    { data: 'school_year', "orderable": false  },
                    
                    { data: 'date_paid', "orderable": false  },
                    { data: 'or_number', "orderable": false  },
                    {
                        data: 'from_balance', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    {
                        data: 'amount_due', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    {
                        data: 'to_balance', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
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