

let i = 2;
document.getElementById('btn-add-new-planned-synthetic').onclick = function () {

    let template = `
                Synthetic <input type="text" name="plannedsynthetic[${i}]['plannedsynthetic']" value="<?php echo $plannedSynthetics[${i}][0]; ?>">
                Quantity <input type="text" name="plannedsynthetic[${i}]['quantity']" value="<?php echo $plannedSynthetics[${i}][1]; ?>"><br>
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
            Synthetic <input type="text" name="unplannedsynthetic[${i}]['unplannedsynthetic']" value="<?php echo $unplannedSynthetics[${i-1}][0]; ?>">
            Quantity <input type="text" name="unplannedsynthetic[${i}]['quantity']" value="<?php echo $unplannedSynthetics[${i-1}][1]; ?>">
            <textarea id="textarea-unplanned-work-comments-box" name="unplannedsynthetic[${i-1}]['comments']" placeholder="Comments"><?php echo $unplannedSynthetics[0][2]; ?></textarea>
            <br>
    `;

    let container = document.getElementById('unplanned-synthetics-container');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    j++;
}


