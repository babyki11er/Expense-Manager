let input = document.createElement('input');
let cancel = document.createElement('button');
let edit_mode = false;
var coffee = "";
input.setAttribute('type', 'text');
input.className = " col-2 col-md-4";
cancel.className = " btn btn-danger";
cancel.innerHTML = "Cancel";
let rename = document.querySelectorAll('.rename');
for (let but of rename) {
    but.addEventListener('click', function (e) {
		let id = "label-" + e.target.value.toString();
		let label = document.getElementById(id);
        if (edit_mode) {
			input.replacewith(label);
            e.target.className = "btn btn-warnning";
			edit_mode = false;
        } else {
            e.target.className = "btn btn-success";
            label.replaceWith(input);
            edit_mode = true;
            e.target.parentElement.appendChild(cancel);
        }
    })
}

cancel.addEventListener('click', function (e) {

})
