<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../uploads/logocityvet.png">
  <title>Admin Panel</title>

  <!-- CSS -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Ubuntu', sans-serif;
    }
    :root {
      --blue: #287bff;
      --white: #fff;
      --grey: #f5f5f5;
      --black1: #222;
      --black2: #999;
    }
    body {
      min-height: 100vh;
      overflow-x: hidden;
    }
    .container {
      position: relative;
      width: 100%;
    }
    .navigation {
      position: fixed;
      width: 300px;
      height: 100%;
      background: var(--blue);
      border-left: 10px solid var(--blue);
      transition: 0.5s;
      overflow: hidden;
    }
    .navigation.active{
      width: 80px;
    }
    .navigation ul{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
    }
    .navigation ul li{
      position: relative;
      width: 100%;
      list-style: none;
      border-top-left-radius: 30px;
      border-bottom-left-radius: 30px;
    }
    .navigation ul li:hover,
    .navigation ul li.hovered{
      background: var(--white);
    }
    .navigation ul li:nth-child(1){
      margin-bottom: 40px;
      pointer-events: none;
    }
    .navigation ul li a{
      position: relative;
      display: block;
      width: 100%;
      display: flex;
      text-decoration: none;
      color: var(--white);
    }
    .navigation ul li:hover a,
    .navigation ul li.hovered a{
      color: var(--blue);
    }
    .navigation ul li a .icon{
      position: relative;
      display: block;
      min-width: 60px;
      height: 60px;
      line-height: 70px;
      text-align: center;
    }
    .navigation ul li a .icon ion-icon{
      font-size: 1.75em;
    }
    .navigation ul li a .title{
      position: relative;
      display: block;
      padding: 0 10px;
      height: 60px;
      line-height: 60px;
      text-align: start;
      white-space: nowrap;
    }
    .navigation ul li:hover a::after,
    .navigation ul li.hovered  a::before{
      content:'';
      position: absolute;
      right: 0;
      top: -50px;
      width: 50px;
      height: 50px;
      background: transparent;
      border-radius: 50%;
      box-shadow: 35px 35px 0 10px var(--white);
      pointer-events: none;
    }
    .navigation ul li:hover a::after,
    .navigation ul li.hovered a::after{
      content:'';
      position: absolute;
      right: 0;
      top: -50px;
      width: 50px;
      height: 50px;
      background: transparent;
      border-radius: 50%;
      box-shadow: 35px 35px 0 10px var(--white);
      pointer-events: none;
    }
    /* main/topbar */
    .main{
      position: absolute;
      width: calc(100% - 300px);
      left: 300px;
      min-height: 100vh;
      background: var(--white);
      transition: 0.5s;
    }
    .main.active{
      width: calc(100% - 80px);
      left: 80px;
    }  
    .topbar{
      width: 100%;
      height: 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 10px;
    }
    .toggle{
      position: relative;
      width: 60px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2.5em;
      cursor: pointer;
    }
    /* search bar */
    .search{
      position: relative;
      width: 400px;
      margin: 0 10px;
      align-items: center;
    }
    .search label{
      position: relative;
      width: 100%;
    }
    .search label input{
      width: 100%;
      height: 40px;
      border-radius: 40px;
      padding: 5px 20px;
      padding-left: 35px;
      font-size: 18px;
      outline: none;
      border: 1px solid var(--black2);
    }
    .search label ion-icon{
      position: absolute;
      top: 0;
      left: 10px;
      font-size: 1.2em;
    }
    .user{
      position: relative;
      min-width: 40px;
      height: 40px;
      border-radius: 50%;
      overflow: hidden;
      cursor: pointer;
    }
    /* Admin image */
    .user img{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    /* Cards */
    .cardBox{
      position: relative;
      width: 100%;
      padding: 20px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-gap: 30px;
    }
    .cardBox .card{
      position: relative;
      background: var(--white);
      padding: 30px;
      border-radius: 20px;
      display: flex;
      justify-content: space-between;
      cursor: pointer; 
      box-shadow: 0 7px 25px rgba(0,0,0,0.08);
    }
    .cardBox .card .numbers{
      position: relative;
      font-weight: 500;
      font-size: 2.5em;
      color: var(--blue);
    }
    .cardBox .card .cardName{
      color: var(--black2);
      font-size: 1.1em;
      margin-top: 5px;
    }
    .cardBox .card .iconBx{
      font-size: 3.5em;
      color: var(--black2);
    }  
    .cardBox .card:hover{
      background: var(--blue);
    }
    .cardBox .card:hover .numbers,
    .cardBox .card:hover .cardName, 
    .cardBox .card:hover .iconBx
    {
      color: var(--white);
    }
    /* table appointments */
    .details{
      position: relative;
      width: 100%;
      padding: 20px;
      display: grid;
      grid-template-columns: 2fr 1fr;
      grid-gap: 20px;
      /* margin-top: 10px; */
    }
    .details .recentAppointments{
      position: relative;
      display: grid;
      min-height: 300px;
      background: var(--white);
      padding: 20px;
      box-shadow: 0 7px 25px rgba(0,0,0,0.08);
      border-radius: 20px;
    }
    .cardHeader{
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .cardHeader h2{
      font-weight: 600;
      color: var(--blue);
    }
    .btn{
      position: relative;
      padding: 5px 10px;
      background: var(--blue);
      text-decoration: none;
      color: var(--white);
      border-radius: 6px;
    }
    .details table{
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    .details table thead td{
      font-weight: 600;
    }
    .details .recentAppointments table tr{
      color: var(--black1);
      border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    .details .recentAppointments table tr:last-child{
      border-bottom: none;
    }
    .details .recentAppointments table tbody tr:hover{
      background: var(--blue);
      color: var(--white);
    }
    .details .recentAppointments table tr td{
      padding: 10px;
    }
    .details .recentAppointments table tr td:last-child{
      text-align: end;
    }
    .details .recentAppointments table tr td:nth-child(1){
      text-align: end;
    }
    .details .recentAppointments table tr td:nth-child(2){
      text-align: end;
    }
    .details .recentAppointments table tr td:nth-child(3){
      text-align: end;
    }
    .details .recentAppointments table tr td:nth-child(4){
      text-align: end;
    }
    .status.completed{
      padding: 2px 4px;
      background: #8de02c;
      color: var(--white);
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
    }
    .status.pending{
      padding: 2px 4px;
      background: #f00;
      color: var(--white);
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
    }
    /* recent login */
    .recentLogin{
      position: relative;
      display: grid;
      min-height: 400px;
      padding: 20px;
      background: var(--white);
      box-shadow: 0 7px 25px rgba(0,0,0,0.08);
      border-radius: 20px;
    }
    .recentLogin .imgBx{
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
    }
    .recentLogin .imgBx img{
      position: absolute;
      top: 0; 
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .recentLogin table tr:hover{
      background: var(--blue);
      color: var(--white);
    }
    .recentLogin table tr td{
      padding: 12px 10px;
    }
    .recentLogin table tr td{
      font-size: 16px;
      font-weight: 500;
      line-height: 1.2em;
    }
    .recentLogin table tr td h4 span{
      font-size: 14px;
      color: var(--black2);
    }
    .recentLogin table tr:hover{
      background: var(--blue);
      color: var(--white);
    }
    .recentLogin table tr:hover td h4 span{
      color: var(--white);
    }
    /* responsive design */
    @media (max-width: 991px)
    {
      .navigation{
        left: -300px;
      }
      .navigation.active{
        width: 300px;
        left: 0;
      }
      .main{
        width: 100%;
        left: 0;
      }
      .main.active{
        left: 300px;
      }
      .cardBox{
        grid-template-columns: repeat(2,1fr);
      }
    }
    @media (max-width: 768px){
        .details{
          grid-template-columns: repeat(1, 1fr);
        }
        .recentAppointments{
          overflow-x: auto;
        }
        .satus.pending{
          white-space: nowrap;
        }
     }
     @media (max-width: 480px){
      .cardBox{
        grid-template-columns: repeat(1,1fr);
      }
      .cardHeader h2{    
        font-size: 20px;
      }
      .user{
        min-width: 40px;
      }
      .navigation{
        width: 100%;
        left: -100%;
        z-index: 1000;
      }
      .navigation.active{
        width: 100%;
        left: 0;
      }
      .toggle{
        z-index: 10001;
      }
      .main.acive  .toggle {
        position: fixed;
        right: 0;
        left: initial;
        color: #fff;
      }
     }
  </style>
  
  <!-- CSS design-->
</head>
<body>
  <!-- Sidebar -->
  <div class="container">
    <div class="navigation">
      <ul>

        <li>
          <a href="#">
            <span class="icon"></span>
              <img src="../uploads/LGUlogo.png" style="margin-top: 10px;" height="80" class="navbar-brand d-inline-block align-text-top">
              <img src="../uploads/logocityvet.png" style="margin-top: 10px;" height="80" class="navbar-brand d-inline-block align-text-top">
            <span class="title"></span>
          </a>
        </li>

        <li>
          <a href="DOC_index.php">
            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
            <span class="title">Dashboard</span>
          </a>
        </li>

        <li>
          <a href="DOC_admin_profile.php">
            <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
            <span class="title">Admin Profile</span>
          </a>
        </li>

        <li>
          <a href="DOC_pet_patients.php">
            <span class="icon"><ion-icon name="paw-outline"></ion-icon></span>
            <span class="title">Pet Patients</span>
          </a>
        </li>

        <li>
          <a href="DOC_appointments.php">
            <span class="icon"><ion-icon name="briefcase-outline"></ion-icon></span>
            <span class="title">Appointments</span>
          </a>
        </li>

        <li>
          <a href="DOC_calendar_act.php">
            <span class="icon"><ion-icon name="calendar-number-outline"></ion-icon></span>
            <span class="title">Calendar</span>
          </a>
        </li>

        <li>
          <a href="DOC_medical_history.php">
            <span class="icon"><ion-icon name="bag-add-outline"></ion-icon></span>
            <span class="title">Medical History</span>
          </a>
        </li>

        <li>
          <a href="DOC_prescriptions.php">
            <span class="icon"><ion-icon name="recording-outline"></ion-icon></span>
            <span class="title">Prescription</span>
          </a>
        </li>

        <li>
          <a href="#">
            <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
            <span class="title">Sign out</span>
          </a>
        </li>
       
      </ul>
    </div> 

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
          <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
          </div>
    <!-- Search start -->
          <div class="search">
            <label>
              <input type="text" placeholder="search here">
              <ion-icon name="search-outline"></ion-icon>
            </label>
          </div>
    <!-- Search end -->
    <!-- Admin Image start -->
          <div class="user">
              <img src="../uploads/doc2.png" alt="">
          </div>
    <!-- Admin Image end -->
        </div>

    <!-- Cards start -->
      <div class="cardBox">
          <div class="card">
            <div>
              <div class="numbers">25</div>
              <div class="cardName">Appointments</div>
            </div>
              <div class="iconBx">
                <ion-icon name="briefcase-outline"></ion-icon>
              </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers">25</div>
              <div class="cardName">Inquiries</div>
            </div>
              <div class="iconBx">
                <ion-icon name="help-circle-outline"></ion-icon>
              </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers">25</div>
              <div class="cardName">Pending Patients</div>
            </div>
              <div class="iconBx">
                <ion-icon name="paw-outline"></ion-icon>
              </div>
          </div>

          <div class="card">
            <div>
              <div class="numbers">25</div>
              <div class="cardName">Completed Activities</div>
            </div>
              <div class="iconBx">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
              </div>
          </div>

      </div>
    <!-- Cards end -->

    <!-- Details List -->
    <div class="details">
      <div class="recentAppointments">
        <div class="cardHeader">
            <h2>Recent Appointments</h2>
            <a href="#" class="btn">View All</a>
        </div>
        <table>
          <thead>
            <tr>
              <td>Kind</td>
              <td>Pet Owner</td>
              <td>Pet Name</td>
              <td>Condition</td>
              <td>Status</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Cat</td>
              <td>Dina Rose Abiso</td>
              <td>Bullfrog</td>
              <td>Parvo</td>
              <td><span class="status pending">In progress</span></td>
            </tr>

            <tr>
              <td>Cat</td>
              <td>Dina Rose Abiso</td>
              <td>Bullfrog</td>
              <td>Parvo</td>
              <td><span class="status completed">Completed</span></td>
            </tr>

            <tr>
              <td>Dog</td>
              <td>Dina Rose Abiso</td>
              <td>Bullfrog</td>
              <td>Parvo</td>
              <td><span class="status pending">In progress</span></td>
            </tr>

            <tr>
              <td>Dog</td>
              <td>Dina Rose Abiso</td>
              <td>Bullfrog</td>
              <td>Parvo</td>
              <td><span class="status completed">Completed</span></td>
            </tr>

            <tr>
              <td>Cat</td>
              <td>Dina Rose Abiso</td>
              <td>Bullfrog</td>
              <td>Parvo</td>
              <td><span class="status completed">Completed</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Recent Login -->
      <div class="recentLogin">
        <div class="cardHeader">
          <h2>Personnel Visit</h2>
        </div>
        <table>
          
          <tr>
            <td width="60px"><div class="imgBx"><img src="../uploads/doc2.png" alt=""></div></td>
            <td><h4>Maricris Dela Cerna<br><span>Admin</span></h4></td>
          </tr>

          <tr>
            <td width="60px"><div class="imgBx"><img src="../uploads/doc2.png" alt=""></div></td>
            <td><h4>Maricris Dela Cerna<br><span>Admin</span></h4></td>
          </tr>

          <tr>
            <td width="60px"><div class="imgBx"><img src="../uploads/doc2.png" alt=""></div></td>
            <td><h4>Maricris Dela Cerna<br><span>Admin</span></h4></td>
          </tr>

          <tr>
            <td width="60px"><div class="imgBx"><img src="../uploads/doc2.png" alt=""></div></td>
            <td><h4>Maricris Dela Cerna<br><span>Admin</span></h4></td>
          </tr>

          <tr>
            <td width="60px"><div class="imgBx"><img src="../uploads/doc2.png" alt=""></div></td>
            <td><h4>Maricris Dela Cerna<br><span>Admin</span></h4></td>
          </tr>

        </table>
      </div>
    </div>






    <!-- ////// VECTOR MAPS START OVER HERE///// -->
    <!-- ////// VECTOR MAPS END OVER HERE///// -->







  </div>
  </div>


























<!-- JS script -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script> -->
  <script>
    //  menuToggle
    let toggle = document.querySelector('.toggle');
    let navigation = document.querySelector('.navigation');
    let main = document.querySelector('.main');

    toggle.onclick = function(){
      navigation.classList.toggle('active');
      main.classList.toggle('active');
    }
    // add hovered class in selected list item
    let list = document.querySelectorAll('.navigation li');
    function activeLink(){
      list.forEach((item) =>
      item.classList.remove('hovered'));
      this.classList.add('hovered');
    }
    list.forEach((item) =>
    item.addEventListener('mouseover', activeLink));
  </script>
</body>
</html>