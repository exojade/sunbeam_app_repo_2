<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../uploads/logocityvet.png">
  <title>Calendar of Activities</title>

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
    .vet-container {
      max-width: 800px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
    }
    .today {
      background-color: #ffd700;
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
   <!-- Calendar start -->
   <div class="vet-container">
        <center><h2>Calendar Activities - May 2024</h2></center>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>1</td>
                </tr>
                <!-- Continue with other rows for the month -->
                <!-- Example: <tr><td>2</td> ... </tr> -->
                <!-- Example: <tr><td>9</td> ... </tr> -->
                <!-- Example: <tr><td>16</td> ... </tr> -->
                <!-- Example: <tr><td>23</td> ... </tr> -->
                <!-- Example: <tr><td>30</td> ... </tr> -->
            </tbody>
        </table>
    </div>
   <!-- Calendar end -->
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