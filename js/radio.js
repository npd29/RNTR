//initialized on multiStepForm.js

function adjustRadio(x, y) {
  let elements = document.getElementsByClassName(x);
  for (let i = 0; i < elements.length; i++) {
    if (elements[i].id === y) {
      elements[i].checked = true;
      elements[i].parentElement.style.backgroundColor = "white";
      elements[i].nextElementSibling.style.color = "var(--purple)";

    } else {
      elements[i].parentElement.style.background = "0";
      elements[i].nextElementSibling.style.color = "white";
      elements[i].checked = false;
    }
  }
}

function checkRadio(x) {
  let elements = document.getElementsByClassName(x);
  for (let i = 0; i < elements.length; i++) {
    if (elements[i].checked) {
      elements[i].parentElement.style.backgroundColor = "white";
      elements[i].nextElementSibling.style.color = "var(--purple)";

    } else {
      elements[i].parentElement.style.background = "0";
      elements[i].nextElementSibling.style.color = "white";
    }
  }
}
