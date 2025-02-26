<script>
function getRegCodeByName(regionName, regionArray) {
            const region = regionArray.find(r => r.name === regionName);
            return region ? region.reg_code : null; // Return the reg_code or null if not found
        }

function getProvCodeByName(provinceName, provinceArray, reg_code) {

    const province = provinceArray.find(p => p.name === provinceName && p.reg_code === reg_code);
    // console.log(province.prov_code);
    return province ? province.prov_code : null; // Return the prov_code or null if not found
}


function getCityCodeByName(CityName, cityMunArray, prov_code) {

const citymun = cityMunArray.find(c => c.name === CityName && c.prov_code === prov_code);
// console.log(province.prov_code);
return citymun ? citymun.mun_code : null; // Return the prov_code or null if not found
}



function getRegionNameByCode(reg_code, theRegions) {
    const region = theRegions.find(r => r.reg_code === reg_code);
    return region ? region.name : null;
}

function getProvinceNameByCode(prov_code, theProvince) {
    const province = theProvince.find(r => r.prov_code === prov_code);
    return province ? province.name : null;
}

function getCityNameByCode(mun_code, theCity) {
    const city = theCity.find(r => r.mun_code === mun_code);
    return city ? city.name : null;
}


var app_pds_personal = new Vue({
    el: "#form_pds_elig",
    data: {
        readonly: true,
        student: {
          student_id: "",
          lastname: "",
          firstname: "",
          middlename: "",
          name_extension: "",
          region: "",
          province: "",
          city_mun: "",
          barangay: "",
          address: "",
          birthDate: "",
          birthPlace: "",
          sex: "",
          religion: "",
          father_firstname: "",
          father_middlename: "",
          father_lastname: "",
          father_firstname: "",
          father_occupation: "",
          father_education: "",
          mother_middlename: "",
          mother_middlename: "",
          mother_lastname: "",
          mother_occupation: "",
          mother_education: "",
          father_contact: "",
          father_fb: "",
          mother_contact: "",
          mother_fb: "",
          guardian_firstname: "",
          guardian_middlename: "",
          guardian_lastname: "",
          guardian_phone: "",
          guardian_occupation: "",
        },

        regions: [],
        provinces: [],
        cities: [],
        barangays: []
    },
    methods: {
        initLocationData() {
            // Get all regions
            console.log(Philippines);
            this.regions = Philippines.sort(Philippines.regions,"A");
            // this.provinces = Philippines.sort(Philippines.regions,"A");
        },
        updateProvinces() {
            const selectedRegion = this.student.Region;
            console.log(Philippines);
            this.provinces = Philippines.getProvincesByRegion(selectedRegion) || [];
            console.log(this.provinces);
            this.student.province = ""; // Reset province selection
            this.cities = []; // Reset city selection
            this.barangays = []; // Reset barangay selection
        },
        updateCities() {
            const selectedProvince = this.student.Province;
            this.cities = Philippines.getCityMunByProvince(selectedProvince) || [];
            this.student.city_mun = ""; // Reset city selection
            this.barangays = []; // Reset barangay selection
        },
        updateBarangays() {
            const selectedCity = this.student.City;
            this.barangays = Philippines.getBarangayByMun(selectedCity) || [];
            this.student.barangay = ""; // Reset barangay selection
        },
        getstudentData(){
            this.student.student_id = '<?php echo($_GET["id"]); ?>';
                $.ajax({
                    type: "post",
                    url: "student",
                    data: {student_id: this.student.student_id, action: "getData"
                    },
                    dataType: "json",
                    success: (response) => {
                        this.student = response[0];
                    console.log(this.student.student_id);
                    this.student.region = getRegCodeByName(response[0].region, Philippines.sort(Philippines.regions,"A")) || "";
                    if(this.student.region != null)
                      this.provinces = Philippines.getProvincesByRegion(this.student.region);
                    
                    this.student.province = getProvCodeByName(response[0].province, Philippines.getProvincesByRegion(this.student.region), this.student.region) || "";
                    
                    
                    this.cities = Philippines.getCityMunByProvince(this.student.province);
                    this.student.city_mun = getCityCodeByName(response[0].city_mun, Philippines.getCityMunByProvince(this.student.province), this.student.province) || "";

                    this.barangays = Philippines.getBarangayByMun(this.student.city_mun);



                    this.student.barangay = response[0].barangay || "";
                    },
                    async: false,
                });

        },
        goUpdate(){
            this.readonly = false
            $(".btn_pds_elig_update").hide();
            $(".btns_pds_elig_update").show();
        },
        goSave(){
          var codeRegion = this.student.region;
          var codeProvince = this.student.province;
          var codeCity = this.student.city_mun;
          var codeBrgy = this.student.barangay;

          this.student.region = getRegionNameByCode(codeRegion, Philippines.sort(Philippines.regions,"A")) || "";
          this.student.province = getProvinceNameByCode(codeProvince, Philippines.getProvincesByRegion(codeRegion)) || "";
          this.student.city_mun = getCityNameByCode(codeCity, Philippines.getCityMunByProvince(codeProvince)) || "";
          // console.log(this.student);
          // this.student.Province = getProvCodeByName(codeProvince, Philippines.getProvincesByRegion(codeRegion), codeRegion) || "";
          // this.student.City = getCityCodeByName(codeCity, Philippines.getCityMunByProvince(codeProvince), codeProvince) || "";
          // this.student.Brgy = Philippines.getBarangayByMun(this.student.City);

            toastr.options = {
                "progressBar": true,          // Enables the progress bar
                "positionClass": "toast-top-center",  // Position of the toast
                "timeOut": "3000",            // Duration in milliseconds (e.g., 5000ms = 5s)
                "extendedTimeOut": "500"      // Extra time after hover
            };
            $.post(
              "student",
              { action: "updateStudentInfo", student: this.student },
              (data) => {
                console.log(data);
                  toastr.success('Personal Information Saved');
                  this.getstudentData()
                this.readonly = true; // Set fields to readonly after saving
                $(".btn_pds_elig_update").show(); // Show update button
                $(".btns_pds_elig_update").hide(); // Hide save/cancel buttons
              },
              "json"
            );
          
        },
        goCancel(){
            this.getstudentData()
            this.readonly = true
            $(".btn_pds_elig_update").show();
            $(".btns_pds_elig_update").hide();
        }
    },
    mounted() {
        this.initLocationData();
        this.getstudentData();
        
        // $('.ui.checkbox').checkbox();
        $('#pds_gender').dropdown({
             onChange: (value, text, $choice)=>{
                this.student["gender"] = value;
             }
        });
        $('#pds_gender').dropdown('set selected',this.student.gender);
        $('#pds_civil_status').dropdown({
            onChange: (value, text, $choice)=>{
               this.student["civil_status"] = value;
            }
        });
        $('#pds_civil_status').dropdown('set selected',this.student.civil_status);
        $('#pds_blood_type').dropdown({
            onChange: (value, text, $choice)=>{
            this.student["blood_type"] = value;
            }
        });
        $('#pds_blood_type').dropdown('set selected',this.student.blood_type);


$('#personal_pds_form').validate({
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
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
      $(element).closest('.form-group').find('span.valid-feedback').remove();
      // $(element).closest('.form-group').append('<span class="valid-feedback">✓</span>'); // Adds a check mark
    }
  });
        
    },
 
})


























</script>