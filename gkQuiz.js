

/* global quiz, quizContainer, output, option, saveAnswer, previous, nextButton, submitButton, 
 * previousButton, sunmitQuiz, question, startAgain, saveButton, resultsContainer, display, previousButton */

// @param {String} correctIndex - Variable for storing current index 
currentIndex = 0;
// @param {Array[]} output - to display whole quiz
output = [];

// @param {Array} variablelist - to store in localstorage with this reference
var variablelist = ["num1", "num2", "num3", "num4", "num5"];

// Quiz to show
quiz = [
    {
        question: "What is the sum of all angles in a triangle?",
        option: ["60 degrees", "10 degrees", "180 degrees", "200 degrees"],
        correctAnswer: "2"
    },
    {
        question: "What would you need a modem for?",
        option: ["Typing", "Cycling", "Cable TV", "internet and/or telephone connection"],
        correctAnswer: "3"
    },
    {
        question: "After how many years together do couples celebrate their diamond anniversary?",
        option: ["35 years", "60 years", "55 years", "30 years"],
        correctAnswer: "1"
    },
    {
        question: "Which symbol is found on the Canadian Flag?",
        option: ["Star", "Cross", "Cranberry", "Maple Leaf"],
        correctAnswer: "3"
    },
    {
        question: "Which logo on a flag identifies a ship's crew as pirates?",
        option: ["Hammer and sickle", "Lion", "Bull", "Skull and crossbones"],
        correctAnswer: "3"
    }
];

// quizContainer for reference "quiz" div
quizContainer = document.getElementById("quiz");

// resultsConatiner for reference "results" div
resultsContainer = document.getElementById("results");

// submitButton for reference "submit" button
submitButton = document.getElementById("submit");

// startBtton for reference "startQuiz" start Button
startButton = document.getElementById("startQuiz");

// previousButton for reference "previous" previous Button
previousButton = document.getElementById("previous");

// nextButton for reference "next" next Button
nextButton = document.getElementById("next");

// saveButton for reference "saved" Button
saveButton = document.getElementById("saved");

// startAgain for reference "startAgain" Button
startAgain = document.getElementById("startAgain");

// display for reference "displaySavedAnswer" div
display = document.getElementById("displaySavedAnswer");

// onClick event for submitButton 
submitButton.addEventListener("click", sunmitQuiz);

// onClick event for previousButton
previousButton.addEventListener("click", previous);

// onClick event for nextButton
nextButton.addEventListener("click", next);

// onClick event for saveButton
saveButton.addEventListener("click", saveAnswer);

// onClick event to start the Quiz from beginning
startAgain.addEventListener("click", reloadHTML);

// onClick event to display results
display.addEventListener("click", displayAnswer);

// When the Quiz starts submitButton, previousButton, startAgain button 
// and resultsContainer 's visibility is set to none
submitButton.style.display = "none";
previousButton.style.display = "none";
startAgain.style.display = "none";
resultsContainer.style.display = "none";

// Shows the progress of the Quiz
displayAnswer();

// Calls to build the Quiz
buildQuiz();


/**
 * Displaying image to show the progress of Questions
 * @param {Array[]} displayImage - Array for displaying progress and save status
 * 
 */

function displayAnswer()
{
    displayImage = [];

    // Looping number of times the questions is
    for (var i = 0; i < quiz.length; i++)
    {
        displayImage.push(`<p>Question ${i + 1}</p><img src="beforeSaved.png" onclick = "imageClicked" name="question${i + 1}">`);
    }

    // Quiz Progress is diplayed to HTML
    display.innerHTML = displayImage.join("");
}

/**
 * Displaying image to show the progress of Questions
 * @pram {Array[]} displayImage - Array for displaying progress and save status
 * 
 */

function imageClicked()
{
    // alert box for whenever user clicks on progress image which results in losing of all saved answer
    alert('Warning !! You losed all you saved options');
    localStorage.clear();
}

/**
 * Making Quiz from quiz array
 * @pram {Array[]} displayImage - Array for displaying progress and save status
 * 
 */
function buildQuiz() {

    // Looping through Quiz array and get index and item as argument 
    quiz.forEach((item, index) => {

        // initializing array to store all questions of Quiz
        outputAnswers = [];

        // Looping through all options of respected questions
        for (option in item.option)
        {
            // Storing all options with respected question in the outer loop
            outputAnswers.push(
                    `<label> <input type="radio" name="question${index}" value="${option}  " >
                                        ${item.option[option]} </label><br>`
                    );
        }

        // Storing all data in to output Array to display Quiz to the user
        output.push(
                // Display Question and its four opions
                `<div class="question"> ${item.question} </div>
           <div class="answers"> ${outputAnswers.join("")} </div>`
                );
    });

    // Displaying first Qestion and its options
    quizContainer.innerHTML = output[0];

    // Clearing all data stored in local storage
    window.localStorage.clear();
}

/**
 * Displaying Quiz with Question and its respected option
 */
