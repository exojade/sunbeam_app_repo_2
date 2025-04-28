<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

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
$enrollment = query("select e.*, s.section from 
                        enrollment e left join advisory a
                        on a.advisory_id = e.advisory_id
                        left join section s
                        on s.section_id = a.section_id
                      where e.enrollment_id = ?", $_GET["id"]);
$enrollment = $enrollment[0];

$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
$student = $student[0];
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
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Enrollment still pending
                </div>
        <?php endif; ?>
            <!-- Profile Image -->

      <div class="modal fade" id="modalAddOns">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">ADD ONS</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

            <?php $addons = query("select * from fees where fee_type = 'OTHERS'"); ?>
              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="enrollment">
                <input type="hidden" name="action" value="addOn">
                <input type="hidden" name="enrollment_id" value="<?php echo($_GET["id"]); ?>">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label>Add Ons</label>
                  <select name="addOns" class="form-control select2" id="addonSelect" style="width: 100%;" >
                  <option selected disabled value="" data-amount="">Please Select Add Ons</option>
                    <?php foreach($addons as $row): ?>
                      <option value="<?php echo($row["fees_id"]); ?>" data-amount="<?php echo($row["fee_amount"] ?? ''); ?>"><?php echo($row["fee_title"]); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Amount</label>
                  <input required name="amount" type="number" step="0.01" id="amountInput" class="form-control" placeholder="Enter ...">
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

              <?php
$priorityFees = query("select sum(fee_amount) as total from fees where grade_level = ? and priority = 'YES' and status = 'ACTIVE'", $enrollment["grade_level"]);
          $priorityFees = $priorityFees[0]["total"];            
              ?>


              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="enrollment">
                <input type="hidden" name="action" value="proceedDownpayment">
                <input type="hidden" name="enrollment_id" value="<?php echo($_GET["id"]); ?>">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label>Downpayment</label>
                  <input oninput="computeDownpayment()" min="<?php echo($priorityFees); ?>" id="downpaymentTextbox" required name="downpayment" type="number" step="0.01" class="form-control" placeholder="Minimum Downpayment : <?php echo(number_format($priorityFees)); ?>">
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Enrollment Fees</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li> -->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">

                  <div class="row">
                    <div class="col-8">
                        <h4 id="feeTotal" class="text-left"> ₱ 0.00</h4>
                    </div>
                    <div class="col-4">
                        <a href="#" data-toggle="modal" data-target="#modalEnrollStudent" class="btn btn-info btn-sm float-right" >PROCEED DOWNPAYMENT</a>
                        <a href="#" data-toggle="modal" data-target="#modalAddOns" class="btn btn-primary btn-sm float-right" style="margin-right:3px;">ADD - ONS</a>
                    </div>
                  </div>

                  
                  <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fee Title</th>
                    <th>Type</th>
                    <th>Priority</th>
                    <th>Amount</th>
                    <th>Action</th>
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
                    'url':'enrollment',
                     'type': "POST",
                     "data": function (data){
                        data.action = "enrollmentCashierFee";
                        data.enrollment_id = "<?php echo($_GET["id"]); ?>";
                     }
                },
                'columns': [
                    { data: 'fee', "orderable": false  },
                    { data: 'fee_type', "orderable": false  },
                    { data: 'priority', "orderable": false  },
                    {
                        data: 'fee_amount', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    { data: 'action', "orderable": false  },


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
        .column(3)
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

            $('.selectFilter').on('change', function() {
              var student_id = $('#studentSelect').val() || "";
              datatable.ajax.url('enrollment?action=enrollmentList&student_id='+student_id).load();
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