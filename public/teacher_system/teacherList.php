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
            <h1>Teachers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacher">Add Teacher</button>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="modal fade" id="addTeacher">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Add Teacher</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="generic_form_trigger" data-title="New Teacher" data-message="You are almost done! Are you sure you want to add the new teacher?”" data-url="teacher">
                <input type="hidden" name="action" value="teacherAdd">
                <input type="hidden" name="region" id="true_region" value="">
                  <input type="hidden" name="province" id="true_province" value="">
                  <input type="hidden" name="cityMun" id="true_city_mun" value="">
                  <input type="hidden" name="barangay" id="true_barangay" value="">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">First Name <span class="text-danger">*</span></label>
                        <input required value="" type="text" name="firstname" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Middle Name</label>
                        <input  type="text" value="" name="middlename" class="form-control" id="exampleInputEmail1" placeholder="Middle Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Last Name <span class="text-danger">*</span></label>
                        <input required type="text" value="" name="lastname" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name Extension</label>
                        <input  type="text" value="" name="nameExtension" class="form-control" id="exampleInputEmail1" placeholder="Ex. I, II, III, Jr. Sr.">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Region <span class="text-danger">*</span></label>
                              <select required class="form-control select2" id="region_select">
                                  <option  value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Province <span class="text-danger">*</span></label>
                              <select required class="form-control select2" id="province_select">
                                  <option  value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">City | Municipality <span class="text-danger">*</span></label>
                              <select required class="form-control select2" id="city_mun_select">
                                  <option  value=""></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Barangay <span class="text-danger">*</span></label>
                              <select required class="form-control select2" id="barangay_select">
                                  <option  value=""></option>
                              </select>
                            </div>
                          </div>
                      </div>
                  
                      <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Street / House Number / Purok <span class="text-danger">*</span></label>
                              <input value="" name="address" required type="text" class="form-control"  placeholder="Street / House Number / Purok">
                            </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Birthdate <span class="text-danger">*</span></label>
                              <input  max="<?php echo date('Y-m-d'); ?>" value="" name="birthDate" required type="date" class="form-control"  placeholder="Birthdate">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Sex <span class="text-danger">*</span></label>
                              <select required name="gender" class="form-control select2" >
                                <option disabled selected value="">Please select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Contact Number <span class="text-danger">*</span></label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input name="contactNumber" required type="text" class="form-control" data-inputmask='"mask": "(+63) 9999999999"' data-mask>
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Email Address (this will serve as username on the system) <span class="text-danger">*</span></label>
                              <input value="" name="email" required type="email" class="form-control"  placeholder="---">
                            </div>
                          </div>


                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Undergraduate Course <span class="text-danger">*</span></label>
                              <input value="" name="undergrad_course" required type="text" class="form-control"  placeholder="Ex. BS in Eduation">
                            </div>
                          </div>


                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Postgraduate Course</label>
                              <input value="" name="postgraduate_course" type="text" class="form-control"  placeholder="Ex. Masters in Education">
                            </div>
                          </div>

                          




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
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header bg-success">

              <h3 class="card-title">Total Teachers : <b><?php $all_teacher = query("select count(teacher_id) as total from teacher"); echo($all_teacher[0]["total"]); ?></b></h3>
                <!-- <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter School Year</option>
                          <option value="">2023-2024</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter Grade Level</option>
                          <option value="">Grade 1</option>
                          <option value="">Grade 2</option>
                          <option value="">Grade 3</option>
                          <option value="">Grade 4</option>
                          <option value="">Grade 5</option>
                          <option value="">Grade 6</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter Section</option>
                          <option value="">Section Apple</option>
                          <option value="">Section Orange</option>
                          <option value="">Section Grapes</option>
                         
                        </select>
                      </div>
                    </div>
                </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table id="ajaxDatatable" class="table table-bordered table-striped" style="width: 100%;">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Teacher Name</th>
                    <th width="10%">Action</th>
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
                // "searching": false,
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
                    'url':'teacher',
                     'type': "POST",
                     "data": function (data){
                        data.action = "teacherList";
                     }
                },
                'columns': [
                    { data: 'teacher_id', "orderable": false  },
                    { data: 'teacher_name', "orderable": false  },
                    { data: 'action', "orderable": false },

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
  $('[data-mask]').inputmask()
    $('#region_select').select2({
      placeholder: 'Please select Region'
    });
    $('#province_select').select2({
      placeholder: 'Please select Province'
    });

    $('#city_mun_select').select2({
      placeholder: 'Please select City / Municipality'
    });

    $('#barangay_select').select2({
      placeholder: 'Please select Barangay'
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