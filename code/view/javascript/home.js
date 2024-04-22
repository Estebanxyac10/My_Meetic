$(document).ready(() => {
    const userCookie = document.cookie;
    if (!userCookie.includes("user_cookie")) {
        $("#user__info").html("Session expired! Please login again.");
    }
});