
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Professor Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .pad{
        padding: 20px 20px 20px 20px;
        }
        .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      text-align: center;
        }
        .home{
        position: fixed;
        left: 0;
        width: 100%;
        text-align: right;
        padding: 0px 30px 5px 0px;
        font-size: 35px;
        }
     </style>
  </head>
  <body class="pad">
    <div class="container-fluid">
        <div class="home">
                <a href="index.html"><i class="fa fa-home" aria-hidden="true"></i></a>
        </div>
      <div class="row">
        <h1>Professor</h1>

      </div>
    <div class="row">

      <form action="Professor.php" method="post">
        Return Professor Schedule:
        <form class="form-inline">
          <div class="form-group mb-2">
            <input type="text" name="pssn"placeholder="XXX-XX-XXXX">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
          </div>
        </form>
      </form>
    </div>
    <div class="row">

      <form action="Professor.php" method="post">
        Return Grades:
        <form class="form-inline">
          <div class="form-group mb-2">
            <input type="text" name="Cnum" placeholder="Course Number">
            <input type="text" name="Snum"placeholder="Section Number">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
          </div>
        </form>




  <!--       <input type="text" name="Cnum">
         <input type="text" name="Snum">
         <button type="submit" name="button">submit</button>
-->      </form>

      <!--
        more form posts here
     -->
   </div>
   <br>

    <div class="row justify-content-left">
      <?php
        if(!empty($_POST['pssn'])){
          $conn = mysql_connect('mariadb', 'cs332s34', 'sho4ahBi');
          if(!$conn){
                die('Could not connect to DB '.mysql_error());
          }

          mysql_select_db("cs332s34",$conn);
          $sql ="
          Select
            Course.Title,
            Section.Classroom,
                Section.MeetingDays,
            Section.BeginTime,
            Section.EndTime
          FROM
            Section,
            Course
          WHERE Section.CourseNumber = Course.CourseNum
          AND Section.PSSN = '".$_POST["pssn"]."';";
          $result = mysql_query($sql, $conn);
          if(mysql_numrows($result)==0){
          echo "</br><h3>We could not find SSN ".$_POST["pssn"]." in our records.</h3></br>";
          }
          //output here
          for($i=0; $i<mysql_numrows($result); $i++)
          {
            ?>
          <div class="col-sm-auto">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title"><?php echo mysql_result($result,$i,"Title"); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo "Room ".mysql_result($result,$i,"Classroom"); ?></h6>
                <p class="card-text"><?php echo mysql_result($result,$i,"MeetingDays")." at ".mysql_result($result,$i,"BeginTime")." to ".mysql_result($result,$i,"EndTime"); ?></p>
              </div>
            </div>
          </div>
            <?php
          }

          mysql_close($conn);
        }
      ?>
    </div>
    <div class="row justify-content-sm-left">
      <?php

            if(!empty($_POST['Cnum'])&&!empty($_POST['Snum'])){
              $conn = mysql_connect('mariadb', 'cs332s34', 'sho4ahBi');
              if(!$conn){
                die('Could not connect to DB '.mysql_error());
              }

              mysql_select_db("cs332s34",$conn);
              $sql ="
              Select
                Grade,
                Count(Grade) as GradeCount
              FROM
                Enroll
              WHERE SectionNo = ".$_POST["Snum"]."
              AND CourseNumber = ".$_POST["Cnum"]."
              Group By Grade;";

              $result = mysql_query($sql, $conn);
              if(mysql_numrows($result)==0){
              echo "</br><h3>We could not find Snum ".$_POST["Snum"]." in our records.</h3></br>";
              }


              ?>
              <div class="col-md-3">
                <div class="row">


              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Grade</th>
                    <th scope="col">Count</th>
                  </tr>
                </thead>
                <tbody>
              <?php
                for($i=0; $i<mysql_numrows($result); $i++){
                  ?>
                  <tr>
                    <td><?php echo mysql_result($result,$i,"Grade");?> </td>
                    <td><?php echo mysql_result($result,$i,"GradeCount"); ?> </td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
              <?php
              //output here
            //  for($i=0; $i<mysql_numrows($result); $i++)
          //    {
          //      echo "</br>".mysql_result($result,$i,"Grade")
            //    .mysql_result($result,$i,"GradeCount"), "</br>";
          //    }

              mysql_close($conn);
            }

            //if more posts here
       ?>
    </div>
  </div>

  <div class="footer">

    Programmers:
    </br>
    Adrian Puentes
    </br>
    Joseph Haddad
    </br>
    Leorenzo Openano

  </div>

  </body>
</html>
