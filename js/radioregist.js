// function trueOrFalse(item) {
//     if(item.value) {
//         alert("hello")
//     }
// }
// let item = ''
let result = document.querySelector('.select_data_showing')
let data = ''
let patient = document.querySelector('#patient')
let doctor = document.querySelector('#doctor')
let date = document.querySelector('#infection_date')
let add = document.querySelector('#add_patient');
let obj = ''
let files = ''
let fetchButton = ''
// let selectPatient = document.querySelector('#')
add.addEventListener('click', () => {
    var patientValue = patient.options[patient.selectedIndex];
    var doctorValue = doctor.options[doctor.selectedIndex];
    obj = {
        action: "add",
        patient_id: patientValue.getAttribute('data-attr'),
        doctor_id: doctorValue.getAttribute('data-attr'),
        infection_date: date.value
    }
    $.ajax({
        url: "https://co-cvoid-19.me/api/infected",
        type: 'POST',
        data: obj,
        success: (response) => {
            response.success?alert(`تمت اضافة المريض بشكل صحيح `):alert(`يرجي التاكد من البنات قبل عملية الاضافة 

            ${response.error}`);
            console.log(response)
        }
    })
})

$.ajax({
    url: "https://co-cvoid-19.me/api/infected",
    type: 'POST',
    data: {
        "action": "fetch"
    },
    success: (response) => {
        console.log(response)

    }
})
    .done((response) => {
        data = response;
        console.log(data)
        createEle(data);
        // files.forEach(file => {

        // });

    })

function createEle(par) {
    result.innerHTML = '';
    for (let i = 0; i < par.data.length; i++) {
        // console.log(par.data[i])
        let div = document.createElement('div');
        div.innerHTML = `
    <div class="user_data">
        <div class="descreption">
            <div class="username">${par.data[i].patient}</div>
            <div class="id">${par.data[i].infection_date}</div> 
            <div class="delete" data-id="${par.data[i].ID}">delete</div>
            
            <form class="form-file" id="form_${par.data[i].ID}">
            <input type="file" name="ct_scans[]" class="ct_scan" data-file="${par.data[i].ID}" accept=".dcm" multiple/>
            <input type="hidden" name="infected_id" class="patient_id_hidden" value="${par.data[i].ID}"/>
            <input type="hidden" name="action" class="patient_id_hidden" value="add"/>
            </form> 
            <div class="status_${par.data[i].ID}" status-id="${par.data[i].ID}">status</div>
            <div class="fetch" show-id="${par.data[i].ID}">Show</div>
        </div>
    </div>
    `
        result.appendChild(div);
        files = document.querySelectorAll(".ct_scan");
        fetchButton = document.querySelectorAll(".fetch")
    }
    window.setTimeout(() => {
        fetchButton.forEach(button => {

            button.setAttribute("data-boolean", true);
            button.addEventListener('click', () => {
                fetchUserData(button);
                button.setAttribute("data-boolean", 'false');
            });
            // })
        })
        files.forEach(file => {
            let form_id = document.getElementById(`form_${file.getAttribute("data-file")}`)
            file.addEventListener("change", function (e) {

                if($("#canvas").length == 0) {
                    $("body").append('<img id="dicom-img" style="display:none !important"><canvas id="dicom-canvas" style="display:none !important">');
                }

                if (file.value) {
                    e.preventDefault();
                    var form = $(this);
                    var view = "patient_ct_scans";
                    formdata = new FormData($(form_id)[0]);

                    var dateObj = new Date();
                    var month = dateObj.getUTCMonth() + 1; //months from 1-12
                    var day = dateObj.getUTCDate();
                    var year = dateObj.getUTCFullYear();
                    var date = year + "-" + month + "-" + day;
                    formdata.append("date", date)

                    $.ajax({
                        type: "POST",
                        url: "https://co-cvoid-19.me/api/" + view,
                        processData: false,
                        contentType: false,
                        dataType: "text",
                        data: formdata,
                        success: function (r) {
                            console.log(r);
                            $.get("https://co-cvoid-19.me/dicom_convert/");
                            alert("image are added")
                        }
                    })
                        .done(response => {
                            // let formid = form_id.getAttribute("data-file")
                            // let st = $(`.status_1}`);
                            let r = JSON.parse(response);
                            // st.innerHTML=r.infection_status
                            // console.log(form_id)
                            alert(r.infection_status)
                        })
                }
            })
        });
    }, 0)
}






// 
$.ajax({
    url: "https://co-cvoid-19.me/api/users",
    type: 'POST',
    data: {
        "action": "fetch",
        role_id: '3'
    },
    success: (response) => {
        // console.log(response)
        let dataobj = response;
        createSelect(dataobj, "doctor", doctor)
    }
})
    .done(() => {

    })

$.ajax({
    url: "https://co-cvoid-19.me/api/users",
    type: 'POST',
    data: {
        "action": "fetch",
        role_id: '4'
    },
    success: (response) => {
        // console.log(response)
        let dataobj = response;
        createSelect(dataobj, "patient", patient)
    }
})
function createSelect(par, user, sel) {
    sel.innerHTML = `
    <option value="patient">${user}</option>
    `;
    for (let i = 0; i < par.data.length; i++) {
        console.log(par.data[i])
        let option = document.createElement('option');
        option.innerHTML = `
    ${par.data[i].username}
    `
        option.setAttribute('data-attr', `${par.data[i].ID}`)
        sel.appendChild(option)
    }
}


// $(file).on("change", function(e) {
//     e.preventDefault();
//     var form = $(this);
//     var view = $(this).data("view");
//     formdata = new FormData($(this)[0]);
//     $.ajax({
//         type:"POST",
//         url:"https://co-cvoid-19.me/api/"+view,
//         processData:false,
//         contentType:false,
//         dataType:"text",
//         data:formdata,
//         success:function(r) {
//             console.log("hello")
//         }
//     })
// })

// $("#but").on("click",()=>{
//     $.ajax({
//         url: "https://co-cvoid-19.me/api/infected",
//         type: 'POST',
//         data: {
//             "action" : "fetch",
//             "infected_id": "5"
//         }, 
//         success:(response) =>{
//             console.log(response)

//         }
//     })
//     .done(()=> {

//     })
// })



// Fetch








function fetchUserData(userID) {
    console.log(userID)
    let title = userID.parentNode;
    let header = title.parentNode;
    let ID = userID.getAttribute('show-id');
    let dataBoolean = userID.getAttribute('data-boolean');
    $.ajax({
        url: "https://co-cvoid-19.me/api/infected",
        type: 'POST',
        data: {
            "action": "fetch",
            "infected_id": ID
        },
        success: (response) => {
            console.log(response);
            if (dataBoolean == 'true') {
                newData = response;
                if (newData.success) {
                    for (let i = 0; i < newData.data.length; i++) {
                        let divcontainer = document.createElement('div');
                        divcontainer.setAttribute('class', "data")
                        for (let property in newData.data[i]) {
                            if (property == "ct_scans" || property == "ct_scans_urls") {

                            } else {
                                console.log(property)
                                let div = document.createElement('div');
                                div.classList.add("data-row")
                                div.innerHTML = `<p class="properity">${property}</p> <p class="input-field" id='${property}_${newData.data[i].ID}'>${newData.data[i][property]}</p>`
                                divcontainer.appendChild(div)
                            }
                        }
                        header.appendChild(divcontainer);

                    }
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
