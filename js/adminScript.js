let page = 1;
let cuponsPerPage = 8;
let rows;
let tableContent = [];
let filteredTableContent = [];
let maxPage;

function onload() {
    try {
        rows = document.getElementById("cuponTable").getElementsByTagName("tr");
        maxPage = parseInt((rows.length - 1) / cuponsPerPage);
        maxPage += ((parseInt(rows.length - 1) / cuponsPerPage) - maxPage != 0) ? 1 : 0;

        for (let i = 1; i < rows.length; i++) {
            let td = rows[i].getElementsByTagName("td");
            tableContent[i - 1] = `<tr id = '${rows[i].getAttribute('id')}' days='${rows[i].getAttribute('days')}'>
                <td value='${td[0].getAttribute('value')}'><img src="uploads/${td[0].getAttribute('value')}"></img></td>
                <td cat="${td[1].getAttribute("cat")}">${td[1].innerText}</td>
                <td con="${td[2].getAttribute("con")}">${td[2].innerText}</td>
                <td>${td[3].innerText}</td>
                <td web1="${td[4].getAttribute("web1")}" web2="${td[4].getAttribute("web2")}">${td[4].innerText}</td>
                <td><button onclick='updateCupon(${td[5].getAttribute('value')}); switchHTMLButtons(true);'  class='justify-content-center form-label btn btn-light'>📝</button></td>
                </tr>`;
        }

        filteredTableContent = tableContent;
        changePage(0);
    } catch {
        setTimeout(onload, 1000);
    }
}

function changePage(num) {
    let length = filteredTableContent.length;
    page += num;
    maxPage = parseInt((length) / cuponsPerPage);
    maxPage += ((parseInt(length) / cuponsPerPage) - maxPage != 0) ? 1 : 0;
    page = (page <= 0) ? 1 : (page > maxPage) ? maxPage : page;
    //page = (page == 0) ? 0 : (page - maxPage == ((length%cuponsPerPage==0)?0:1)) ? maxPage-(length%cuponsPerPage==0)?1:0 : page;
    let content = '';
    let min = (page - 1) * cuponsPerPage;
    let max = (page - 1) * cuponsPerPage + cuponsPerPage;
    let arr = filteredTableContent.slice(min, max);
    for (let i = 0; i < arr.length; i++) {
        content += arr[i];
    }
    document.getElementById("info").innerText = `Gutschein ${(arr.length > 0) ? min + 1 : 0} bis ${(max > length) ? length : max} von ${length} Gutscheinen`;
    document.getElementById("tableBody").innerHTML = content;
}

function onSearch() {

    let value = document.getElementById("search").value.toLowerCase();
    filteredTableContent = [];
    let idx = 0;
    for (let i = 0; i < tableContent.length; i++) {
        if (tableContent[i].toLowerCase().includes(value)) {
            filteredTableContent[idx] = tableContent[i];
            idx++;
        }
    }
    page = 0;
    changePage(0);
}

function deleteCupon() {
    location.href = "admin.php?delete=" + currentId + "&messe=" + document.getElementById("fair").value;
}

function changeFair() {
    location.href = "admin.php?messe=" + document.getElementById("fair").value;
}

function onAllCheck() {
    let boxes = document.getElementsByClassName("boxes");
    let allCheck = document.getElementById("all").checked;

    for (let i = 0; i < boxes.length; i++) {
        boxes[i].checked = allCheck;
    }
}

function checkCheckbox() {
    let boxes = document.getElementsByClassName("boxes");
    let check = true;

    for (let i = 0; i < boxes.length; i++) {
        if (!boxes[i].checked) {
            check = false;
        }
    }
    document.getElementById("all").checked = check;
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}