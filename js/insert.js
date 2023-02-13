let input_name_tag = document.getElementById('item-name');
let input_price_tag = document.getElementById('item-price');
let input_category_tag = document.getElementById('item-category');
let date_tag = document.getElementById('date');


// if today is not set,
//      set today to the value
// if it's set,
//      set date value to today
//      if date value is updated, update the today as well

/*
    SessionStorage:
        today:  (to remember what the user has previously selected)
*/
function _getSelectedDate() {
    return sessionStorage.getItem('today');
}

function _setSelectedDate(chosen_date) {
    sessionStorage.setItem('today', chosen_date);
}

function initDate() {
    if (_getSelectedDate() === null) {
        _setSelectedDate(date_tag.value);
    } else {
        date_tag.value = _getSelectedDate();
    }
}

function updateDate() {
    if (_getSelectedDate() !== date_tag.value) {
        _setSelectedDate(date_tag.value);
    }
}
function selectItem(item) {
    let cat_id = item['cat-id'];
    if (cat_id == 0) {
    }
    input_name_tag.setAttribute('value', item.name);
    input_price_tag.setAttribute('value', item.price);
    input_category_tag.value = item['cat-id'];
}

initDate();
let select_e = document.getElementById('selected-item');
select_e.addEventListener('change', function (e) {
    let selected_item_id = e.currentTarget.value;
    fetch_item_url = 'api/js-api.php?id=' + selected_item_id;
    fetch(fetch_item_url)
        .then((response) => response.json())
        .then((item_data) => {
            console.log('done fetching the item.');
            selectItem(item_data);
        })
})

date_tag.addEventListener('change', function (e) {
    updateDate(e.target.value);
})