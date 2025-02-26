<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
            <h1>Enrollment Module</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

          <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Enrollment Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal generic_form_trigger" data-url="enrollment" id="EnrollmentForm">
                <input type="hidden" name="action" value="newEnrollment">
                  <input type="hidden" name="region" id="true_region" value="">
                  <input type="hidden" name="province" id="true_province" value="">
                  <input type="hidden" name="cityMun" id="true_city_mun" value="">
                  <input type="hidden" name="barangay" id="true_barangay" value="">


                <div class="card-body">
            
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Student's Name</span></label>
                        <div class="col-sm-3">
                          <input required placeholder="First Name" name="firstname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-3">
                          <input  placeholder="Middle Name" name="middlename" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-3">
                          <input required placeholder="Last Name" name="lastname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-1">
                          <input placeholder="Jr, I, II" name="nameExtension" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>
                    </div>
              

                    <div class="col-md-12">
                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Address</span></label>
                        <div class="col-sm-3">
                        <select required class="form-control select2" id="region_select">
                                  <option  value=""></option>
                              </select>
                        </div>
                        <div class="col-sm-3">
                          <select required class="form-control select2" id="province_select">
                                  <option  value=""></option>
                              </select>
                        </div>
                        <div class="col-sm-4">
                              <select required class="form-control select2" id="city_mun_select">
                                  <option  value=""></option>
                              </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;"></span></label>
                        <div class="col-sm-3">
                        <select required class="form-control select2" id="barangay_select">
                                  <option  value=""></option>
                              </select>
                        </div>
                        <div class="col-sm-7">
                        <input required placeholder="House Number and Street" name="address_home" type="text" class="form-control" id="inputEmail3" >
                        </div>
                       
                      </div>
                    </div>

                    <div class="col-md-6">


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><span style="text-align:right !important;">Birth Date</span></label>
                        <div class="col-sm-8">
                          <input placeholder="Enter Birthdate" required name="birthdate" type="date" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                      



                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-4 col-form-label"><span style="text-align:right !important;">Sex</span></label>
                        <div class="col-sm-8">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Please select sex</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                        </div>
                      </div>
  

                      <?php 
                      // dump(get_defined_vars());
                      
                      $section = query("SELECT a.*, s.*, a.grade_level AS grade_level,
       CASE 
           WHEN e.student_count IS NULL OR e.student_count < a.max_students THEN 'Active' 
           ELSE 'Inactive' 
       END AS advisory_status
FROM advisory a
LEFT JOIN section s ON s.section_id = a.section_id
LEFT JOIN (
    SELECT advisory_id, COUNT(*) AS student_count
    FROM enrollment
    GROUP BY advisory_id
) e ON e.advisory_id = a.advisory_id
WHERE a.school_year = ?
ORDER BY a.grade_level ASC", $sy["syid"]); 
                      // dump($section);
                                              
                                              ?>


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-4 col-form-label"><span style="text-align:right !important;">Grade Level</span></label>
                        <div class="col-sm-8">
                        <select required name="section" class="form-control select2">
                          <option selected disabled value="">Please select Section</option>
                          <?php foreach($section as $row): ?>
                            <?php if($row["advisory_status"] == "Active"): ?>
                            <option class="text-success" value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?></option>
                            <?php else: ?>
                              <option class="text-danger" disabled value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?> (Full)</option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                  
                        </select>
                        </div>
                      </div>
                   
                      
                    </div>

                    <div class="col-md-6">
                     
                      <div class="form-group row">
                        <label for="inputEmail3"  class="col-sm-4 col-form-label"><span style="text-align:right !important;">Birth Place</span></label>
                        <div class="col-sm-8">
                          <input placeholder="Enter Birthplace" required name="birthplace" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>
                    
                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-4 col-form-label"><span style="text-align:right !important;">Religion</span></label>
                        <div class="col-sm-8">
                          <input placeholder="Enter Religion" required name="religion" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>
                      
                    </div>

                 
                  </div>
                  <hr>

                  <div class="form-group row">
                    <label for="relationshipSelector" class="col-sm-2 col-form-label">
                      Select Relationship
                    </label>
                    <div class="col-sm-10">
                      <select id="relationshipSelector" class="form-control">
                        <option value="parent">Parent</option>
                        <option value="guardian">Guardian</option>
                      </select>
                    </div>
                  </div>

                  <hr>
                  <div id="parentSection">
                    <div class="form-group row">
                        <label for="inputEmail3"  class="col-sm-2 col-form-label"><span style="text-align:right !important;">Father's Name</span></label>
                        <div class="col-sm-3">
                          <input  placeholder="First Name" name="father_firstname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-3">
                          <input  placeholder="Middle Name" name="father_middlename" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-4">
                          <input  placeholder="Last Name" name="father_lastname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Father's Occupation</span></label>
                        <div class="col-sm-10">
                          <input  placeholder="---" name="father_occupation" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                    


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Educational Attainment</span></label>
                        <div class="col-sm-10">
                          <input  placeholder="---" name="father_education" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Contact Info</span></label>
                        <div class="col-sm-5">
                          <input placeholder="Enter Contact Info (Mobile)"  data-inputmask='"mask": "(+63) 9999999999"' data-mask name="father_contact" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-5">
                          <input placeholder="Enter Facebook Account" name="father_fb" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                      <hr>

                    <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Mother's Maiden Name</span></label>
                        <div class="col-sm-3">
                          <input  placeholder="First Name" name="mother_firstname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-3">
                          <input  placeholder="Middle Name" name="mother_middlename" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-4">
                          <input  placeholder="Last Name" name="mother_lastname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Mother's Occupation</span></label>
                        <div class="col-sm-10">
                          <input  placeholder="---" name="mother_occupation" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                    


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Educational Attainment</span></label>
                        <div class="col-sm-10">
                          <input  placeholder="---" name="mother_education" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Contact Info</span></label>
                        <div class="col-sm-5">
                          <input  data-inputmask='"mask": "(+63) 9999999999"' data-mask placeholder="Enter Contact Info (Mobile)" name="mother_contact" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-5">
                          <input placeholder="Enter Facebook Account" name="mother_fb" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>
                    </div>
                      <hr>


                  <div id="guardianSection" style="display: none;">
                    <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Guardian's Name</span></label>
                        <div class="col-sm-3">
                          <input placeholder="First Name" name="guardian_firstname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-3">
                          <input  placeholder="Middle Name" name="guardian_middlename" type="text" class="form-control" id="inputEmail3" >
                        </div>
                        <div class="col-sm-4">
                          <input  placeholder="Last Name" name="guardian_lastname" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>



                    


                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Contact Info</span></label>
                        <div class="col-sm-10">
                          <input  data-inputmask='"mask": "(+63) 9999999999"' data-mask placeholder="Enter Contact Info (Mobile)" name="guardian_contact" type="text" class="form-control" id="inputEmail3" >
                        </div>
                   
                      </div>

                      <div class="form-group row">
                        <label for="inputEmail3" value="EF2023-908201XN" class="col-sm-2 col-form-label"><span style="text-align:right !important;">Guardian's Occupation</span></label>
                        <div class="col-sm-10">
                          <input placeholder="---" name="guardian_occupation" type="text" class="form-control" id="inputEmail3" >
                        </div>
                      </div>
                  <hr>

            

              
                </div>

                <h2 class="mb-3 mt-5">REQUIREMENTS</h2>



                <div class="row">
                    <div class="col">
                    <div class="form-group clearfix">
                    <label for="radioPrimary3">
                          Birth Certificate
                        </label>
                        <br>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="yes" id="birthRadio1" name="birthCertificate">
                        <label for="birthRadio1">
                          Provided
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="no" id="birthRadio2" name="birthCertificate">
                        <label for="birthRadio2">
                          Not Provided
                        </label>
                      </div>
                      <!-- <div class="icheck-primary d-inline">
                        <input required type="radio" value="na" id="birthRadio3" name="birthCertificate">
                        <label for="birthRadio3">
                          Not Applicable
                        </label>
                      </div> -->
                    </div>
                    </div>



                    <div class="col">
                    <div class="form-group clearfix">
                    <label for="radioPrimary3">
                          Good Moral
                        </label>
                        <br>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="yes" id="goodmoralRadio1" name="goodMoral">
                        <label for="goodmoralRadio1">
                        Provided
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="no" id="goodmoralRadio2" name="goodMoral">
                        <label for="goodmoralRadio2">
                        Not Provided
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="na" id="goodmoralRadio3" name="goodMoral">
                        <label for="goodmoralRadio3">
                          Not Applicable
                        </label>
                      </div>
                    </div>
                    </div>



                    <div class="col">
                    <div class="form-group clearfix">
                    <label for="radioPrimary3">
                          Form 137
                        </label>
                        <br>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="yes" id="form137Radio1" name="form137">
                        <label for="form137Radio1">
                        Provided
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="no" id="form137Radio2" name="form137">
                        <label for="form137Radio2">
                          Not Provided
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input required type="radio" value="na" id="form137Radio3" name="form137">
                        <label for="form137Radio3">
                          Not Applicable
                        </label>
                      </div>
                    </div>
                    </div>
                          </div>
              

                


           
                  </div>
                  <div class="card-footer">
                  <button type="submit" class="btn btn-info">Enroll Student</button>
                  <a href="enrollment" class="btn btn-default">Back</a>
                </div>
                </div>
                <!-- /.card-body -->
                
                <!-- /.card-footer -->
              </form>
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
  <script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript" src="node_modules/philippine-location-json-for-geer/build/phil.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>

<script src="AdminLTE_new/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-validation/additional-methods.min.js"></script>

<script>
  $(document).ready(function() {
    $('#relationshipSelector').change(function() {
      const parentSection = $('#parentSection');
      const guardianSection = $('#guardianSection');
      
      if ($(this).val() === 'parent') {
        parentSection.show();
        guardianSection.hide();

        // Toggle required fields for Parent
        // parentSection.find('input').prop('required', true);
        // guardianSection.find('input').prop('required', false);
      } else {
        parentSection.hide();
        guardianSection.show();

        // Toggle required fields for Guardian
        // parentSection.find('input').prop('required', false);
        // guardianSection.find('input').prop('required', true);
      }
    });
    
    // Trigger the change event on page load to show the initial state
    $('#relationshipSelector').trigger('change');
  });
</script>

  <script>
  $('[data-mask]').inputmask()


            // Function to initialize AutoNumeric on new amount fields
            function initializeAutoNumeric(element) {
                autoNumericElements.push(new AutoNumeric(element, {
                    currencySymbol: '₱',
                    digitGroupSeparator: ',',
                    decimalCharacter: '.',
                    decimalPlaces: 2,
                    minimumValue: '0'
                }));
            }

            

            // Add-on button click handler
            $('#add-on-btn').click(function() {
                const clone = $('.addon-row:first').clone();
                clone.find('input').val(''); // Clear the cloned inputs
                clone.find('.numberic').removeAttr('id').removeData('autonumeric'); // Remove old AutoNumeric instance
                $('#addon-container').append(clone);
                initializeAutoNumeric(clone.find('.numberic')); // Initialize AutoNumeric on the new amount field
            });

            // Remove button click handler
            $(document).on('click', '.remove-btn', function() {
                if ($('.addon-row').length > 1) {
                    $(this).closest('.addon-row').remove();
                } else {
                    // Reset the first row
                    $(this).closest('.addon-row').find('input').val('');
                }
                computeCosting();
            });
   



    // var sum = 0;
    function convertCurrencyToDouble(value) {
            return parseFloat(value.replace(/[^0-9.-]+/g,""));
        }

        function computeCosting(){
          var total = 0;
            var sum = 0;

            $("input[class*='costing']").each(function(){
                if($(this).attr("id") != "downpayment"){
                    if($(this).val() != ""){
                        sum += convertCurrencyToDouble($(this).val());
                        total += convertCurrencyToDouble($(this).val());
                        console.log(convertCurrencyToDouble($(this).val()));
                    }
                } else {
                    if($(this).val() != ""){
                        sum -= convertCurrencyToDouble($(this).val());
                    }
                }
            });

            $("#total").val(total.toFixed(2));
            $("#balance").val(sum.toFixed(2));
        }

        $(document).on("keyup", ".numberic", function() {
          computeCosting();
        });





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




            $('.numberic').each(function() {
                new AutoNumeric(this, {
                    currencySymbol: '₱',              // Set currency symbol to '₱'
                    digitGroupSeparator: ',',         // Use comma as the thousand separator
                    decimalCharacter: '.',            // Use dot as the decimal separator
                    decimalPlaces: 2,                 // Set number of decimal places to 2
                    minimumValue: '0'                 // Set minimum value to '0'
                });
            });

$(function () {
  $('#EnrollmentForm').validate({
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-control').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid').addClass('is-valid');
    },
    success: function (label, element) {
      $(element).addClass('is-valid'); // Adds green border when valid
      // Add a green check icon or any valid styling you want to apply
      $(element).closest('.form-control').find('span.valid-feedback').remove();
      // $(element).closest('.form-group').append('<span class="valid-feedback">✓</span>'); // Adds a check mark
    }
  });
});



        </script>
  <?php require("layouts/footer.php") ?>