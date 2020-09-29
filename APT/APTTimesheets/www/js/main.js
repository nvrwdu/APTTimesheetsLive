

let i = 2;
document.getElementById('btn-add-new-planned-synthetic').onclick = function () {

    let template = `
                Synthetic <input type="text" name="plannedsynthetic[${i}]['plannedsynthetic']">
                Quantity <input type="text" name="plannedsynthetic[${i}]['quantity']"><br>
    `;

    let container = document.getElementById('planned-synthetics-container');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    i++;
}


let j = 2;
document.getElementById('btn-add-new-unplanned-synthetic').onclick = function () {
    let template = `
            Synthetic <input type="text" name="unplannedsynthetic[${j}]['unplannedsynthetic']">
            Quantity <input type="text" name="unplannedsynthetic[${j}]['quantity']">
            <textarea id="textarea-unplanned-work-comments-box" name="unplannedsynthetic[${j}]['comments']" placeholder="Comments"></textarea>
            <br>
    `;

    let container = document.getElementById('unplanned-synthetics-container');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    j++;
}


