<?php
session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] != true) {
        echo "<script>this.location.href='adminLogin.php';</script>";
    }
} else {
    echo "<script>this.location.href='adminLogin.php';</script>";
}
include 'database/database.php';
$db = Database::conncect();

if (isset($_GET['delete'])) {
    $db->deleteCupon($_GET['delete']);
}
$fair = 0;
if (isset($_GET['messe'])) {
    $fair = $_GET['messe'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Messe-App Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="assets/img/messeRel.jpeg">
    <style>
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            display: block;
            margin: auto;
        }

        .button {
            width: 110%;
        }
    </style>
    <script src="js/adminScript.js"></script>
</head>

<body onload="onload()">
    <nav class="navbar navbar-expand-xl bg-light navbar-light">
        <div class="container-fluid col-md-1">
            <img src="assets/img/messelogo.png" alt="Messe-Logo" style="width: auto; height: 20px;">
        </div>
        <div class="container-fluid col-md-3">
            <select id="fair" onchange="changeFair()" name="fair" class="form-select">
                <?php
                if (isset($_GET['messe'])) {
                    echo $db->getFairOptions($fair);
                } else {
                    echo $db->getFairOptions();
                    $fair = $db->nextFair;
                }
                ?>
            </select>
        </div>
        <div class="container-fluid col-md-1">
        </div>
        <div class="container-fluid col-md-5">
            <input oninput="onSearch()" placeholder="Suchbegriff..." id="search" class="form-control" type="text">
        </div>
        <div class="container-fluid col-md-2 nav-right">
            <ul class="navbar-nav">
                <li class="nav-right">
                <a class="nav-link active" style="text-align: right!important" href="adminLogin.php?logout=true">
                    <img style="width: auto; height: 20px; float:left;" src="assets/img/logout.png" alt="">
                     Abmelden</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-4">
                <form id="mainForm" action="admin.php?messe=<?php echo $fair; ?>" method="post" enctype="multipart/form-data">
                    <input class="btn btn-primary form-control" id="file" type="file" name="image">
                    <?php
                    // UPDATE
                    if (isset($_GET['update'])) {
                        if (!empty($_FILES['image']['name'])) {
                            $localFileName = 'uploads/' . $_FILES['image']['name'];
                            if ($_FILES['image']['size'] > 1000000) {
                                echo "<b><p style = 'color:red;'>Das Bild ist zu groß! Die maximale Größe beträgt 1 MB. </p></b>";
                            } else {
                                if ($_FILES['image']['size'] > 0) {
                                    if (move_uploaded_file($_FILES['image']['tmp_name'], $localFileName)) {
                                        $db->updateCoupon($_GET['update'], $localFileName, $_POST["title"], $_POST["category"], $_POST['content'], $fair, $_POST['number'], $_POST['limit']);
                                    }
                                } else {
                                    $db->updateCoupon($_GET['update'], $localFileName, $_POST["title"], $_POST["category"], $_POST['content'], $fair, $_POST['number'], $_POST['limit']);
                                }
                            }
                        } else {
                            //echo '<b>kein Upload!</b>';
                        }
                    }

                    // UPLOAD
                    if (!empty($_FILES['image']['name']) && !isset($_GET['update']) && !isset($_GET['delete'])) {
                        $localFileName = 'uploads/' . $_FILES['image']['name'];
                        if ($_FILES['image']['size'] > 1000000) {
                            echo "<b><p style = 'color:red;'>Das Bild ist zu groß! Die maximale Größe beträgt 1 MB. </p></b>";
                        } else {
                            if ($_FILES['image']['size'] > 0) {
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $localFileName)) {
                                    $db->insertCoupon($localFileName, $_POST["title"], $_POST["category"], $_POST['content'], $fair, $_POST['number'], $_POST['limit']);
                                }
                            } else {
                                $db->insertCoupon($localFileName, $_POST["title"], $_POST["category"], $_POST['content'], $fair, $_POST['number'], $_POST['limit']);
                            }
                        }
                    } else {
                        //echo '<b>kein Upload!</b>';
                    }
                    ?>
                    <div class="mb-3 mt-3">
                        <label for="title" class="form-label">Titel:</label>
                        <input type="text" class="form-control" id="title" placeholder="Titel..." name="title">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="content" class="form-label">Beschreibung:</label>
                        <input type="text" class="form-control" id="content" placeholder="Text..." name="content">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="number" class="form-label">Standnummer:</label>
                        <input type="text" class="form-control" id="number" placeholder="Nummer..." name="number">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="limit" class="form-label">Limitierung:</label>
                        <input type="text" class="form-control" id="limit" placeholder="Limitierung..." name="limit">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="category" class="form-label">Kategorie:</label>
                        <select id="category" name="category" class="form-select">
                            <?php
                            echo $db->getCategoryOptions($fair);
                            ?>
                        </select>
                    </div>
                    <div id="days">
                        <h6>An Tagen:</h6>
                        <div class="form-check">
                            <input onclick="onAllCheck()" class="form-check-input" type="checkbox" id="all" name="option1" checked>
                            <label for="all" class="form-check-label">Alle Tage</label>
                        </div>
                        <hr>
                        <?php
                        echo $db->getDaysCheckbox($fair);
                        ?>
                    </div>
                    <br>
                    <div id="buttons" class="row">
                        <div class="col-sm-4">
                            <input class="form-label btn btn-primary" type="submit" value="Hochladen">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-8">
                <table id="cuponTable" class="table table-striped text-center">
                    <tr class="table-success">
                        <th>Bild</th>
                        <th>Kategorie</th>
                        <th>Titel</th>
                        <th>Standnummer</th>
                        <th>Limitierung</th>
                        <th>Bearbeiten</th>
                    </tr>
                    <tbody id="tableBody">
                        <?php
                        echo $db->getCuponTable($fair);
                        ?>
                    </tbody>
                </table>
                <button class="btn bg-light" onclick="changePage(-1)">&lt;</button>
                <button class="btn bg-light" onclick="changePage(1)">&gt;</button>
                <span id="info">Gutschein 0 bis 0 von 0 Gutscheinen</span>
            </div>
        </div>
    </div>

    <script>
        let currentId = 0;

        function updateCupon(id) {
            currentId = id;
            document.getElementById("mainForm").setAttribute("action", "admin.php?messe=<?php echo $fair; ?>&update=" + currentId);
            let td = document.getElementById("tr" + id).getElementsByTagName("td");
            let fileUrl = td[0].getElementsByTagName("img")[0].src;
            let contenType = getContentType(td[0].getAttribute("value").split(".")[1]);

            let file = new File([""], td[0].getAttribute("value"), {
                type: contenType
            });

            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById("title").value = td[2].innerText;
            document.getElementById("content").value = td[2].getAttribute("con");
            document.getElementById("file").files = dataTransfer.files;
            document.getElementById("category").value = td[1].getAttribute("cat");
            document.getElementById("number").value = td[3].innerText;
            document.getElementById("limit").value = td[4].innerText;

            let boxes = document.getElementsByClassName("boxes");
            let checked = document.getElementById("tr" + id).getAttribute('days');

            for (let i = 0; i < boxes.length; i++) {
                boxes[i].checked = false;
            }
            for (let i = 0; i < checked.length; i++) {
                boxes[checked.charAt(i)].checked = true;
            }
            document.getElementById("all").checked = (boxes.length == checked.length);
            //onAllCheck();
        }

        function getContentType(type) {
            let contentType = '';
            switch (type) {
                case 'png':
                    contentType = "image/png";
                    break;
                case 'svg':
                    contentType = "image/svg+xml";
                case 'jpg':
                case 'jpeg':
                    contentType = "image/jpeg";
                    break;
                default:
                    throw Error("file type not supported");
            }
            return contentType;
        }

        function switchHTMLButtons(isNewCupon) {
            let btns = document.getElementById('buttons');

            if (isNewCupon) {
                btns.innerHTML = `
                        <div class="col-sm-4">
                            <input class="form-label btn btn-success button" type="submit" value="Speichern">
                        </div>
                        <div class="col-sm-4">
                            <input style="color:white;" onclick="switchHTMLButtons(false)" class="form-label btn btn-warning button" type="button" value="Abbrechen">
                        </div>
                        <div class="col-sm-4">
                            <input onclick="deleteCupon()" class="form-label btn btn-danger button" type="button" value="Löschen">
                        </div>
                        `;
            } else {
                currentId = 0;
                document.getElementById("mainForm").setAttribute("action", "admin.php?messe=<?php echo $fair; ?>");
                document.getElementById("mainForm").reset();
                btns.innerHTML = `
                <div class="col-sm-4">
                            <input class="form-label btn btn-primary" type="submit" value="Hochladen">
                        </div>`;
            }
        }
    </script>
</body>

</html>