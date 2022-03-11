require("./bootstrap");
function getXmlHttp() {
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != "undefined") {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function loadImages(file) {
    var images = document.querySelector(".blockImg");

    images.innerHTML = '<img src="' + file + '" />';
}
let link = document.querySelectorAll(".nav-link");
if (link) {
    link.forEach(function (item, index) {
        item.addEventListener("click", (e) => {
            let data = e.target.getAttribute("data-target");
            let modal = document.querySelector(".modal_window");
            let forms = document.querySelector("#forms"),
                inputs = document.querySelectorAll(".row input"),
                textarea = document.querySelector(".row textarea");
            switch (data) {
                case "add":
                    e.preventDefault();
                    inputs.forEach((t) => {
                        if (t.name === "_token") {
                            return;
                        }
                        t.value = "";
                    });
                    textarea.value = "";
                    modal.classList.add("active");
                    forms.setAttribute("data-target", "/add");
                    break;
                case "edit":
                    e.preventDefault();
                    let parent =
                            e.target.parentNode.parentNode.parentNode.parentNode.querySelectorAll(
                                "td"
                            ),
                        newForm = new FormData();
                    newForm.append("id", parent[0].innerText);
                    forms.setAttribute("data-target", "/edit");
                    modal.classList.add("active");
                    let req = getXmlHttp();

                    req.onreadystatechange = () => {
                        if (req.readyState === 4) {
                            if (req.status == 200) {
                                let data = JSON.parse(req.responseText);
                                if (data.success === true) {

                                    Object.entries(forms.elements).map((t,inte) => {

                                        if(data.data[t[0]]){
                                            t[1].value = data.data[t[0]];
                                        }

                                    });
                                    let nbox = document.querySelector(".ck-blurred[role=\"textbox\"] p");
                                    nbox.innerHTML = data.data['body'];
                                    loadImages(data.data.link);
                                }
                            }
                        }
                    };
                    req.open(
                        "POST",
                        forms.getAttribute("url") + "/getData",
                        true
                    );
                    // req.setRequestHeader(
                    //     "Content-Type",
                    //     "application/x-www-form-urlencoded; charset=utf-8"
                    // );
                    req.setRequestHeader(
                        "X-CSRF-TOKEN",
                        document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    );
                    req.send(newForm);

                    break;
                case "remove":
                    e.preventDefault();
                    let parenta =
                            e.target.parentNode.parentNode.parentNode.parentNode.querySelectorAll(
                                "td"
                            ),
                        url = forms.getAttribute("url");

                    let data = new FormData();
                    data.append("id", parenta[0].innerText);
                    request(url, data);
                    break;
                default:
                    break;
            }
        });
    });
}
function request(url, params) {
    let req = getXmlHttp();

    req.onreadystatechange = () => {
        if (req.readyState === 4) {
            if (req.status == 200) {
                let data = JSON.parse(req.responseText);
                if (data.success === true) {
                    window.location.reload();
                }
            }
        }
    };
    req.open("POST", url + "/remove", true);
    // req.setRequestHeader(
    //     "Content-Type",
    //     "application/x-www-form-urlencoded; charset=utf-8"
    // );
    req.setRequestHeader(
        "X-CSRF-TOKEN",
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content")
    );
    req.send(params);
}
let close = document.querySelector(".close");

if (close) {
    close.addEventListener("click", () => {
        let modal = document.querySelector(".modal_window");
        modal.classList.remove("active");
    });
}
let form = document.querySelector("#forms");
form.addEventListener("submit", (es) => {
    es.preventDefault();
    let req = getXmlHttp(),
        data = new FormData(document.forms.dols),
        url = form.getAttribute("url"),
        status = document.querySelector(".status");
    console.log(form);
    req.onreadystatechange = () => {
        if (req.readyState === 4) {
            status.innerHTML = req.statusText;
            if (req.status == 200) {
                let data = JSON.parse(req.responseText);
                if (data.success === true) {
                    window.location.reload();
                }
            } else {
                console.log(data);
            }
        }
    };
    req.open("POST", url + form.getAttribute("data-target"), true);
    // req.setRequestHeader(
    //     "Content-Type",
    //     "application/x-www-form-urlencoded; charset=utf-8"
    // );
    req.send(data);
});
