$(document).ready(() => {
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

    $("#header__login").click(() => {
        $.ajax({
            type: "post",
            url: "./code/view/html/connect.html",
            dataType: "html",
            success: function (response) {
                $("body").append("<div id='connect__modal'>" + response + "</div>");
                $("#connect__modal").append();
                $("#connect__close").click(() => {
                    $("#connect__modal").remove();
                });
            }
        });
    });

    $("#header__register").click(() => {
        $.ajax({
            type: "post",
            url: "./code/view/html/register.html",
            dataType: "html",
            success: function (response) {
                $("body").append("<div id='register__modal'>" + response + "</div>");
                $("#register__modal").append();
                $("#register__close").click(() => {
                    $("#register__modal").remove();
                });
            }
        });
    });

    $("#header__user").click(() => {
        $.ajax({
            type: "post",
            url: "./code/view/html/user.html",
            dataType: "html",
            success: function (response) {
                $("body").append("<div id='user__modal'>" + response + "</div>");
                $("#user__modal").append();
                $("#user__close").click(() => {
                    $("#user__modal").remove();
                });
            }
        });
    });
});