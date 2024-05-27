<?php
define('MY_APP', true);
session_start();
include_once 'dbconnection.php';

$select = "SELECT * FROM students WHERE email = '$_COOKIE[student]';";
$result = $conn->query($select);
$row = $result->fetch_assoc();

$pageTitle = "Exam";
require_once 'exam-header.php';
?>

<!-- Main -->
<main>
  <!--Main Container-->
  <div class="container">
    <!-- Display User info-->
    <div class="container shadow p-3 my-5 bg-body-tertiary rounded">
      <h1>Welcome <?php echo $row["first_name"] . ' ' . $row["last_name"]; ?></h1>
    </div>

    <!-- New Guidelines Div -->
    <div id="guidelinesDiv" class="container shadow p-3 my-5 bg-body-tertiary rounded">
      <h2>Welcome to the Computer Science Self-Placement Exam</h2>
      <p>At Central Washington University, we understand that each student enters our computer science program with a unique set of skills and experiences. This self-placement exam is designed to identify your current proficiency in essential computer science and programming concepts, ensuring that you enroll in courses that align with your knowledge level.</p>

      <p>The exam features multiple-choice questions based on the introductory programming courses at CWU, focusing on fundamental aspects such as variables, conditionals, program structure, and object-oriented concepts. Although the questions use Java for examples, the goal is to assess your overall understanding of programming principles.</p>

      <p>To maximize your performance, please find a quiet, distraction-free environment. Read each question thoroughly and trust your instincts when selecting an answer. The results will guide us in tailoring your coursework to better suit your educational needs, setting you on the path to success in our program.</p>

      <h3>Exam Tips:</h3>
      <ul>
        <li>Ensure thorough understanding by reading questions carefully.</li>
        <li>Rely on your knowledge and intuition when answering.</li>
        <li>Avoid external aids to simulate an accurate academic assessment.</li>
      </ul>

      <h3>How to Prepare:</h3>
      <p>Strengthen your readiness by reviewing core programming concepts and engaging in practical Java coding exercises. Consider revisiting the basics of object-oriented programming and familiarizing yourself with Java syntax to build confidence and proficiency.</p>

      <p>Good luck! We are excited to help you start your journey in computer science with confidence and clarity.</p>
    </div>

    <div class="d-grid gap-2 d-md-grid justify-content-md-center">
      <button type="button" class="btn btn-lg btn-bd-red" id="startBtn">Start</button> <br />
    </div>
  </div>
</main>

<script>
  document.getElementById('startBtn').addEventListener('click', function() {
    window.location.href = 'exam-more-info.php';
  });
</script>

<?php
require_once 'exam-footer.php';
$conn->close();
?>