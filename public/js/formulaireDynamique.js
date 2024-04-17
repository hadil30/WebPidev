document.addEventListener("DOMContentLoaded", function () {
  removeUnwantedLabels2();
  removeUnwantedLabels();
  setupDynamicQuestions();
  changeLabelColors();
});
function changeLabelColors() {
  // Select all label elements
  const labels = document.querySelectorAll("label");

  // Iterate through each label
  labels.forEach((label) => {
    // Get the trimmed text content of the label
    const text = label.textContent.trim();

    // Check if the text matches any of the specified patterns
    if (
      text === "0label__" ||
      text === "1label__" ||
      text === "2label__" ||
      text === "3label__" ||
      text === "4label__" ||
      text === "5label__" ||
      text === "6label__" ||
      text === "7label__" ||
      text === "8label__" ||
      text === "9label__"
    ) {
      // Change the color of the label to white
      label.style.color = "white";
    }
  });
}

function setupDynamicQuestions() {
  const collectionHolder = document.querySelector(".question-list");
  if (!collectionHolder) {
    return; // Exit if the .question-list element isn't found
  }
  const buttonGroup = document.querySelector(".button-group");

  const addButton = document.createElement("button");
  addButton.type = "button";
  addButton.className = "btn add-question-btn";
  addButton.textContent = "Add Question";
  buttonGroup.insertBefore(addButton, buttonGroup.childNodes[0]); // Adds the button before the submit button

  let index = collectionHolder.children.length;
  addButton.addEventListener("click", function () {
    addQuestionForm(collectionHolder, index++);
  });
}
function removeUnwantedLabels() {
  document.querySelectorAll("label.required").forEach(function (label) {
    if (
      label.textContent.trim() === "0label__" ||
      label.textContent.trim() === "1label__" ||
      label.textContent.trim() === "2label__" ||
      label.textContent.trim() === "3label__" ||
      label.textContent.trim() === "4label__" ||
      label.textContent.trim() === "5label__" ||
      label.textContent.trim() === "6label__" ||
      label.textContent.trim() === "7label__" ||
      label.textContent.trim() === "8label__" ||
      label.textContent.trim() === "9label__"
    ) {
      label.remove(); // Removes the unwanted label from the DOM
    }
  });
}
function removeUnwantedLabels2() {
  document.querySelectorAll("label.required").forEach(function (label) {
    if (label.textContent.trim() === "Questions") {
      label.remove();
    }
  });
}
function addQuestionForm(collectionHolder, index) {
  const prototype = collectionHolder.getAttribute("data-prototype");
  let newForm = prototype.replace(/__question_prototype__/g, index);

  const newFormLi = document.createElement("li");
  newFormLi.innerHTML = newForm;
  collectionHolder.appendChild(newFormLi);
  removeUnwantedLabels();
  // Ajoute un bouton spécifique pour ajouter des réponses à cette question
  addAddResponseButton(newFormLi, index);
  removeUnwantedLabels();
}

function addResponseForm(questionLi, questionIndex) {
  removeUnwantedLabels();
  changeLabelColors();

  const responseContainer = questionLi.querySelector(".reponse-container");
  if (!responseContainer) return;

  const prototype = responseContainer.getAttribute("data-prototype");
  const index = responseContainer.querySelectorAll(".reponse").length;
  let newForm = prototype.replace(/__reponse_prototype__/g, index);

  const responseDiv = document.createElement("div");
  responseDiv.className = "reponse";
  responseDiv.innerHTML = newForm; // Add the response form to the HTML
  removeUnwantedLabels();
  responseContainer.appendChild(responseDiv);
}

function addAddResponseButton(questionLi, questionIndex) {
  removeUnwantedLabels();
  const addButton = document.createElement("button");
  addButton.type = "button";
  //addButton.className = "btn add-response-btn";
  addButton.textContent = "Add Response";
  addButton.className = "btn";

  questionLi.appendChild(addButton);

  addButton.addEventListener("click", function () {
    addResponseForm(questionLi, questionIndex);
  });
}
document.addEventListener("DOMContentLoaded", function () {
  setupFormSubmissionCheck();
  removeUnwantedLabels2();
  removeUnwantedLabels();
  setupDynamicQuestions();
});

function setupDynamicQuestions() {
  const collectionHolder = document.querySelector(".question-list");
  if (!collectionHolder) {
    return; // Exit if the .question-list element isn't found
  }
  const buttonGroup = document.querySelector(".button-group");

  const addButton = document.createElement("button");
  addButton.type = "button";
  addButton.className = "btn add-question-btn";
  addButton.textContent = "Add Question";
  buttonGroup.insertBefore(addButton, buttonGroup.childNodes[0]); // Adds the button before the submit button

  let index = collectionHolder.children.length;
  addButton.addEventListener("click", function () {
    addQuestionForm(collectionHolder, index++);
  });
}

function removeUnwantedLabels() {
  document.querySelectorAll("label.required").forEach(function (label) {
    if (
      label.textContent.trim() === "0label__" ||
      label.textContent.trim() === "1label__" ||
      label.textContent.trim() === "2label__" ||
      label.textContent.trim() === "3label__" ||
      label.textContent.trim() === "4label__" ||
      label.textContent.trim() === "5label__" ||
      label.textContent.trim() === "6label__" ||
      label.textContent.trim() === "7label__" ||
      label.textContent.trim() === "8label__" ||
      label.textContent.trim() === "9label__"
    ) {
      label.remove(); // Removes the unwanted label from the DOM
    }
  });
}

function removeUnwantedLabels2() {
  document.querySelectorAll("label.required").forEach(function (label) {
    if (label.textContent.trim() === "Questions") {
      label.remove();
    }
  });
}

function addQuestionForm(collectionHolder, index) {
  const prototype = collectionHolder.getAttribute("data-prototype");
  let newForm = prototype.replace(/__question_prototype__/g, index);

  const newFormLi = document.createElement("li");
  newFormLi.innerHTML = newForm;
  collectionHolder.appendChild(newFormLi);
  removeUnwantedLabels();
  // Add a specific button to add responses to this question
  addAddResponseButton(newFormLi, index);
  removeUnwantedLabels();
}

function addResponseForm(questionLi, questionIndex) {
  removeUnwantedLabels();

  const responseContainer = questionLi.querySelector(".reponse-container");
  if (!responseContainer) return;

  const prototype = responseContainer.getAttribute("data-prototype");
  const index = responseContainer.querySelectorAll(".reponse").length;
  let newForm = prototype.replace(/__reponse_prototype__/g, index);

  const responseDiv = document.createElement("div");
  responseDiv.className = "reponse";
  responseDiv.innerHTML = newForm; // Add the response form to the HTML
  removeUnwantedLabels();
  responseContainer.appendChild(responseDiv);
}

function addAddResponseButton(questionLi, questionIndex) {
  removeUnwantedLabels();
  const addButton = document.createElement("button");
  addButton.type = "button";
  //addButton.className = "btn add-response-btn";
  addButton.textContent = "Add Response";
  addButton.className = "btn";

  questionLi.appendChild(addButton);

  addButton.addEventListener("click", function () {
    addResponseForm(questionLi, questionIndex);
  });
}
