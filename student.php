<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Student Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
   <div class="home">
        <a href="index.html"><i class= "fa fa-home" aria-hidden="true"></i></a>
</div>
    <h1>Student </h1>
    <div>

      <form action="student.php" method="post">
        Return courses and grades:
        <input type="text" placeholder="CWID" name="CWID">
        <button type="submit" name="button">submit</button>
      </form></br>

      <form action="student.php" method="post">
        Return Course Information:
        <input type="text" placeholder="Course Number" name="Cnum">
        <button type="submit" name="button">submit</button>
      </form></br>

      <!--
        more form posts here
     -->
   </div>

<div class="row justify-content-left pad">
      <?php
        if(!empty($_POST['CWID'])){
          $conn = mysql_connect('mariadb', 'cs332s34', 'sho4ahBi');
          if(!$conn){
                die('Could not connect to DB '.mysql_error());
          }

          mysql_select_db("cs332s34",$conn);
          $sql ="
          Select
            e.StudentID,
            e.CourseNumber,
            e.Grade,
            c.Title
          FROM
            Enroll e,
            Course c
          WHERE
            e.CourseNumber = c.CourseNum
          AND e.StudentID = ".$_POST["CWID"].";";
          $result = mysql_query($sql, $conn);
          if(mysql_numrows($result)==0){
          echo "</br><h3>We could not find CWID ".$_POST["CWID"]." in our records.</h3></br>";
          }
        ?>
<div class="col-md-3">
                <div class="row">


              <table class="table table-striped  table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">Course</th>
                    <th scope="col">Grade</th>
                  </tr>
                </thead>
                <tbody>
              <?php
                for($i=0; $i<mysql_numrows($result); $i++){
                  ?>
                  <tr>
                    <td><?php echo mysql_result($result,$i,"Title");?> </td>
                    <td><?php echo mysql_result($result,$i,"Grade"); ?> </td>
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

<div class="row justify-content-left">
      <?php

            if(!empty($_POST['Cnum'])){
              $conn = mysql_connect('mariadb', 'cs332s34', 'sho4ahBi');
              if(!$conn){
                die('Could not connect to DB '.mysql_error());
              }

              mysql_select_db("cs332s34",$conn);
              $sql ="
              Select
                e.CourseNumber,
                e.SectionNo,
                s.Classroom,
                s.MeetingDays,
                s.BeginTime,
                s.EndTime,
                count(e.StudentID) as sCount
              FROM
                Section s,
                Enroll e WHERE e.SectionNo = s.SectionNum and e.CourseNumber = s.CourseNumber
              AND e.CourseNumber = ".$_POST["Cnum"]."
              Group By e.SectionNo;";

              $result = mysql_query($sql, $conn);
              if(mysql_numrows($result)==0){
              echo "</br><h3>We could not find Course number ".$_POST["Cnum"]." in our records.</h3></br>";
              }

              //output here
        for($i=0; $i<mysql_numrows($result); $i++)
          {
            ?>
          <div class="col-sm-auto">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title"><?php echo mysql_result($result,$i,"CourseNumber"); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo "Section ".mysql_result($result,$i,"SectionNo"); ?></h6>
                <p class="card-text"><?php echo "No. of students enrolled  ".mysql_result($result,$i,"sCount"); ?></p>
                <p class="card-text"><?php echo "Room ". mysql_result($result,$i,"Classroom"); ?></p>
                <p class="card-text"><?php echo mysql_result($result,$i,"MeetingDays")." at ".mysql_result($result,$i,"BeginTime")." to ".mysql_result($result,$i,"EndTime"); ?></p>
              </div>
            </div>
          </div>
            <?php
          }

              mysql_close($conn);
            }

            //if more posts here
       ?>

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
