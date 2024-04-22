$(document).ready(() => {
    function findCookie() {
        const userCookieExists = document.cookie.split(';').some((item) => item.trim().startsWith('user_cookie='));
        const cookieIsReal = () => {
            $("#header__login, #header__register").hide();
            $("#header__user").show();
        };
        const cookieIsNotReal = () => {
            $("#header__login, #header__register").show();
            $("#header__user").hide();
        };
        userCookieExists ? cookieIsReal() : cookieIsNotReal();
    }

    $("#register__form").submit(function (event) {
        event.preventDefault();

        const email = $("#email__register").val().trim();
        const lastname = $("#lastname__register").val().trim();
        const firstname = $("#firstname__register").val().trim();
        const birthdate = $("#birthdate__register").val().trim();
        const gender = $("#gender__register").val().trim();
        const city = $("#city__register").val().trim();
        const password = $("#password__register").val().trim();
        const hobbies = [];
        $(".hobby__register:checked").each(function () {
            hobbies.push($(this).val());
        });

        const registerData = {
            email, lastname, firstname,
            birthdate, gender, city, password, hobbies
        };

        const userAge = new Date(registerData.birthdate);
        const now = new Date();
        const age = now.getFullYear() - userAge.getFullYear();
        if (age < 18) {
            $("#verify__register").text("You must be 18 years old to register!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "./code/controller/register.php",
            data: registerData,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    $("#verify__register").text(data.message);
                    $("#register__modal").remove();
                    findCookie();
                } else {
                    $("#verify__register").text(data.message);
                }
            },
            error: function (error) {
            }
        });
    });
});