let dd = document.getElementById("dd");
// TODO
// makes search case insensitive
// margin 0, border 0, relative postion

let arr = ["coffee", "tea", "beer", "wine"];

function dropdown(items) {
  dd.addEventListener("input", function (e) {
    let text = e.target.value;
    clearList();
    let suggestions = filter(text, items);
    createList(suggestions);
  });
}

function clearList() {
  let ul = document.getElementById("list");
  if (ul !== null) ul.remove();
}

function createList(arr) {
  let dd = document.getElementById("dd");
  let ul = document.createElement("ul");
  ul.setAttribute('position', 'relative');
  ul.setAttribute("id", "list");
  for (let i = 0; i < arr.length; i++) {
    let li = document.createElement("li");
    li.innerHTML = "<strong>" + arr[i].name + "</strong>";
    ul.appendChild(li);
  }
  dd.appendChild(ul);
  console.log("done creating the list");
}

async function getItems() {
  let url = "http://localhost:8080/get-api.php?attr=item";
  let myObject = await fetch(url);
  let items = await myObject.json();
  dropdown(items);
}
function filter(text, arr) {
  let r = arr.filter(function (item, i) {
    return item.name.search(text) >= 0;
  });
  return r;
}
getItems();

// dd.addEventListener("input", function (e) {
//   if (!this.value) {
//     return false;
//   }
//   let iText = this.value;
//   // creating a div elm that will contain the drop down items
//   let dropdownMenu = document.createElement("ul");
//   dropdownMenu.setAttribute("class", " dropdown-menu");
//   this.appendChild(dropdownMenu);
//   let arr = ["shit", "coffee", "pizza"];
//   for (let i = 0; i < arr.length; i++) {
//     let dropdownItem = document.createElement("li");
//     dropdownItem.innerHTML = "<strong> " + arr[i] + " </strong>";
//     dropdownItem.setAttribute("class", "dropdown-item");
//     dropdownMenu.appendChild(dropdownItem);
//   }
// });
