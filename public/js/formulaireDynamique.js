/*document.addEventListener("DOMContentLoaded", function () {
  const collectionHolder = document.querySelector(".question-list");
  const addButton = document.createElement("button");
  addButton.textContent = "Add Question";
  addButton.type = "button";
  addButton.classList.add("add-question-btn");

  // Append the add button to the questions container, not directly to the DOM yet
  let container = document.querySelector(".question-list-container");
  container.appendChild(addButton);

  addButton.addEventListener("click", () => {
    const prototype = collectionHolder.getAttribute("data-prototype");
    const index = collectionHolder.children.length;
    let newForm = prototype.replace(/__name__/g, index);
    const newFormLi = document.createElement("li");
    newFormLi.innerHTML = `${newForm}`;
    collectionHolder.appendChild(newFormLi);

    // Add response button for each question
    const addResponseButton = document.createElement("button");
    addResponseButton.textContent = "Add Response";
    addResponseButton.type = "button";
    addResponseButton.classList.add("add-response-btn");
    newFormLi.appendChild(addResponseButton);

    // Apply CSS class to the new form elements
    newFormLi.classList.add("form-group"); // Add form-group class to the new question

    const responseList = newFormLi.querySelector(".response-list");
    if (responseList) {
      responseList.classList.add("form-control"); // Add form-control class to the response list
    }

    addResponseButton.addEventListener("click", () => {
      const responsesContainer = newFormLi.querySelector(".response-list");
      const responsePrototype =
        responsesContainer.getAttribute("data-prototype");
      const responseIndex = responsesContainer.children.length;
      let newResponseForm = responsePrototype.replace(
        /__name__/g,
        responseIndex
      );

      // Ensure __reponse_prototype__label__ is not included in the new response form
      newResponseForm = newResponseForm.replace(
        "__reponse_prototype__label__",
        ""
      );

      const newResponseLi = document.createElement("li");
      newResponseLi.innerHTML = newResponseForm;
      responsesContainer.appendChild(newResponseLi);

      // Apply CSS class to the new response elements
      newResponseLi.classList.add("form-group"); // Add form-group class to the new response
    });
  });
});

/*document.addEventListener("DOMContentLoaded", function () {
  setupDynamicQuestions();
});

function setupDynamicQuestions() {
  const collectionHolder = document.querySelector(".question-list");
  if (!collectionHolder) {
    return; // Exit if the .question-list element isn't found
  }

  const addButton = document.createElement("button");
  addButton.type = "button";
  addButton.className = "btn add-question";
  addButton.textContent = "Add Question";

  // Insert the add button directly after the question list
  collectionHolder.parentNode.insertBefore(
    addButton,
    collectionHolder.nextSibling
  );

  let index = collectionHolder.children.length; // Current number of questions

  addButton.addEventListener("click", function (e) {
    addQuestionForm(collectionHolder, index);
    index++;
  });
}

function addQuestionForm(collectionHolder, index) {
  const prototype = collectionHolder.getAttribute("data-prototype");
  let newForm = prototype.replace(/__question_prototype__/g, index);

  const newFormLi = document.createElement("li");
  newFormLi.innerHTML = newForm;
  collectionHolder.appendChild(newFormLi);
}*/

document.addEventListener("DOMContentLoaded", function () {
  setupDynamicQuestions();
});

function setupDynamicQuestions() {
  const collectionHolder = document.querySelector(".question-list");
  if (!collectionHolder) {
    return; // Exit if the .question-list element isn't found
  }

  const addButton = document.createElement("button");
  addButton.type = "button";
  addButton.className = "btn add-question";
  addButton.textContent = "Add Question";

  // Insert the add button directly after the question list
  collectionHolder.parentNode.insertBefore(
    addButton,
    collectionHolder.nextSibling
  );

  let index = collectionHolder.children.length; // Current number of questions

  addButton.addEventListener("click", function (e) {
    addQuestionForm(collectionHolder, index);
    index++;
  });
}

function addQuestionForm(collectionHolder, index) {
  const prototype = collectionHolder.getAttribute("data-prototype");
  let newForm = prototype.replace(/__question_prototype__/g, index);

  const newFormLi = document.createElement("li");
  newFormLi.innerHTML = newForm;
  collectionHolder.appendChild(newFormLi);

  // Dynamically add response input field
  const responseInput = document.createElement("input");
  responseInput.type = "text";
  responseInput.name = "question_responses[" + index + "][0]"; // Each question starts with response index 0
  responseInput.placeholder = "Enter response";
  newFormLi.appendChild(responseInput);

  // Add button to dynamically add more response inputs
  const addResponseButton = document.createElement("button");
  addResponseButton.type = "button";
  addResponseButton.textContent = "Add Response";
  addResponseButton.classList.add("response-list");

  addResponseButton.addEventListener("click", function () {
    addResponseInput(newFormLi, index);
  });
  newFormLi.appendChild(addResponseButton);
}

function addResponseInput(formLi, index) {
  const responseInputs = formLi.querySelectorAll(
    'input[name^="question_responses[' + index + ']"]'
  );
  const nextResponseIndex = responseInputs.length; // Get the index for the next response input

  const responseInput = document.createElement("input");
  responseInput.type = "text";
  responseInput.name =
    "question_responses[" + index + "][" + nextResponseIndex + "]";
  responseInput.placeholder = "Enter response";
  formLi.insertBefore(responseInput, formLi.lastChild); // Insert before the last child (add response button)
}
