<?php
session_start();
$conn = mysqli_connect($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'], $_SESSION['dbname']);

$select = "SELECT * FROM students WHERE email = '$_COOKIE[student]';";
$result = $conn->query($select);
$row = $result->fetch_assoc();

$pageTitle = "Exam";
require_once 'header.php';

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


    <!--progressbar
      <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <div id="progressBars" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 0%"></div>
      </div>
      -->


    <!--startBtn-->
    <div class="d-grid gap-2 d-md-grid justify-content-md-center">
      <button type="button" class="btn btn-lg btn-bd-red" id="startBtn">Start</button> <br />
    </div>


  </div>

  <!--Dark mode-->
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-secondary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#sun-fill"></use>
          </svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#moon-stars-fill"></use>
          </svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em">
            <use href="#circle-half"></use>
          </svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em">
            <use href="#check2"></use>
          </svg>
        </button>
      </li>
    </ul>
  </div>

  <script>
    document.getElementById('startBtn').addEventListener('click', function() {
      window.location.href = 'moreInfo.php';
    });
  </script>

  <?php
  // Include footer.
  require_once 'footer.php';
  ?>