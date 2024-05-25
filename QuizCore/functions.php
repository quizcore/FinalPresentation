<?php
// In the individual PHP files, check if the constant indicating the application is defined.
if (!defined('MY_APP')) {
    // If the constant is not defined, redirect the user to the homepage and terminate the script.
    header('Location: index.php');
    exit;
}

// functions.php

function prepareScriptInput($text)
{
    return str_replace('`', '\\`', $text);
}

function displayQuestions($result)
{
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="container shadow p-3 my-5 bg-body-tertiary rounded">';
            echo '<div id="question-body-' . $row["question_id"] . '">';
            echo '  <script>document.getElementById("question-body-'  . $row["question_id"] . '").innerHTML=marked.parse(`' . prepareScriptInput($row["question_body"]) . '`);</script>';
            echo '</div>';

            $answers = ['0' => $row["answer_1"], '1' => $row["answer_2"], '2' => $row["answer_3"], '3' => $row["answer_4"]];
            foreach ($answers as $key => $answer) {
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="radio" id="' . $row["question_id"] . '-' . $key . '" name="' . $row["question_id"] . '" value="' . $key . '" required>';
                echo '<div id="display-' . $row["question_id"] . '-' . $key . '">';
                echo '  <script>document.getElementById("display-'  . $row["question_id"] . '-' . $key . '").innerHTML=marked.parse(`' . prepareScriptInput($answer) . '`);</script>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        }
    }
}

// Function to generate a Bootstrap progress bar
function generateProgressBar($width = 25)
{
    $progressBar = "
        <div class='container shadow p-3 my-5 bg-body-tertiary rounded'>
            <div class='progress' role='progressbar' aria-label='Animated striped example' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>
                <div id='progressBars' class='progress-bar progress-bar-striped progress-bar-animated bg-danger' style='width: {$width}%'></div>
            </div>
        </div>
    ";

    return $progressBar;
}
