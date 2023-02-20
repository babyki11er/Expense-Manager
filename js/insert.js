let input_name_tag = document.getElementById('item_name');
let input_price_tag = document.getElementById('item_price');
let input_category_tag = document.getElementById('item_category');
let date_tag = document.getElementById('date');

let dom_dd = document.getElementById('dd');
async function getItems() {
    let url = "http://localhost:8080/api/get-many-api.php?selected=item";
    let myObject = await fetch(url);
    let items = await myObject.json();
    return items;
}
async function setInputListener(dom_search_bar) {
    dom_search_bar.setAttribute('autocomplete', 'off');
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
setInputListener(input_name_tag);

date_tag.addEventListener('change', function (e) {
    updateDate(e.target.value);
}) 
/*
    SessionStorage:
        today:  (to remember what the user has previously selected)
*/

if (_getSelectedDate() === null) {
    _setSelectedDate(date_tag.value);
} else {
    date_tag.value = _getSelectedDate();
}

/* DOOM manipulation */
function DOMSelectItem(item) {
    let cat_id = item['cat_id'];
    if (cat_id == 0) {
    }
    input_name_tag.setAttribute('value', item.name);
    input_price_tag.setAttribute('value', item.price);
    input_category_tag.value = item['cat_id'];
}

/* sessionStorage getter and setter */
function _getSelectedDate() {
    return sessionStorage.getItem('today');
}

function _setSelectedDate(chosen_date) {
    sessionStorage.setItem('today', chosen_date);
}

function updateDate() {
    if (_getSelectedDate() !== date_tag.value) {
        _setSelectedDate(date_tag.value);
    }
}

// let select_e = document.getElementById('selected-item');

// /* event listeners */
// select_e.addEventListener('change', function (e) {
//     let selected_item_id = e.currentTarget.value;
//     fetch_item_url = 'api/get-one-api.php?selected=category&id=' + selected_item_id;
    
//     /* AJAX */
//     fetch(fetch_item_url)
//         .then((response) => response.json())
//         .then((item_data) => {
//             console.log('done fetching the item.');
//             DOMSelectItem(item_data);
//         })
// })