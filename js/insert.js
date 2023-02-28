let input_price_tag = document.getElementById('item_price');
let input_name_tag = document.getElementById('item_name');
let input_category_tag = document.getElementById('item_category');
let item_id_param = document.getElementById('item_id');
let date_tag = document.getElementById('date');

let dom_dd = document.getElementById('dd');
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
    // input_name_tag.setAttribute('value', item.name);
    // console.log(item);
    item_id_param.setAttribute('value', item.id);
    input_price_tag.setAttribute('value', item.price);
    input_category_tag.value = item['cat_id'];
}

date_tag.addEventListener('change', function (e) {
    updateDate(e.target.value);
}) 

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
async function getItem(id) {
    let url = "http://localhost:8080/api/get-one-api.php?selected=item&id=" + id;
    let myObject = await fetch(url);
    let item = await myObject.json();
    return item;
}

async function coffee(e) {
    let suggestions = document.getElementById('suggestionMenu').options;
    let inputValue = e.target.value;
    for(let i = 0; i < suggestions.length; i++) {
        let suggestion = suggestions[i];
        if (inputValue == suggestion.value) {
            let item_id = suggestion.dataset.itemid;
            let item = await getItem(item_id);
            DOMSelectItem(item);
            console.log(item);
            console.log(item_id_param);
        }
    }
}

async function addAutocomplete() {
    input_name_tag.addEventListener('input', coffee)
}
addAutocomplete();


// async function getItems() {
//     let url = "http://localhost:8080/api/get-many-api.php?selected=item";
//     let myObject = await fetch(url);
//     let items = await myObject.json();
//     return items;
// }

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
/*

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

async function drawSuggestions(suggestions, root) {
    _clearSuggestions();
    let menu = document.createElement('div');
    menu.setAttribute('id', 'menu');
    root.parentNode.appendChild(menu);
    for (let i = 0; i < suggestions.length; i ++) {
        let suggestion_div = document.createElement('div');
        suggestion_div.setAttribute('class', 'suggestion');
        suggestion_div.setAttribute('id', 'suggest-' + suggestions[i].id);
        suggestion_div.innerHTML = suggestions[i].name;
        suggestion_div.addEventListener('click', function(e) {
            console.log(e);
        });
        menu.appendChild(suggestion_div);
    }
}

function _clearSuggestions() {
    let menu = document.getElementById('menu');
    if (menu != null) {
        menu.remove();
    }
}
*/