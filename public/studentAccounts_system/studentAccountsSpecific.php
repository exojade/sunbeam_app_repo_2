<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
<style>
  #sectionTable td{
    border: 0px;
    padding: 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 0px;
  }
</style>
<div class="content-wrapper">

<?php
$student = query("select * from student where student_id = ?", $_GET["id"]);
$student = $student[0];

$enrollment = query("select e.*, s.section from 
                        enrollment e left join advisory a
                        on a.advisory_id = e.advisory_id
                        left join section s
                        on s.section_id = a.section_id
                      where e.enrollment_id = ?", $student["current_enrollment_id"]);
$enrollment = $enrollment[0];

$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
$student = $student[0];

$enrollmentList = query("select e.*, sy.school_year from enrollment e
                          left join school_year sy
                          on sy.syid = e.syid
                          where student_id = ?
                          order by syid desc
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
  <div class="col">
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

<div class="small-box bg-warning">
  <div class="inner">
    <h3>₱ <?php echo(number_format(floatval($payment_balance[0]["total_amount"]),2)); ?></h3>
    <p>Due on <?php echo(date('F d, Y', strtotime($payment_settings[0]["dueDate"]))); ?></p>
  </div>
  <div class="icon">
    <i class="ion ion-pie-graph"></i>
  </div>
</div>

  </div>

  <div class="col">

  <div class="small-box bg-info">
  <div class="inner">
  <?php 

// dump(get_defined_vars());
// if($currentInstallmentNumber != 0)



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
  </div>
</div>

        <div class="row">
          <div class="col-md-4">
          <?php if($enrollment["status"] == "PENDING"): ?>
          <div class="alert alert-warning alert-block">
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Enrollment still pending
                </div>
        <?php endif; ?>
            <!-- Profile Image -->

      <div class="modal fade" id="newPaymentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Payment Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="studentAccounts">
                <input type="hidden" name="enrollment_id" id="enrollmentIdHidden">
                <input type="hidden" name="action" value="payment">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Amount</label>
                    <input required name="amount" type="number" step="0.01" id="amountInput" class="form-control" placeholder="Enter ...">
                  </div>
                  <div class="form-group">
                    <label>OR Number</label>
                    <input required name="or_number" type="text" class="form-control" placeholder="Enter ...">
                  </div>
                  <div class="form-group">
                    <label>Paid By</label>
                    <input required name="paid_by" type="text" class="form-control" placeholder="Enter ...">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                  </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modalEnrollStudent">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">PROCEED TO DOWNPAYMENT</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="totalVal">
              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="enrollment">
                <input type="hidden" name="action" value="proceedDownpayment">
                <input type="hidden" name="enrollment_id" value="<?php echo($_GET["id"]); ?>">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label>Downpayment</label>
                  <input oninput="computeDownpayment()" id="downpaymentTextbox" required name="downpayment" type="number" step="0.01" class="form-control" placeholder="Enter ...">
                </div>
                <div class="form-group">
                  <label>Official Receipt No.</label>
                  <input required name="or_number" type="text"  class="form-control" placeholder="Enter ...">
                </div>
                </div>
              </div>
              <hr>
              <h4 id="feeTotalModal" class="text-left"> ₱ 0.00</h4>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                  </form>
          </div>
        </div>
      </div>

  





            <div class="card card-primary card-outline">
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
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#payment_history" data-toggle="tab">Payment History</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#soa" data-toggle="tab">Statement of Account</a></li> -->
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="payment_history">
                  <div class="row">
                    <div class="col-4">
                    <a href="#" data-toggle="modal"
                    <?php if(floatval($outstanding_balance[0]["total_amount"]) == 0):
                      echo('style="margin-right:3px; pointer-events: none; opacity: 0.6;"');
                    endif;
                      ?>
                    data-target="#newPaymentModal" class="btn btn-info btn-block" style="margin-right:3px;">NEW PAYMENT</a>
                    </div>
                    
                    <div class="col-8">
                  
                          
                        
                          <form class="generic_form_trigger" data-url="enrollment">
                  <div class="row">
                  <input type="hidden" name="action" value="printSOA">
                <div class="col-6">
                  <div class="form-group">
                  <select name="enrollment_id" required id="enrollmentSelect" class="form-control select2 selectFilter">
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
                      <button type="submit" class="btn btn-info btn-block" >PRINT Statement of Account</button>
                    </div>
                    
                  </form>
                        
                        
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table id="ajaxDatatable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th></th>
                          <th>SY</th>
                          <th>Date Paid</th>
                          <th>OR Number</th>
                          <th>Paid</th>
                          <th>Remaining</th>
                          <!-- <th>Type</th> -->
                        </tr>
                      </thead>
                    </table>
                    </div>
                  </div>



                  <div class="tab-pane" id="soa">
                  <div class="row">
                    <div class="col-8">
                        <h4 id="feeTotal2" class="text-left"> ₱ 0.00</h4>
                    </div>
                    
                    <div class="col-4">
                      <div class="row">
                        <div class="col-12">
                        <select style="width: 100%;" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                          <?php foreach($enrollmentList as $eList): ?>
                            <option value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
                          <?php endforeach; ?>
                        </select>

                        </div>
                  
                      </div>
                    </div>
                  </div>
                  <table id="ajaxDatatable2" width="100%" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>School Year</th>
                    <th>Fee Title</th>
                    <th>Amount</th>
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


$('.select2').select2({
    });

  var enrollment_id = $('#enrollmentSelect').val();
 

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
                    'url':'studentAccounts',
                     'type': "POST",
                     "data": function (data){
                        data.action = "paymentHistoryListCashier";
                        data.enrollment_id = enrollment_id;
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'school_year', "orderable": false  },
                    
                    { data: 'date_paid', "orderable": false  },
                    { data: 'or_number', "orderable": false  },
                    
                    {
                        data: 'amount_due', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    {
                        data: 'running_balance', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    //{ data: 'type', "orderable": false  },

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
    $('#enrollmentIdHidden').val($('#enrollmentSelect').val());
    
    
    $('#feeTotal').html(formattedReceived);
    // $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#totalVal').val(received);





}
            });





            // var enrollment_id = $('#enrollmentSelect').val();
 










            // $('.selectFilter').on('change', function() {
            //   var student_id = $('#studentSelect').val() || "";
            //   datatable.ajax.url('enrollment?action=enrollmentList&student_id='+student_id).load();
            //   });


              $('.selectFilter').on('change', function() {
              var enrollment_id = $('#enrollmentSelect').val() || "";
              // alert(enrollment_id);
              datatable.ajax.url('studentAccounts?action=paymentHistoryList&enrollmentFilterID='+enrollment_id).load();
              });
            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }
        </script>

<script>


function computeDownpayment(){
  var total = $('#totalVal').val();
  var downpayment = $('#downpaymentTextbox').val();

  newTotal = total - downpayment;


  var installment = newTotal / 10;

    // Format the output
  var formattedReceived = '₱ ' + newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  var formattedInstallment = '₱ ' + installment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  // feeTotalModal

  $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');

}





$('#addonSelect').change(function() {
        var selectedOption = $(this).find('option:selected');
        var amount = selectedOption.data('amount');
        var $amountInput = $('#amountInput');
        // alert(amount);

        if (amount !== undefined && amount !== '') {
            // Set the amount input value and make it readonly
            $amountInput.val(amount).prop('readonly', true);
        } else {
            // Clear the amount input value and make it editable
            $amountInput.val('').prop('readonly', false);
        }
    });

    // Trigger change event to initialize state based on the default selected option
    $('#addonSelect').trigger('change');
</script>
  <?php require("layouts/footer.php") ?>