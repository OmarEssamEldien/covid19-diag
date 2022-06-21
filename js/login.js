const login = document.getElementById("login_btn");
const email = document.getElementById("email")
const password = document.getElementById("password")
const action = "login";
const loginMessage = document.getElementById("login_message");
login.addEventListener('click', () => {
    form();
});

function form() {
    $.ajax({
        url: "https://co-cvoid-19.me/api/users",
        type: 'POST',
        data: {
            action: "login",
            email: email.value,
            password: password.value
        },
        success: (response) => {
            loginMessage.classList.add("appear")
            console.log(response);
            let userRole = response.user_role
            if (response.success) {
                hours = 1;
                date = new Date();
                date.setTime(date.getTime()+(hours*60*60*1000));
                expires = "; expires=" + date.toGMTString();
                document.cookie = "token=" + response.token + expires + "; path=/";
                document.cookie = "user_id=" + response.user_id + expires + "; path=/";
                if (userRole == "Radiologist") {

                    window.location.assign("Radiologist.html")
                } else if (userRole == 'Supervisor') {
                    window.location.assign("supervisor.html")
                } else if (userRole == "Doctor" || userRole == "Patient") {
                    window.location.assign("patianit.html")

                }
            } else {
                loginMessage.innerHTML = `
                <p>اسم المستخدم او كلمة المرور غير صحيحة  </p>
                  <span class="remove_meesage" id="remove_meesage">X</span>`

            }
            let removeMessage = document.getElementById("remove_meesage");
            removeMessage.addEventListener('click', () => {
                loginMessage.classList.remove("appear");
            })
        }
    })
}
