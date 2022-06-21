const fetch = document.getElementById("fetch");
const user = document.getElementById("user");
const users = document.getElementById("users");
const proto = document.getElementById("proto");
const row = document.getElementById("row");
const action = "add";
const username = document.getElementById('username');
const password = document.getElementById('password');
const gender = document.querySelectorAll('[name=gender]');
const socialStatus = document.querySelectorAll('[name=social-status]');
let socialStatusVal = ''
let genderVal = ''
let numKidsOPtion = document.querySelector('.sec-kids-opt')
const dateOfBirth = document.querySelector('#date_of_birth').value;
const job = document.getElementById('job');
const phone = document.getElementById('phone');
const nKids = document.getElementById('nkids');
const address = document.getElementById('address_2');
const email = document.getElementById('email');
const ID = document.getElementById('ID');
const roleID = document.getElementById('role_id');
const cordinats = document.getElementById('cordinats');
const vaccination = document.querySelector('#vaccination');
const roles = document.querySelector('#roles');
const register = document.getElementById('register');
let userData = document.querySelectorAll(".user_data");
let fetchItem = '';
let deleteItem = '';
let editItem = '';
let count = true;
let newData;
let itemId = '';
let data = '';
let dataForm = {};
let roleValue = 4; 
let editButton = document.createElement('input');
let fetchresult = false; 
let fetchProcessPreventLoad = false; 
editButton.setAttribute('class', 'edit_data_button');
editButton.setAttribute('id', 'edit_data_button');
editButton.setAttribute('type', 'button');
editButton.setAttribute('value', 'تعديل البيانات');
 
document.querySelector('#add_new_user').addEventListener('click',()=>{
    document.querySelector('form#form').classList.toggle('form_toggle')
})
register.addEventListener("click", () => {
    switch(roles.value){
        case "supervisor": roleValue = 1;
        break;
        case "radiologist": roleValue = 2;
        break;
        case "doctor": roleValue = 3;
        break;
        case "patient": roleValue = 4;
        break;        
        case "paramedic": roleValue = 5;
        break;
    }
    alert (roles)
    gender.forEach(radio => {
        if (radio.checked) {
          if(radio.value == "male"){
            genderVal = "M"
          }else if (radio.value == "female"){
            genderVal = "F"
          }
          alert(radio.value)
          // radio.value == "male" ? genderVal.value = "M" : genderVal.value == "F" ? genderVal.value = "F" : "";
        }
      })
      socialStatus.forEach(radio => {
        radio.checked ? socialStatusVal = radio.value:"";
        radio.value == 'single' ? numKidsOPtion.style.display = 'none' : '';
      })
    formRegister = {
      action: action,
      username: username.value,
      password: password.value,
      gender: genderVal,
      socialStatus: socialStatusVal,
    //   dob: dateOfBirth,
      job: job.value,
      phone_num: phone.value,
      numberOfKids: nKids.value,
      address: address.value,
      email: email.value,
      ssn: ID.value,
      coordinates: cordinats.value,
      vaccinationType: vaccination.value, 
      role_id: roleValue
    };
 
    form(formRegister)
 
  });
 
  function form(data) {
    $.ajax({
      url: "https://co-cvoid-19.me/api/users",
      type: 'POST',
      data: data,
      success: (response) => {
        if (response.success){
          !confirm("تم انشاء حسابك بنجاح, هل تريد تسجيل حساب جديد!! ")?window.location.href="./login.html":"";
        }else if(response.error) {
          response.details ? alert(`يرجي التاكد من كتابة البيانات بطريقة صحيحة واعدة المحاولة مرة اخرى.
          please write  "${response.details}" in right way and try again `) :  alert(`يرجي التاكد من كتابة البيانات بطريقة صحيحة واعدة المحاولة مرة اخرى.
         ${response.error} `);
 
        }
        console.log(response)
      }
    })
  }
 
 
 
 
