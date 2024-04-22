$(document).ready(() => {
    $("#user__manage").click(() => {
        window.location.href = "code/view/html/manage.html";
    });
    $("#user__disconnect").click(() => {
        document.cookie = "user_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = "index.php";
    });
});