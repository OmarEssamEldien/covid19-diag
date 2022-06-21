// sending data as ajax file by  jquery ..... host equired ...
// const form = document.getElementById('form');//
const action = "add";
const username = document.getElementById('username');
const password = document.getElementById('password');
const gender = document.querySelectorAll('[name=gender]');
const socialStatus = document.querySelectorAll('[name=social-status]');
let socialStatusVal = ''
let genderVal = ''
const dateOfBirth = document.querySelector('#date_of_birth').value;
const job = document.getElementById('job');
const phone = document.getElementById('phone');
const nKids = document.getElementById('nkids');
const address = document.getElementById('address_2');
const email = document.getElementById('email');
const ID = document.getElementById('ID');
const roleID = document.getElementById('role_id');
const cordinats = document.getElementById('cordinats');
const vaccination = document.querySelector('select');
const register = document.getElementById('register');
const next = document.getElementById('button_next');
const back = document.getElementById('back');
const part1 = document.getElementsByClassName('part-1')[0];
const part2 = document.getElementsByClassName('part-2')[0];
let numKidsOPtion = document.querySelector('.sec-kids-opt')
console.log(dateOfBirth)
let formRegister = {};




// first function to store data from form 
next.addEventListener("click", () => {
  part1.classList.add("part-hidden")
  part2.classList.remove("part-hidden")
  // if (socialStatusVal.value == 'single') {
  //   alert(1)
  // }
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

});

back.addEventListener("click", () => {
  part2.classList.add("part-hidden");
  part1.classList.remove("part-hidden");
})


// first function to store data from form
register.addEventListener("click", () => {
  formRegister = {
    action: action,
    username: username.value,
    password: password.value,
    gender: genderVal,
    socialStatus: socialStatusVal,
    dob: dateOfBirth,
    job: job.value,
    phone_num: phone.value,
    numberOfKids: nKids.value,
    address: address.value,
    email: email.value,
    ssn: ID.value,
    coordinates: cordinats.value,
    role_id: 4,
    vaccinationType: vaccination.value
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



// get visitor's location
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, handleError);
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}

// watch visitor's location
function watchLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(showPosition, handleError);
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}
watchLocation()
function handleError(error) {
  let errorStr;
  switch (error.code) {
    case error.PERMISSION_DENIED:
      errorStr = 'User denied the request for Geolocation.';
      break;
    case error.POSITION_UNAVAILABLE:
      errorStr = 'Location information is unavailable.';
      break;
    case error.TIMEOUT:
      errorStr = 'The request to get user location timed out.';
      break;
    case error.UNKNOWN_ERROR:
      errorStr = 'An unknown error occurred.';
      break;
    default:
      errorStr = 'An unknown error occurred.';
  }
  console.error('Error occurred: ' + errorStr);
}

function showPosition(position) {
  cordinats.value = `${position.coords.latitude}, ${position.coords.longitude}`;
  !(cordinats)?window.location.reload():""
}
