function reload_pbar() {
    $(".progress-bar-fill").css({
        "width": "100%",
        "transition": "10s linear"
    });
}

function reload_servers() {
    $("#reload-content").load("./systemoverview.php #reload-content", reload_pbar);
}

reload_pbar();
setInterval(reload_servers, 10000);


var welkom = document.getElementById('message-area');

if (welkom.innerText == '') {
    welkom.style.display = "none";
}