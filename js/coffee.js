function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function (e) {
    var inputE1,
      inputE2,
      inputE3,
      val = this.value;
    /*close any already open lists of autocompleted values*/
    closeAllLists();
    if (!val) {
      // if there is no value, stop processing
      return false;
    }
    currentFocus = -1;
    /*create a DIV element that will contain the items (values):*/
    inputE1 = document.createElement("DIV");
    inputE1.setAttribute("id", this.id + "autocomplete-list");
    inputE1.setAttribute("class", "autocomplete-items");
    // set the inputE1 as the input drop down element
    /*append the DIV element as a child of the autocomplete container:*/
    this.parentNode.appendChild(inputE1);
    /*for each item in the array...*/
    for (inputE3 = 0; inputE3 < arr.length; inputE3++) {
      /*check if the item starts with the same letters as the text field value:*/
      if (
        // we are using E2 as the builder for suggestion
        arr[inputE3].substr(0, val.length).toUpperCase() == val.toUpperCase()
      ) {
        /*create a DIV element for each matching element:*/
        inputE2 = document.createElement("DIV");
        /*make the matching letters bold:*/
        inputE2.innerHTML =
          "<strong>" + arr[inputE3].substr(0, val.length) + "</strong>";
        inputE2.innerHTML += arr[inputE3].substr(val.length);
        /*insert a input field that will hold the current array item's value:*/
        inputE2.innerHTML +=
          "<input type='hidden' value='" + arr[inputE3] + "'>";
        /*execute a function when someone clicks on the item value (DIV element):*/
        inputE2.addEventListener("click", function (e) {
          /*insert the value for the autocomplete text field:*/
          inp.value = this.getElementsByTagName("input")[0].value;
          /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
          closeAllLists();
        });
        inputE1.appendChild(inputE2);
      }
    }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function (e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");
    if (e.keyCode == 40) {
      /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
      currentFocus++;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 38) {
      //up
      /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
      currentFocus--;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 13) {
      /*If the ENTER key is pressed, prevent the form from being submitted,*/
      e.preventDefault();
      if (currentFocus > -1) {
        /*and simulate a click on the "active" item:*/
        if (x) x[currentFocus].click();
      }
    }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
    closeAllLists(e.target);
  });
}

var dd = document.getElementById("item_dd");
dd.addEventListener("input", function (e) { });
autocomplete(document.getElementById("item_dd"), [
  "coffee",
  "sip",
  "flavour",
  "ybs",
]);
