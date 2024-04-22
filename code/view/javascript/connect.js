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

    $("#connect__form").submit(function (event) {
        event.preventDefault();

        const email = $("#email__connect").val().trim();
        const password = $("#password__connect").val().trim();

        if (!email || !password) {
            $("#verify__connect").text("Please fill in all fields.");
            return;
        }

        const connectData = { email, password };

        $.ajax({
            type: "post",
            url: "./code/controller/connect.php",
            data: connectData,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    $("#verify__connect").text(data.message);
                    $("#connect__modal").remove();
                    findCookie();
                } else {
                    $("#verify__connect").text(data.message);
                }
            },
            error: function (error) {
            }
        });
    });
});