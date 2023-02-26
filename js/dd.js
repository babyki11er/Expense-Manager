let dom_dd = document.getElementById('dd');
let dom_search_bar = document.getElementById('search-bar');
async function getItems() {
  let url = "http://localhost:8080/api/get-many-api.php?selected=item";
  let myObject = await fetch(url);
  let items = await myObject.json();
  return items;
}
async function setInputListener() {
  let data = await getItems();
  dom_search_bar.addEventListener('input', function(e) {
    let search_query = e.target.value;
    let find_me = search_query.toLowerCase();
    let filtered = data.filter(function(value, index) {
      suggestion = value.name.toLowerCase();
      return suggestion.indexOf(find_me) >= 0;
    });
    drawSuggestions(filtered, dom_dd);
  })
}
setInputListener();