<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
     
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <!-- Profile Image -->
         
              <!-- /.card-header -->
                  <table class="table" id="sectionTable">
                    <tr>
                      <th>Student Name:</th>
                      <td>ILLEST J. MORENA</td>
                      <th>Adviser:</th>
                      <td>Victor Magtanggol</td>
                    </tr>
                    <tr>
                      <th>Grade Level:</th>
                      <td>Grade 2</td>
                      <th>School Year:</th>
                      <td>2023-2024</td>
                    </tr>
                    <tr>
                      <th>Section:</th>
                      <td>Section Apple</td>
                    </tr>
                  </table>

                  <hr>
                  <br>
              <!-- /.card-body -->
        
            <!-- /.card -->

            <!-- About Me Box -->
           
     
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Students</a></li> -->
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Subjects / Grades</a></li>
                  <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Record History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#soa" data-toggle="tab">Statement of Account</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Final Grade</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                
                      <td>SUB2010-501</td>
                      <td>Math 1</td>
                      <td>Introduction to Algebra</td>
                      <td>Mr. Victor T. Magtanggol</td>
                      <td>07:30 - 08:30 AM</td>
                      <td>95</td>
                      <td>93</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>SUB2010-502</td>
                      <td>Eng 1</td>
                      <td>Introduction to English</td>
                      <td>Ms. Cynthia Soliman</td>
                      <td>08:30 - 09:30 AM</td>
                      <td>91</td>
                      <td>92</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                    <tr>
                  
                      <td>SUB2010-503</td>
                      <td>FIL 1</td>
                      <td>Filipino to the Moon</td>
                      <td>Ms. Brenda Mage</td>
                      <td>09:30 - 10:30 AM</td>
                      <td>94</td>
                      <td>91</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                   
                  
                
                   
                 
                  </tbody>
              
                </table>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="history">
                    <!-- The timeline -->
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Level</th>
                    <th>SY</th>
                    <th>Final Grade</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>SUB2010-101</td>
                      <td>Eng101</td>
                      <td>Grammars</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>99</td>
                    </tr>
                    <tr>
                      <td>SUB2010-102</td>
                      <td>CIV01</td>
                      <td>History of the Philippines</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>94</td>
                    </tr>
                    <tr>
                      <td>SUB2010-103</td>
                      <td>PE1</td>
                      <td>Chess</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>99</td>
                    </tr>
               

           
                  
                
                   
                 
                  </tbody>
              
                </table>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="soa">

                  <div class="row">
                    <div class="col-md-3">
                    <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter School Year</option>
                          <option value="">2023-2024</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                    
                    </div>
                    <div class="col-md-3">
                    <div class="form-group">
                        <a href="#" data-toggle="modal" data-target="modalPayment" class="btn btn-info btn-block">Add Payment</a>
                      </div>
                    </div>
                  </div>
                    
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Reg.Fee</th>
                    <th>Elec. Subsidy</th>
                    <th>ID/Insu.</th>
                    <th>Books</th>
                    <th>Misc</th>
                    <th>OR #</th>
                    <th>Amount</th>
                    <th>Balance</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>06/01/2023</td>
                      <td class="text-right">1,000.00</td>
                      <td class="text-right">6,000.00</td>
                      <td class="text-right">2,800.00</td>
                      <td class="text-right">250.00</td>
                      <td class="text-right">1,360.00</td>
                      <td></td>
                      <td></td>
                      <td class="text-right">15,910.00</td>
                    </tr>
                    <tr>
                      <td>06/01/2023</td>
                      <td class="text-right"></td>
                      <td class="text-right">6,000.00</td>
                      <td class="text-right">2,800.00</td>
                      <td class="text-right"></td>
                      <td class="text-right">460.00</td>
                      <td>#01011</td>
                      <td class="text-right">2,150.00</td>
                      <td class="text-right">13,760.00</td>
                    </tr>
                  
               

           
                  
                
                   
                 
                  </tbody>
              
                </table>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
    </section>
    <!-- /.content -->
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

$('.exampleDatatable').DataTable({
  ordering: false
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