function displayQuiz(index)
{
    //if the value passed as argument is less than the Quiz length then the condition returns true
    if (index < quiz.length) {

        // Quiz division we created in HTML is filled up with the HTML stored in output array
        quizContainer.innerHTML = output[index];

        // condition returns true if user has already saved answer for current instance of question
        if (localStorage.getItem(variablelist[index]) !== null) {

            // local variable for storing index of the option user selected option
            const localValue = localStorage.getItem(variablelist[index]);

            // Filled up with data that contains "answers" as their class in the document that
            // is on the display
            const allResults = document.querySelectorAll(".answers");

            // selects Division and stores into a variable
            const divisonContianer = allResults[0];

            // selects these statement in
            const search = `input[name=question${index}]`;
            // getting the statement to checked radio button
            const inputStatements = (divisonContianer.querySelectorAll(search));
            // accessing checked index which the user saved
            const checkingRadio = inputStatements[localValue - 0];
            // checking the radio button on page refresh
            checkingRadio.checked = true;

        }

        // Turning display of Progress of Quiz to true
        display.style.display = "inline-block";

        // As we have completed the first page of the Quiz 
        // display Previous Button, Next Button, Save Button to Naviagate and 
        // Save Answer
        previousButton.style.display = "inline-block";
        nextButton.style.display = "inline-block";
        saveButton.style.display = "inline-block";

        // As we are somewhere in the middle of the Quiz we are displaying the submit Button
        submitButton.style.display = "none";

        // if the current Question is the first page then previous Button is not diplayed
        if ((index - 1) < 0)
        {
            previousButton.style.display = "none";
        }
    }
    // if the user reached last question of the Quiz then Progress of the Quiz, Quiz itself,
    // Next Button, Save Button is not displayed
    // Instead Submit button is displayed and with Previous Button still displayed
    else
    {
        display.style.display = "none";
        quizContainer.innerHTML = "";
        nextButton.style.display = "none";
        saveButton.style.display = "none";
        submitButton.style.display = "inline-block";
    }
}
/**
 * When the user clicks Next Button then this method is fired
 */
function next()
{
    // current Index states the number of Question in this instance
    currentIndex = currentIndex + 1;
    // fires displayQuiz method to display whole Quiz with new instance number
    return displayQuiz(currentIndex);
}

/**
 * When the user clicks Previous Button then this method is fired
 */
function previous()
{
    // current Index states the number of Question in this instance
    currentIndex = currentIndex - 1;
    // fires displayQuiz method to display whole Quiz with new instance number
    return displayQuiz(currentIndex);
}

/**
 * When the user clicks Save Button then this method is fired
 */
function saveAnswer()
{
    // selects all containers with "answers" as a class
    const answerContainers = document.querySelectorAll(".answers");
    
    // Selecting every time first divison in the array to get current instance of the Question
    const answerContainer = answerContainers[0];
    // Making select input statement which is checked
    selector = `input[name=question${currentIndex}]:checked`;
    // Implementing the select statement with the input radio checked
    const userAnswer = (answerContainer.querySelector(selector) || {});
    // saving the checked radio button to local storage
    localStorage.setItem(variablelist[currentIndex], userAnswer.value);
    
    // if the radio buttton is selected and the answer is saved then condition returns true
    if (userAnswer.value !== undefined) {
        // selecting all the containters with this "imageSaved" to change the image
        // to show the user saved the answer
        const saveContainers = document.querySelectorAll(".imageSaved");
        // selecting index 0 to from the array to get instance of the Question
        const saveContainer = saveContainers[0];
        // Select statement for image of progress of the Quiz
        const select = `img[name=question${currentIndex + 1}]`;
        // Implementing select statement to get the image of the progress of current
        // instance of Question displayed
        const userAns = (saveContainer.querySelector(select));
        // changing the image to shoe the image is saved
        userAns.src = "afterSaved.png";
    }
}

// keeps track correct Answer selected by the user
correctAns = 0;
// keeps track for number answer selected by the uer
answersSelected = 0;

/**
 * When the user clicks Submit Quiz Button then this method is fired
 */
function sunmitQuiz()
{
    // looping through number of questions
    for (var i = 0; i < 4; i++)
    {
        // if the user haven't saved any answer then condition returns true
        if (localStorage.getItem(variablelist[i]) === null)
        {
            // incrementing answer selected by the user to keep track if the number of Quesitons
            // not answer
            answersSelected++;
        }
    }
    // if the the "answerSelected" variable returns 0 for no answer selected
    if (answersSelected === 0) {
        
        // looping through Quiz Array
        quiz.forEach(((item, index) =>
        {
            // correctAnswer for storing the correctAnswer stored from Quiz array and converted to into
            // by subtracting 0
            var correctAnswer = quiz[index].correctAnswer - 0;
            // userAn for storing the user saved answer from local storage and converted to into
            // by subtracting 0
            var userAn = localStorage.getItem(variablelist[index]) - 0;
            
            // if the correctAnswer from the QuizArray is equals to userAn from local storage 
            if (correctAnswer === userAn)
            {
                // correectAnswer counter is incremented
                correctAns++;
            }
        }));
        
        // resultsContainer display set to null
        resultsContainer.innerHTML = "";
        // quizContainer is filled up with answer
        quizContainer.innerHTML = correctAns + " out of 4";
        // submitButton, previousButton, saveButton display is set to null as the user submitted the Quiz
        submitButton.style.display = "none";
        previousButton.style.display = "none";
        saveButton.style.display = "none";
        // And startAgain button is displayed to start the Quiz from the beginning
        startAgain.style.display = "inline-block";

    } 
    // if the user haven't selected saved all answers 
    else
    {
        // resultscontainer is displayed and filled up with alert that the user can't submit
        // the Quiz until all the answers are not saved
        resultsContainer.style.display = "inline-block";
        resultsContainer.style.color = "red";
        resultsContainer.innerHTML = "* Please select all options";
        // answerSelected is set to 0 for keeping the code running for next time when the user
        // saves all answer clicks submits the Quiz
        answersSelected = 0;
    }
}
/**
 * When the user clicks startAgain Button then this method is fired which reloads the window 
 * to start the Quiz from beginning
 */
function reloadHTML()
{
    // code to clear the local storage
    window.localStorage.clear();
    // code to reload window and run the script form beginning
    location.reload();
}