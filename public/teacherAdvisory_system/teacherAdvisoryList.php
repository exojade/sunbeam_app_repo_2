<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>My Advisory Class</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacher">Add Advisory</button> -->
            </ol>
          </div>
        
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="modal fade" id="addTeacher">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Teacher</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="generic_form_trigger" data-url="advisory">
                <input type="hidden" name="action" value="advisoryAdd">

               
                 
                      <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Current School Year</label>
                              <input value=" <?php echo($sy["school_year"]); ?>" disabled type="text" class="form-control"  placeholder="Street / House Number / Purok">
                            </div>
                          </div>
                      </div>

                      <div class="form-group">
                        <label>Grade Level</label>
                        <select required name="grade_level" class="form-control select2" >
                          <option disabled selected value="">Please select Grade Level</option>
                          <option value="Kindergarten 1">Kindergarten 1</option>
                          <option value="Kindergarten 2">Kindergarten 2</option>
                          <option value="Grade 1">Grade 1</option>
                          <option value="Grade 2">Grade 2</option>
                          <option value="Grade 3">Grade 3</option>
                          <option value="Grade 4">Grade 4</option>
                          <option value="Grade 5">Grade 5</option>
                          <option value="Grade 6">Grade 6</option>
                        </select>
                      </div>


                      <div class="form-group">
                        <?php $section = query("select * from section"); ?>
                        <label>Section</label>
                        <select required name="section" class="form-control select2" >
                          <option disabled selected value="">Please select Section</option>
                          <?php foreach($section as $row): ?>
                            <option value="<?php echo($row["section_id"]); ?>"><?php echo($row["section"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>


                      <div class="form-group">
                      <?php $teacher = query("select * from teacher"); ?>
                        <label>Teacher</label>
                        <select required name="teacher" class="form-control select2" >
                          <option disabled selected value="">Please select Teacher</option>
                          <?php foreach($teacher as $row): ?>
                            <option value="<?php echo($row["teacher_id"]); ?>"><?php echo($row["teacher_firstname"] . " " . $row["teacher_lastname"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                   
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
      
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    
      <div class="container-fluid">


      <?php $advisory = query("select * from advisory where teacher_id = ?", $_SESSION["sunbeam_app"]["userid"]); ?>
      <?php if(!empty($advisory)): ?>
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="30%">Action</th>
                    <th>Section</th>
                    <th>Grade Level</th>
                    <th>Students</th>
                    <th>School Year</th>
                  </tr>
                  </thead>
                  <tfoot>
                </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      <?php else: ?>

        <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> No Advisory Class</h3>

 

   
        </div>
        <!-- /.error-content -->
      </div>

      <?php endif; ?>


       
      </div>
    </section>
    <!-- /.content -->
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
<script src="AdminLTE_new/plugins/inputmask/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="node_modules/philippine-location-json-for-geer/build/phil.min.js"></script>
  <script>


var datatable = 
            $('#ajaxDatatable').DataTable({
                "searching": false,
                "pageLength": 10,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": true,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'teacherAdvisory',
                     'type': "POST",
                     "data": function (data){
                        data.action = "teacherAdvisoryList";
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false },
                    { data: 'section', "orderable": false  },
                    { data: 'grade_level', "orderable": false  },
                    { data: 'student_population', "orderable": false  },
                    { data: 'school_year', "orderable": false  },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    // var api = this.api(), data;
                    

                    // Remove the formatting to get integer data for summation
                    // var intVal = function (i) {
                    //     return typeof i === 'string' ?
                    //         i.replace(/[\$,]/g, '') * 1 :
                    //         typeof i === 'number' ?
                    //             i : 0;
                    // };

                    // // Total over all pages
                    // received = api
                    //     .column(5)
                    //     .data()
                    //     .reduce(function (a, b) {
                    //         return intVal(a) + intVal(b);
                    //     }, 0);
                    //     console.log(received);

                    // $('#currentTotal').html('$ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }
            });






        </script>

<script>


    $('.select2').select2({
    });
    


    
    var selectedRegion = '';
    var selectedCity = '';
  
    var all_region = Philippines.sort(Philippines.regions,"A");
      html = "<option value='' disabled selected></option>";
    for(var key in all_region) {
      // console.log(all_province[key].name);
        html += "<option value=" + all_region[key].reg_code  + ">" +all_region[key].name + "</option>"
    }
    document.getElementById("region_select").innerHTML = html;





  $('#region_select').change(function(){
    $('#true_region').val($( "#region_select option:selected" ).text());
    province = Philippines.getProvincesByRegion($(this).val(), 'A');
    selectedRegion = $(this).val();
 
    html = "<option value='' disabled selected></option>";
    for(var key in province) {
      // console.log(city_mun[key].name);
        html += "<option value=" + province[key].prov_code  + ">" +province[key].name + "</option>"
    }
    document.getElementById("province_select").innerHTML = html;
});




$('#province_select').change(function(){
    $('#true_province').val($( "#province_select option:selected" ).text());
    city_mun = Philippines.getCityMunByProvince($(this).val(), 'A');
    html = "<option value='' disabled selected></option>";
    for(var key in city_mun) {
      // console.log(city_mun[key].name);
        html += "<option value=" + city_mun[key].mun_code  + ">" +city_mun[key].name + "</option>"
    }
    document.getElementById("city_mun_select").innerHTML = html;
});


$('#city_mun_select').change(function(){
    $('#true_city_mun').val($( "#city_mun_select option:selected" ).text());
    barangay = Philippines.getBarangayByMun($(this).val(), 'A');
    html = "<option value='' disabled selected></option>";
    for(var key in barangay) {
      // console.log(city_mun[key].name);
        html += "<option value=" + barangay[key].mun_code  + ">" +barangay[key].name + "</option>"
    }
    document.getElementById("barangay_select").innerHTML = html;
  

    // console.log(Philippines.getZipCode(selectedRegion, selectedProvince));
});

$('#barangay_select').change(function(){
    $('#true_barangay').val($( "#barangay_select option:selected" ).text());

});


            $('.sampleDatatable').DataTable({
            });

</script> 


  <?php require("layouts/footer.php") ?>