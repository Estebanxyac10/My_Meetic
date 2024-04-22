$(document).ready(() => {
    $("#manage__close").click(() => {
        window.location.href = "../../../index.php";
    });

    const userCookieExists = document.cookie.split(';').some((item) => item.trim().startsWith('user_cookie='));
    if (!userCookieExists) {
        let html = "<p>You are not connected</p>";
        $("#manage__content-infos").html(html);
        return;
    }

    $.get("/code/controller/manage.php", (data) => {
        const userData = JSON.parse(data);

        userData.forEach((user) => {
            let infoArray = [];
            Object.entries(user).forEach(([key, value]) => {
                if (value !== null) {
                    infoArray.push(`${key}: ${value}`);
                }
            });

            infoArray.forEach(element => {
                let html = `<p>${element}</p>`;
                $("#manage__content-infos").append(html);
            });

            const userEmail = user.email;

            $("#delete__account").click(function () {
                if (confirm("Are you sure you want to delete your account?")) {
                    $.ajax({
                        type: "POST",
                        url: "/code/controller/delete.php",
                        data: { email: userEmail },
                        success: function (response) {
                            console.log(response);
                            document.cookie = "user_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                            window.location.href = "../../../index.php";
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $("#changeMail").submit(function (e) {
                e.preventDefault();

                const newMail = $("#changeMailInput").val().trim();

                const changeMailData = {
                    newmail: newMail,
                    email: userEmail
                };

                if (confirm("Are you sure you want to change your e-mail?")) {
                    $.ajax({
                        type: "POST",
                        url: "/code/controller/change_mail.php",
                        data: changeMailData,
                        success: function (response) {
                            document.cookie = "user_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                            window.location.href = "../../../index.php";
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $("#changePass").submit(function (e) {
                e.preventDefault();

                const newPass = $("#changePassInput").val().trim();

                const changePassData = {
                    newpass: newPass,
                    email: userEmail
                };

                if (confirm("Are you sure you want to change your password?")) {
                    $.ajax({
                        type: "POST",
                        url: "/code/controller/change_pass.php",
                        data: changePassData,
                        success: function (response) {
                            document.cookie = "user_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                            window.location.href = "../../../index.php";
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    });
});