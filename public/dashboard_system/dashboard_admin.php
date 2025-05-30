
<!-- <link rel="stylesheet" href="AdminLTE/bower_components/jvectormap/jquery-jvectormap.css"> -->
<!-- <link rel="stylesheet" href="AdminLTE_new/plugins/jqvmap/jqvmap.min.css"> -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
     
        </div>
      </div>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <section class="content-header">
      <!-- <div class="container-fluid"> -->
        <div class="row">
        <div class="col">
            <h1>Dashboard</h1>
          </div>
        </div>
      <!-- </div>/.container-fluid -->
    </section>
    <?php
$percentage = query("
SELECT 
    teacher_id,
    teacher,
    AVG(grading_percentage) AS average_grading_percentage,
    SUM(total_students) AS total_students,
    SUM(graded_students) AS graded_students
FROM (
SELECT 
    t.teacher_id,
    concat(teacher_lastname, ', ', teacher_firstname ) as teacher,
    sg.subject_id,
    COUNT(DISTINCT sg.student_id) AS total_students,
    COUNT(DISTINCT CASE 
        WHEN 
            (s.grading_period = 'first_grading' AND s.active_status = 'active' AND (IFNULL(sg.first_grading, '') != '')) OR
            (s.grading_period = 'second_grading' AND s.active_status = 'active' AND (IFNULL(sg.second_grading, '') != '')) OR
            (s.grading_period = 'third_grading' AND s.active_status = 'active' AND (IFNULL(sg.third_grading, '') != '')) OR
            (s.grading_period = 'fourth_grading' AND s.active_status = 'active' AND (IFNULL(sg.fourth_grading, '') != ''))
        THEN sg.student_id 
    END) AS graded_students,
    ROUND(
        (COUNT(DISTINCT CASE 
            WHEN 
                (s.grading_period = 'first_grading' AND s.active_status = 'active' AND (IFNULL(sg.first_grading, '') != '')) OR
                (s.grading_period = 'second_grading' AND s.active_status = 'active' AND (IFNULL(sg.second_grading, '') != '')) OR
                (s.grading_period = 'third_grading' AND s.active_status = 'active' AND (IFNULL(sg.third_grading, '') != '')) OR
                (s.grading_period = 'fourth_grading' AND s.active_status = 'active' AND (IFNULL(sg.fourth_grading, '') != ''))
            THEN sg.student_id 
        END) / COUNT(DISTINCT sg.student_id)) * 100, 2
    ) AS grading_percentage
FROM 
    settings s
JOIN 
    student_grades sg

JOIN 
    schedule sch
    ON sg.schedule_id = sch.schedule_id
JOIN 
    teacher t
    ON sch.teacher_id = t.teacher_id
WHERE
    s.active_status = 'active'
    AND sch.syid = ?
GROUP BY 
    t.teacher_id, sg.subject_id
    )
    as table2
    group by teacher_id
", $sy["syid"]);
// dump($percentage);


    ?>

<?php $alltime_payment = query("select sum(amount_paid) as total from payment where or_number is not null and syid = ?", $sy["syid"]); ?>
<?php $today_payment = query("SELECT IFNULL(SUM(amount_paid), 0) AS total 
                        FROM payment 
                        WHERE or_number IS NOT NULL 
                        AND DATE(date_paid) = CURDATE()");?>
<?php $all_students = query("select count(student_id) as total from student"); ?>
<?php $all_teacher = query("select count(teacher_id) as total from teacher"); ?>
<?php $all_parents = query("select count(id) as total from users where role = 'parent'"); ?>
<?php $all_sections = query("select count(section_id) as total from section"); ?>
<?php $all_subjects = query("select count(subject_id) as total from subjects"); ?>

<?php $payment_settings = query("select * from payment_settings"); 
$installment = "";
for ($i = 2; $i <= 11; $i++) {
  // Define suffix based on the installment number
  $suffix = match($i) {
     1 => 'st',
      2 => 'nd',
      3 => 'rd',
      default => 'th'
  };
  if($payment_settings[0]["installment_number"] == $i):
    $installment = $i.$suffix;
  endif;
  // Display each option with numeric value and text
}

?>


<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo(to_peso($alltime_payment[0]["total"])); ?></h3>
                <p>Received Payment this School Year</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="payment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo(to_peso($today_payment[0]["total"])); ?><sup style="font-size: 20px"></sup></h3>

                <p>Today Received Payment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="payment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo($all_students[0]["total"]); ?></h3>

                <p>Total Student</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="student" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo($all_teacher[0]["total"]); ?></h3>
                <p>Total Teachers</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="teacher" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?php echo($all_parents[0]["total"]); ?></h3>
                <p>Total Parent</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="parents" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo($installment); ?></h3>

                <p>Active Exam Installment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">---</a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo($all_sections[0]["total"]); ?></h3>

                <p>Total Class</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="section" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo($all_subjects[0]["total"]); ?></h3>

                <p>Total Subjects</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="subjects" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
      
        </div>


        <div class="row">
          <div class="col-6">

          <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Teacher Grade Tracker</h3>
              </div>
              <div class="card-body">

              <table class="table table-bordered">
                <thead>
                  <th>Teacher</th>
                  <th>Total Students</th>
                  <th>With Grades</th>
                  <th>Progress</th>
                </thead>

                <tbody>
                  <?php foreach($percentage as $row): ?>
                      <tr>
                        <td><?php echo($row["teacher"]); ?></td>
                        <td><?php echo($row["total_students"]); ?></td>
                        <td><?php echo($row["graded_students"]); ?></td>
                        <td>
                        <div class="progress">
                          <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                              aria-valuenow="<?php echo(round($row["average_grading_percentage"],2)); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo(round($row["average_grading_percentage"],2)); ?>%">
                          <?php echo(round($row["average_grading_percentage"],2)); ?>% Complete</span>
                          </div>
                        </div>
                        <code><?php echo(round($row["average_grading_percentage"],2)); ?>%</code>
                        </td>
                      </tr>
                  <?php endforeach; ?>
                </tbody>

              </table>
              </div>
            </div>
           
          </div>

          <div class="col-6">

          <div class="card card-danger" >
              <div class="card-header">
                <h3 class="card-title">Document Tracker</h3>
              </div>
              <?php
                $lacking = query("
                SELECT 
                    concat(s.lastname, ', ', s.firstname) as student_name,
                    GROUP_CONCAT(document_name SEPARATOR ', ') AS documents_tagged_no,
                    er.student_id
                FROM 
                    enrollment_requirements er
                left join enrollment e
                on e.enrollment_id = er.enrollment_id
                left join student s on e.student_id = s.student_id
                WHERE 
                    er.status = 'NO'
                GROUP BY 
                    er.enrollment_id");
                    // dump($lacking);
              ?>
              <div class="card-body 
              <?php if(empty($lacking)): 
                echo("d-flex justify-content-center align-items-center");
              endif;
                ?>
              
              " style="min-height: 290px;">

        

              <?php if(!empty($lacking)): ?>
                <table class="table table-bordered">
                  <thead>
                    <th></th>
                    <th>Student</th>
                    <th>Lacking Documents</th>
                  </thead>
                  <tbody>
                    <?php foreach($lacking as $row): ?>
                      <tr>
                        <td><a href="student?action=records&id=<?php echo($row["student_id"]); ?>" class="btn btn-warning btn-block btn-sm">Update</a></td>
                        <td><?php echo($row["student_name"]); ?></td>
                        <td><?php echo($row["documents_tagged_no"]); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              <?php else: ?>
                <img src="resources/no_result.gif" class="img-fluid" alt="Responsive Image" style="max-height: 250px; max-width: 100%;">
              <?php endif; ?>
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

<script src="AdminLTE_new/plugins/chart.js/Chart.min.js"></script>


  <!-- <script src="vector_maps/tests/assets/jquery-jvectormap-world-mill-en.js"></script> -->
  <script>

    var donutData        = {
      labels: [
        'Grade 1',
          'Grade 2',
          'Grade 3',
          'Grade 4',
          'Grade 5',
          'Grade 6',
      ],
      datasets: [
        {
          data: [30,40,30,25,45,20],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }

    var donutData2        = {
      labels: [
        'Not Submitted',
        'Submitted',
      ],
      datasets: [
        {
          data: [2,8],
          backgroundColor : ['#f56954', '#00a65a'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }

//     var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
//  new Chart(donutChartCanvas, {
//       type: 'doughnut',
//       data: donutData2,
//       options: donutOptions
//     })

var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
    // jQuery.noConflict();
    jQuery(function(){
      // var $ = jQuery;

      // $('#focus-single').click(function(){
      //   $('#map1').vectorMap('set', 'focus', {region: 'AU', animate: true});
      // });
      // $('#focus-multiple').click(function(){
      //   $('#map1').vectorMap('set', 'focus', {regions: ['AU', 'JP'], animate: true});
      // });
      // $('#focus-coords').click(function(){
      //   $('#map1').vectorMap('set', 'focus', {scale: 7, lat: 35, lng: 33, animate: true});
      // });
      // $('#focus-init').click(function(){
      //   $('#map1').vectorMap('set', 'focus', {scale: 1, x: 0.5, y: 0.5, animate: true});
      // });
      $('#map1').vectorMap({
        map: 'usa_en',
        panOnDrag: true,
        backgroundColor: 'transparent',
        regionStyle: {
        initial: {
            fill: '#fff',
            'fill-opacity': 1,
            stroke: '#000', // Set stroke color to black
            'stroke-width': 3, // Adjusted stroke width
            'stroke-opacity': 1 // Adjusted stroke opacity
        }
    },
        // focusOn: {
        //   x: 0.5,
        //   y: 0.5,
        //   scale: 2,
        //   animate: true
        // },
        series: {
          regions: [{
            scale: ['#C8EEFF', '#0071A4'],
            normalizeFunction: 'polynomial',
            values: {
              "1": 16.63,
              "AL": 11.58,
              "DZ": 158.97,
              "AO": 85.81,
              "AG": 1.1,
              "17": 351.02,
              "AM": 8.83,
              "AU": 1219.72,
              "AT": 366.26,
              "AZ": 52.17,
              "BS": 7.54,
              "BH": 21.73,
              "BD": 105.4,
              "BB": 3.96,
              "BY": 52.89,
              "BE": 461.33,
              "BZ": 1.43,
              "BJ": 6.49,
              "BT": 1.4,
              "BO": 19.18,
              "BA": 16.2,
              "BW": 12.5,
              "BR": 2023.53,
              "BN": 11.96,
              "BG": 44.84,
              "BF": 8.67,
              "BI": 1.47,
              "KH": 11.36,
              "CM": 21.88,
              "CA": 1563.66,
              "CV": 1.57,
              "CF": 2.11,
              "TD": 7.59,
              "CL": 199.18,
              "12": 5745.13,
              "CO": 283.11,
              "KM": 0.56,
              "CD": 12.6,
              "CG": 11.88,
              "CR": 35.02,
              "CI": 22.38,
              "HR": 59.92,
              "CY": 22.75,
              "CZ": 195.23,
              "DK": 304.56,
              "DJ": 1.14,
              "DM": 0.38,
              "DO": 50.87,
              "EC": 61.49,
              "EG": 216.83,
              "SV": 21.8,
              "GQ": 14.55,
              "ER": 2.25,
              "EE": 19.22,
              "ET": 30.94,
              "FJ": 3.15,
              "FI": 231.98,
              "FR": 2555.44,
              "GA": 12.56,
              "GM": 1.04,
              "GE": 11.23,
              "DE": 3305.9,
              "GH": 18.06,
              "GR": 305.01,
              "GD": 0.65,
              "GT": 40.77,
              "GN": 4.34,
              "GW": 0.83,
              "GY": 2.2,
              "HT": 6.5,
              "15": 15.34,
              "HK": 226.49,
              "HU": 132.28,
              "IS": 12.77,
              "IN": 1430.02,
              "ID": 695.06,
              "IR": 337.9,
              "IQ": 84.14,
              "IE": 204.14,
              "IL": 201.25,
              "IT": 2036.69,
              "JM": 13.74,
              "JP": 5390.9,
              "JO": 27.13,
              "KZ": 129.76,
              "KE": 32.42,
              "38": 0.15,
              "37": 986.26,
              "KW": 117.32,
              "KG": 4.44,
              "LA": 6.34,
              "LV": 23.39,
              "LB": 39.15,
              "LS": 1.8,
              "LR": 0.98,
              "LY": 77.91,
              "LT": 35.73,
              "LU": 52.43,
              "MK": 9.58,
              "MG": 8.33,
              "MW": 5.04,
              "MY": 218.95,
              "MV": 1.43,
              "ML": 9.08,
              "MT": 7.8,
              "MR": 3.49,
              "MU": 9.43,
              "MX": 1004.04,
              "MD": 5.36,
              "MN": 5.81,
              "ME": 3.88,
              "MA": 91.7,
              "MZ": 10.21,
              "MM": 35.65,
              "NA": 11.45,
              "NP": 15.11,
              "32": 770.31,
              "NZ": 138,
              "NI": 6.38,
              "NE": 5.6,
              "NG": 206.66,
              "NO": 413.51,
              "OM": 53.78,
              "35": 174.79,
              "PA": 27.2,
              "2": 8.81,
              "3": 17.17,
              "PE": 153.55,
              "PH": 189.06,
              "25": 438.88,
              "PT": 223.7,
              "4": 126.52,
              "RO": 158.39,
              "5": 1476.91,
              "6": 5.69,
              "7": 0.55,
              "ST": 0.19,
              "SA": 434.44,
              "SN": 12.66,
              "RS": 38.92,
              "SC": 0.92,
              "SL": 1.9,
              "SG": 217.38,
              "SK": 86.26,
              "SI": 46.44,
              "SB": 0.67,
              "ZA": 354.41,
              "ES": 1374.78,
              "LK": 48.24,
              "KN": 0.56,
              "LC": 1,
              "VC": 0.58,
              "SD": 65.93,
              "SR": 3.3,
              "SZ": 3.17,
              "SE": 444.59,
              "CH": 522.44,
              "SY": 59.63,
              "TW": 426.98,
              "TJ": 5.58,
              "TZ": 22.43,
              "TH": 312.61,
              "TL": 0.62,
              "TG": 3.07,
              "TO": 0.3,
              "TT": 21.2,
              "TN": 43.86,
              "TR": 729.05,
              "TM": 0,
              "UG": 17.12,
              "UA": 136.56,
              "AE": 239.65,
              "GB": 2258.57,
              "US": 14624.18,
              "UY": 40.71,
              "UZ": 37.72,
              "VU": 0.72,
              "21": 285.21,
              "VN": 101.99,
              "YE": 30.02,
              "17": 15.69,
              "18": 5.57
            }
          }]
        },




      });
    })
  </script>










<!-- <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- Morris.js charts -->
<script src="AdminLTE/bower_components/raphael/raphael.min.js"></script>
<!-- <script src="bower_components/morris.js/morris.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script> -->
<!-- jvectormap -->
<!-- <script src="AdminLTE_new/plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script> -->
<!-- <script src="AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->

<!-- jQuery Knob Chart -->
<!-- <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="bower_components/moment/min/moment.min.js"></script> -->
<!-- <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->
<!-- datepicker -->
<!-- <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->
<!-- Slimscroll -->
<!-- <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="bower_components/fastclick/lib/fastclick.js"></script> -->
<!-- AdminLTE App -->
<!-- <script src="dist/js/adminlte.min.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->


<!-- 
<script>
var visitorsData = {
    path1: 200, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
};

var labels = {
    '1': 'Sen. John Doe (R) - Voted Yes<br/>Sen Jane Doe (D) - Voted No',
    '2': 'Some other text, you can make use of html tags'
};

$('#world-map').vectorMap({
    map: 'usa_en',
    backgroundColor: 'transparent',
    regionStyle: {
        initial: {
            fill: '#fff',
            'fill-opacity': 1,
            stroke: '#000', // Set stroke color to black
            'stroke-width': 3, // Adjusted stroke width
            'stroke-opacity': 1 // Adjusted stroke opacity
        }
    },
    series: {
        regions: [{
            attribute: 'fill',
            values: {
                "1": '#ccc', // Color for path with ID "1"
                "34": '#ccc', // Color for path with ID "2"
                "7": '#ccc'  // Color for path with ID "2"
            },
            // scale: ['#ffffff', '#0154ad'],
            // normalizeFunction: 'polynomial'
        }]
    },
    onRegionLabelShow: function(event, label, code){
    if (!labels.hasOwnProperty(code)) {
        // no text found, return standard state name
        return true;
    }

    // construct label for state with extra text
    label.html(
        '<strong>' + label.html() + '</strong><br/>' + labels[code]
    );
}
//     onRegionLabelShow: function (e, el, code) {
//     console.log("Region label show event triggered for code: ", code);

//     // Check if el is a jQuery object
//     if (!(el instanceof jQuery)) {
//         console.error("el is not a jQuery object.");
//         return;
//     }

//     // Set custom HTML content for the label
//     el.html("awit");

//     // Log the HTML content of the label
//     console.log("Label HTML content: ", el.html());
// }
});

</script> -->

<script>
$(document).ready(function(){
    $("#toggleFullscreen").click(function(){
        var elem = $("#fullscreenDiv").get(0); // Get the DOM element
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => {
                alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
            });
            $("#map1").css("height", "800px"); // Set height to 800px when entering fullscreen
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
            $("#map1").css("height", "350px"); // Set height to 400px when exiting fullscreen
        }
    });
});



</script>
<?php require("layouts/footer.php") ?>