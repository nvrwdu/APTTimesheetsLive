alert("linked");

let i = 3;
document.getElementById('add-new-person').onclick = function () {
    let template = `
        <h3>Person ${i}:</h3>
        <p>
            <label>First name</label><br>
            <input name="people[${i}][first_name]">
        </p>

        <p>
            <label>Last name</label><br>
            <input name="people[${i}][last_name]">
        </p>

        <p>
            <label>Email</label><br>
            <input name="people[${i}][email]">
        </p>`;

    let container = document.getElementById('people-container');
    let div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div);

    i++;
}
