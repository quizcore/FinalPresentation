<?php
// In the individual PHP files, check if the constant indicating the application is defined.
if (!defined('MY_APP')) {
    // If the constant is not defined, redirect the user to the homepage and terminate the script.
    header('Location: index.php');
    exit;
}

// functions.php

function displayQuestions($result)
{
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="container shadow p-3 my-5 bg-body-tertiary rounded">';
            echo '<h4>' . $row["question_body"] . '</h4>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-A" name="' . $row["question_id"] . '" value="' . $row["answer_1"] . '" required>';
            echo '<label class="form-check-label" for="'  . $row["question_id"] . '-A">A: ' . $row["answer_1"] . '</label><br>';
            echo '</div>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-B" name="' . $row["question_id"] . '" value="' . $row["answer_2"] . '" required>';
            echo '<label class="form-check-label" for="'  . $row["question_id"] . '-B">B: ' . $row["answer_2"] . '</label><br>';
            echo '</div>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-C" name="' . $row["question_id"] . '" value="' . $row["answer_3"] . '" required>';
            echo '<label class="form-check-label" for="'  . $row["question_id"] . '-C">C: ' . $row["answer_3"] . '</label><br>';
            echo '</div>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="'  . $row["question_id"] . '-D" name="' . $row["question_id"] . '" value="' . $row["answer_4"] . '" required>';
            echo '<label class="form-check-label" for="'  . $row["question_id"] . '-D">D: ' . $row["answer_4"] . '</label><br>';
            echo '</div>';
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
