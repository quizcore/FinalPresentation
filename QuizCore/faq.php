<?php
define('MY_APP', true);
$pageTitle = "FAQ";
require_once 'header.php';
?>

<!--Main-->
<main class="container mt-5">
  <h1 class="text-center mb-4">Frequently Asked Questions</h1>

  <div class="accordion" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Can I take the test multiple times?
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>You only have one chance to take the test.</strong> This is a test to gauge your understand right now, so to get the best results, it is important that students only get one attempt at the test.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          What happens if I exit the test early?
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          There is no way to resume the test after exiting, but all your answers up to the page you were working on will be saved and can be seen by the advisors here at Central.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Where do the test questions come from?
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          Each question in the exam is designed around the curriculum of the introductory computer science courses offered here at Central.
          These questions are designed in partnership with the computer science department, and cover all the critical components of these classes.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Will this placement test effect my grade or acceptance?
        </button>
      </h2>
      <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>No.</strong> This test will not effect any of your grades or you acceptance into Centeral Washington University.
          This placement test will only be visiable and used by your advisor and the Computer Science department to determine what
          Java course is correct for your knowledge.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          How long will the placement test take? How many times can I take the test?
        </button>
      </h2>
      <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>The student only has one attempt and can assume to spend around 10-30 minutes to complete the test.</strong> The duration of the test will
          depend on your knowledge. If the student tests out of CS110 then there will be two sections to complete; if the student doesn't test out then
          the test will end early.
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        How do I see my course recommendation?
        </button>
      </h2>
      <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>Talk to your advisor!</strong> Your results are avaliable to view by your advisor after you have completed the exam. Reach out to your advisor
          after the test is complete to see what couse you should take.
        </div>
      </div>
    </div>
    <!-- New FAQ: Programming Languages Knowledge -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
          What programming languages should I know before taking the test?
        </button>
      </h2>
      <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          While the test primarily uses <strong>Java</strong> for its questions, a <strong>basic understanding of programming concepts is more crucial</strong> than expertise in a specific language. Familiarity with any programming language that supports object-oriented principles will help you understand the test questions.
        </div>
      </div>
    </div>

    <!-- New FAQ: Use of Calculators or Tools -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
          Are calculators or any other tools allowed during the test?
        </button>
      </h2>
      <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>No</strong> external tools, including calculators, are allowed during the test. This policy helps ensure that the test accurately assesses your raw understanding and problem-solving skills without assistance.
        </div>
      </div>
    </div>

    <!-- New FAQ: Reviewing Questions Post-Submission -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
          Can I review the questions after submitting my test?
        </button>
      </h2>
      <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          Once you submit your test, you will <strong>not be able to review</strong> the questions or your answers. This measure is in place to maintain the integrity of the test. However, your academic advisor can discuss your performance and any specific areas of concern during your course recommendation meeting.
        </div>
      </div>
    </div>

    <!-- New FAQ: Test Content Coverage -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
          What topics are covered in the placement test?
        </button>
      </h2>
      <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          The placement test covers a <strong>range of topics that are essential to introductory computer science courses.</strong> These include data types, variables, control structures (like loops and conditionals), basic algorithms, and object-oriented programming concepts.
        </div>
      </div>
    </div>

    <!-- New FAQ: Scoring and Placement Criteria -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
          How is the test scored, and what criteria determine my placement?
        </button>
      </h2>
      <div id="collapseEleven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          The test is scored based on the <strong>number of correct responses.</strong> Your placement in a particular course will depend on your score, aligning with predefined thresholds that match our curriculum's progression. These thresholds are designed to place students in a course that best suits their current skill level.
        </div>
      </div>
    </div>
  </div>
</main>
<!--End of Main-->

<?php
require_once 'footer.php';
?>