document.querySelector('#show_all_users').addEventListener('click', () => {
    user.innerHTML = '';
    !fetchProcessPreventLoad?fetchAllData():""
    fetchProcessPreventLoad?fetchProcessPreventLoad = false : true
    user.classList.toggle('toggle_all_users')
});
// fetch all data in DB.
function fetchAllData() {
    $.ajax({
        url: "https://co-cvoid-19.me/api/users",
        type: 'POST',
        data: {
            "action": "fetch",
        }, 
        success: (response) => {
            fetchresult = true; 
            console.log(response)
            fetchProcessPreventLoad = true; 
            newData = response;
            len = newData.data.length;
            for (let i = 0; i < len; i++) {
                let div = document.createElement('div');
                div.innerHTML = `
                <div class="user_data">
                    <div class="title">
                    <div class="username">${newData.data[i].username}</div>
                    <div class="id">${newData.data[i].ID}</div> 
                        <div class="delete" data-id="${newData.data[i].ID}">delete</div>
                        <div class="fetch" id="${newData.data[i].ID}">Show / Edit</div>
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
                deleteItem.forEach(element => {
                    element.setAttribute("data-delete", false);
                    element.addEventListener('click', () => {
                        deleteUserData(element);
                        element.setAttribute("data-delete", 'true');
 
                    });
                });
            });
 
        }
    })
        .done((response) => {
 
 
 
        });
 
    function fetchUserData(userID) {
        let title = userID.parentNode;
        let header = title.parentNode;
        let ID = userID.getAttribute('id');
        let dataBoolean = userID.getAttribute('data-boolean');
        $.ajax({
            url: "https://co-cvoid-19.me/api/users",
            type: 'POST',
            data: {
                "action": "fetch",
                "user_id": ID
            },
            success: (response) => {
                if (dataBoolean == 'true') {
                    newData = response;
                    if (newData.success) {
                        for (let i = 0; i < newData.data.length; i++) {
                            let divcontainer = document.createElement('div');
                            divcontainer.setAttribute('class', "data")
                            for (let property in newData.data[i]) {
                                let div = document.createElement('div');
                                div.classList.add("data-row")
                                div.innerHTML = `<p class="properity">${property}</p> <p><input value="${newData.data[i][property]}" class="input-field" id='${property}_${newData.data[i].ID}'/></p>`
                                console.log(`${property} ${newData.data[i][property]}`)
                                divcontainer.appendChild(div)
                            }
                            let div = document.createElement('div');
                            div.classList.add("data-row")
                            div.innerHTML = `<p class="properity">password</p> <p><input value="" class="input-field" id='password_${newData.data[i].ID}' type='password'/></p>`
                            divcontainer.appendChild(div)
                            divcontainer.appendChild(editButton);
                            header.appendChild(divcontainer);
 
                        }
                        editButton.addEventListener('click', () => {
                            getValue(ID)
                            $.ajax({
                                url: "https://co-cvoid-19.me/api/users",
                                type: 'POST',
                                data: dataForm,
                                success: (res) => {
                                    console.log(res);
                                    alert('Data has been Changed')
                                }
                            })
                        })
                    }
 
                }
            },
 
        })
            .done(() => {
                let titleParetnt = title.parentNode;
                data = titleParetnt.lastElementChild;
                data.classList.toggle('data-collapse');
            });
 
    }
 
 
    function deleteUserData(userID) {
        let ID = Number(userID.getAttribute('data-id'))
        let deleteditm = userID.parentNode;
        let dataDelete = userID.getAttribute('data-delete');
        if (dataDelete == 'false') {
            $.ajax({
                url: "https://co-cvoid-19.me/api/users",
                type: 'POST',
                data: {
                    "action": "delete",
                    "user_id": ID
                },
                success: (response) => {
                    newData = response;
                }
            })
                .done(() => {
                    deleteditm.remove();
                });
        }
 
    }
 
    function getValue(dataID) {
        let ID = document.querySelector(`#ID_${dataID}`).value
        let username = document.querySelector(`#username_${dataID}`).value
        let gender = document.querySelector(`#gender_${dataID}`).value
        // let dob = document.querySelector(`#date_of_birth${dataID}`).value
        let job = document.querySelector(`#job_${dataID}`).value
        let address = document.querySelector(`#address_${dataID}`).value
        let email = document.querySelector(`#email_${dataID}`).value
        let phone_num = document.querySelector(`#phone_num_${dataID}`).value
        let social_status = document.querySelector(`#social_status_${dataID}`).value
        let ssn = document.querySelector(`#ssn_${dataID}`).value
        let no_of_kids = document.querySelector(`#no_of_kids_${dataID}`).value
        let coordinates = document.querySelector(`#coordinates_${dataID}`).value
        let role_id = document.querySelector(`#role_id_${dataID}`).value
        let vaccination_type = document.querySelector(`#vaccination_type_${dataID}`).value
        let password = document.querySelector(`#password_${dataID}`).value
        dataForm = {
            action: "edit",
            user_id: ID,
            username: username,
            gender: gender,
            // dob: dob,
            job: job,
            address: address,
            email: email,
            phone_num: phone_num,
            password: password,
            social_status: social_status,
            ssn: ssn,
            no_of_kids: no_of_kids,
            coordinates: coordinates,
            role_id: role_id,
            vaccination_type: vaccination_type
        }
        console.log(ID, username, gender,/*dob,*/ job, address, email, phone_num, social_status, ssn)
    }
 
}
let toggleSearchBox = document.querySelector('#search_box'); 
let toggleSearchBox2 = document.querySelector('.specific_search_result')
document.getElementById('search_button').addEventListener('click',()=>{
    search_box.classList.toggle('toggle_search_box')
    toggleSearchBox.classList.remove('toggle_height_for_second')
    toggleSearchBox2.classList.remove('specific_search_result_toggle')
    hasClass(toggleSearchBox,'toggle_height_for_second')?toggleSearchBox.classList.remove('toggle_height_for_second'):'';  
});
let classIsFounded = true;
document.querySelector('#show_search').addEventListener('click',()=>{
    if(classIsFounded){
        document.querySelector('.toggle_search_box').classList.toggle('toggle_height_for_second');  
        document.querySelector('.specific_search_result').removeAttribute('data-switch')
    }else {
        document.querySelector('.toggle_search_box').classList.toggle('toggle_height_for_second');  
        document.querySelector('.specific_search_result').setAttribute('data-switch','true')
    }
    classIsFounded = document.querySelector('.specific_search_result').hasAttribute("data-switch");
    document.querySelector('.specific_search_result').classList.toggle('specific_search_result_toggle');
})
 
 
//check if element have aclass '......'
      function hasClass(element, clsName) {
        return(' ' + element.className + ' ').indexOf(' ' + clsName + ' ') > -1;
      }