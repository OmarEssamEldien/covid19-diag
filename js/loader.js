$(document).ready(function () {

    if(readCookie("token") != '' && readCookie("user_id") != '') {
        $.ajax({
            type:"GET",
            url:"check-login.php",
            data:{token:readCookie("token"), user_id:readCookie("user_id")},
            dataType:"json",
            async:false,
            success:function(r) {
                if(r.success) {
                    $("header .button").removeClass("button").text(r.username).after('<li><a href="#" class="logout">خروج</a></li>');
                } else {
                    document.cookie = "token=0;expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
                    document.cookie = "user_id=0;expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
                    if(!window.location.href.includes('index.html') && !window.location.href.includes('login.html') 
                        && !window.location.href.includes('register.html') && !window.location.href.includes('faq.html')
                        ) {
                        window.location.assign('login.html')
                    }
                }
            }
        })
    } else {
        if(!window.location.href.includes('index.html') && !window.location.href.includes('login.html') 
            && !window.location.href.includes('register.html') && !window.location.href.includes('faq.html')
            ) {
            window.location.assign('login.html')
        }
    }

    setTimeout(
        function () {
            $('body').addClass('loaded');
        },
        1500
    );

    $(document).on("click", ".logout", function() {
        document.cookie = "token=0;expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
        document.cookie = "user_id=0;expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
        window.location.reload();
    })

});

function readCookie(name) {
    var i, c, ca, nameEQ = name + "=";
    ca = document.cookie.split(';');
    for(i=0;i < ca.length;i++) {
        c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return '';
}