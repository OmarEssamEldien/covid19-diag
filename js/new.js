const fetch = document.getElementById("fetch");
const user = document.getElementById("user");
const users = document.getElementById("users");
const proto = document.getElementById("proto");
const row = document.getElementById("row");
let userData = document.querySelectorAll(".user_data");
let fetchItem = '';
let deleteItem = '';
let editItem = '';
let count = true;
let newData;
let itemId = '';
let ID = '';
let username = '';
let gender = '';
let dob = '';
let job = '';
let address = '';
let email = '';
let phone_num = '';
let social_status = '';
let ssn = '';
let no_of_kids = '';
let coordinates = '';
let role_id = '';
let vaccination_type = '';
let editButton = ''
// fetch all data in DB.
$.ajax({
    url: "https://co-cvoid-19.me/api/users",
    type: 'POST',
    data: {
        "action": "fetch",
    }
})
    .done((response) => {
        newData = response;
        len = newData.data.length;
        for (let i = 0; i < len; i++) {
            let div = document.createElement('div');
            div.innerHTML = `
            <div class="user_data">
                <div class="title">
                    <div class="id">${newData.data[i].ID}</div> 
                    <div class="username">${newData.data[i].username}</div>
                    <div class="edit" data-edit-id="${newData.data[i].ID}">edit</div>
                    <div class="delete" data-id="${newData.data[i].ID}">delete</div>
                    <div class="fetch" id="${newData.data[i].ID}">fetch</div>
                </div>
            </div>
            `
            user.appendChild(div)
        }

        userData = document.querySelectorAll(".user_data");
        fetchItem = document.querySelectorAll('.fetch');
        deleteItem = document.querySelectorAll('.delete');
        editItem = document.querySelectorAll('.edit');
        fetchItem.forEach(element => {
            element.setAttribute("data-boolean", true);
            element.addEventListener('click', () => {
                fetchUserData(element);
                element.setAttribute("data-boolean", 'false');
            });
        });

        editItem.forEach(element => {
            element.addEventListener('click', () => {
                let parent = element.parentNode;
                alert("Hello");
                console.log(parent)
            });

            deleteItem.forEach(element => {
                element.setAttribute("data-delete", false);
                element.addEventListener('click', () => {
                    deleteUserData(element);
                    element.setAttribute("data-delete", 'true');

                });
            });
        });









