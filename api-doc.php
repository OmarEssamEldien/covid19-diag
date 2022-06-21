<?php

    $pageTitle = 'API Documentation';
    include "includes/header.php";

    $api_key = 'asdasd';

    $http = (@$_SERVER['HTTPS'] == "on") ? 'https' : 'http';
    $link = pathinfo("$http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]")['dirname'];
    $api_url = "$link/api";


?>
<script>
    $(window).on('hashchange', function(e){
        var elm = location.href.split("#")[1];
        elm = "#"+elm;
        if($(elm).length > 0) {
            $(".section").css("filter", "brightness(0.5)");
            $(elm).css("filter", "unset");
        }
    });
    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
    $('body').on('wheel resize scroll', function() {
        $(".section").each(function(){
            if ($(this).isInViewport()) {
                $(this).css("filter", "unset");
            } else {
                $(this).css("filter", "brightness(0.5)");
            }
        })
    });
</script>
<style>
    body {
        height: 100vh;
        overflow: hidden;
    }
    .section:not(#item-1-0) {
        filter: brightness(0.5);
        transition: 0.5s;
    }
</style>

<div class="row" style="height:100vh">
    <div class="col-4 col-lg-3 h-100">
      <nav id="navbar-example3" style="overflow-y:scroll" class="navbar navbar-light bg-light flex-column d-block align-items-stretch p-3 h-100" style="max-height:100vh">
        <a class="navbar-brand" href="#">API Documentation</a>
        <nav class="nav nav-pills flex-column" id=main_nav_pills >
            <a class="nav-link" href="#item-1">1. Users</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-1-1">1.1 Fetch users</a>
                <a class="nav-link ms-3 my-1" href="#item-1-2">1.2 Add user</a>
                <a class="nav-link ms-3 my-1" href="#item-1-3">1.3 Edit user</a>
                <a class="nav-link ms-3 my-1" href="#item-1-4">1.4 Delete user</a>
                <a class="nav-link ms-3 my-1" href="#item-1-5">1.5 Login user</a>
            </nav>
            <a class="nav-link" href="#item-2">2. User Emergency Contacts</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-2-1">2.1 Fetch Contacts</a>
                <a class="nav-link ms-3 my-1" href="#item-2-2">2.2 Add Contact</a>
                <a class="nav-link ms-3 my-1" href="#item-2-3">2.3 Edit Contact</a>
                <a class="nav-link ms-3 my-1" href="#item-2-4">2.4 Delete Contact</a>
            </nav>
            <a class="nav-link" href="#item-3">3. Infected Patients</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-3-1">3.1 Fetch Infected Patients</a>
                <a class="nav-link ms-3 my-1" href="#item-3-2">3.2 Add Infected Patient</a>
                <a class="nav-link ms-3 my-1" href="#item-3-3">3.3 Delete Infected Contact</a>
            </nav>
            <a class="nav-link" href="#item-4">4. Patients CT Scans</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-4-1">4.1 Fetch Patients CT Scans</a>
                <a class="nav-link ms-3 my-1" href="#item-4-2">4.2 Add Patient CT Scans</a>
                <a class="nav-link ms-3 my-1" href="#item-4-3">4.3 Delete CT Scans</a>
            </nav>
            <a class="nav-link" href="#item-5">5. Voting For Infection</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-5-1">5.1 Fetch Votes For Infection</a>
                <a class="nav-link ms-3 my-1" href="#item-5-2">5.2 Add Vote For Infection</a>
                <a class="nav-link ms-3 my-1" href="#item-5-3">5.3 Delete Vote</a>
            </nav>
            <a class="nav-link" href="#item-6">6. Recovered Patients</a>
            <nav class="nav nav-pills flex-column">
                <a class="nav-link ms-3 my-1" href="#item-6-1">6.1 Fetch Recovered Patients</a>
                <a class="nav-link ms-3 my-1" href="#item-6-2">6.2 Add Recovered Patient</a>
                <a class="nav-link ms-3 my-1" href="#item-6-3">6.3 Delete Recovered Patient</a>
            </nav>
        </nav>
      </nav>
    </div>
    <div class="col-8 col-lg-9 h-100">
      <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" class="scrollspy-example-2" style="scroll-behavior: smooth;max-height:100vh;overflow-y: scroll;" tabindex="0">
        
                
        <div class="container">
            <div class="bg-dark sign-page">
                <h4 class="mt-5">How To Use the API : </h4>
                <p>This documentation was made to be used in Covid19 Diagnose Project of CSI Team for Graduation Project 2021/2022</p>

                <?php 
                 $cookie = @$_COOKIE['__test'];

                 if(empty($cookie))
                    $cookie = @explode('__test=', $_SERVER['HTTP_COOKIE'])[1];
             
                 if(!empty($cookie)) { ?>
                <div class="alert alert-warning">
                    In order to get a valid response while using the API you have to send a header in each request contains cookie of the website :
                    <br>
                    -H "COOKIE: __test=<span class="text-primary"><?php echo $cookie; ?></span>"
                </div>
                <span class="badge bg-warning text-dark">Cookie should be sent from same device</span>
                <?php } ?>

                <hr>

                <?php include "api-docs/users.php"; ?>

                <?php include "api-docs/user-emergency-contact.php"; ?>

                <?php include "api-docs/infected-patients.php"; ?>

                <?php include "api-docs/patient-ct-scans.php"; ?>

                <?php include "api-docs/voting-for-infection.php"; ?>

                <?php include "api-docs/recovered-patients.php"; ?>

            </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $("#main_nav_pills > .nav-pills").hide();
    $(".scrollspy-example-2").on("click scroll", function(){
        $("#main_nav_pills > .nav-pills").hide();
        if($("#main_nav_pills > .nav-link.active").length > 0) {
            $("#main_nav_pills > .nav-link.active").next().show();
        }
    })
    $("#main_nav_pills > .nav-link").on("click", function(){
        setTimeout(() => {        
            $("#main_nav_pills > .nav-pills").hide();
            if($("#main_nav_pills > .nav-link.active").length > 0) {
                $("#main_nav_pills > .nav-link.active").next().show();
            }
        }, 1000);
    })
  </script>