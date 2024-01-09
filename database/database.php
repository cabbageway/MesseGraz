<?php
class Database
{
   private $servername = 'localhost';
    private $username = "root";
    private $password = '';
     /*private $dbname = "messe_db";*/
    /* private $servername = 'db5012227694.hosting-data.io';
    private $username = "dbu2915191";
    private $password = 'Ionos2023#'; */
    
    private $dbname = "dbs10288941";
    private $conn;
    public $nextFair = 0;
    //public $messe_id = 3;

    /*  id |  Messe
        1  -  Häuslbauermesse
        2  -  Trends of Beauty
        3  -  Frühjahrsmesse
        4  -  Herbstmesse
        5  -  Gesundheitsmesse
    */

    private static $instance = null;

    private function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname) or die();
    }

    public static function conncect()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //-----------------------MAIN PAGE--------------------------------------------------------------------
    public function getCategoryLiTag($messe_id)
    {
        $sql = "SELECT * FROM kategorie WHERE messe_id = " . $messe_id . ";";
        $result = $this->conn->query($sql);
        $content = '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $content = $content . "<li><a class='dropdown-item' id='" . $row['kategorie_id'] . "' onclick='filterCupons(" . $row['kategorie_id'] . ");'>" . $row['bezeichnung'] . "</a></li>";
            }
        }
        return $content;
    }

    public function getCuponImage($messe_id)
    {
        $sql = "SELECT gutschein_id, limitierung,DATE_FORMAT(MIN(DATE_ADD(beginn_datum, INTERVAL tag DAY)), '%d.%m.') von, 
                                         DATE_FORMAT(MAX(DATE_ADD(beginn_datum, INTERVAL tag DAY)), '%d.%m.') bis, gutschein_id, titel, image, beschreibung, kategorie_id, stand_number
        FROM gutschein 
        INNER JOIN messe USING (messe_id) 
        INNER JOIN gutschein_tag USING(gutschein_id)
        WHERE messe_id = " . $messe_id . "
        GROUP BY gutschein_id;";
        $result = $this->conn->query($sql);
        $content = '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = '🕔 Gültig ';
                if ($row['von'] == $row['bis']) {
                    $date = $date . "am <b><b>" . $row['von'];
                } else {
                    $date = $date . "von <b><b>" . $row['von'] . "</b></b> bis <b><b>" . $row['bis'];
                }

                if ($row['limitierung'] != NULL) {
                    $limit = "&#9888; Dieser Gutschein ist streng limitiert auf <b><b>" . $row['limitierung'] . " Stück!</b></b>";
                } else {
                    $limit = "";
                    $row['limitierung'] = 100000000;
                }

                $content = $content . "<div class='col-lg-3 d-flex cupon justify-content-center' value=" . $row['kategorie_id'] . ">
                <div class='card'>
                <div class='img-div'>
                <img class='card-img-bottom cupon-img' src='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "'></img>
                </div>
                <div class='card-body'>
                <h4 class='card-title'>" . $row['titel'] . "</h4>
                <p class='card-text'>" . $row['beschreibung'] . "<br><br>🧭 Einzulösen am Stand <b><b>" . $row['stand_number'] . "</b></b><br><br>" . $date . "</b></b><br><br><br><br>" . $limit . "</p>";
                $cupon_id = $row['gutschein_id'];
                $sqlDay = "SELECT COUNT(*) anz
                FROM gutschein 
                    INNER JOIN messe USING (messe_id) 
                    INNER JOIN gutschein_tag USING(gutschein_id)
                WHERE gutschein_id = " . $row['gutschein_id'] . " AND DATE_FORMAT(DATE_ADD(beginn_datum, INTERVAL tag DAY), '%d.%M.%Y') = DATE_FORMAT(SYSDATE(), '%d.%M.%Y');";
                $resultDay = $this->conn->query($sqlDay);
                $sqlLimit = "SELECT COUNT(*) anz
                FROM gutschein 
                    INNER JOIN aufrufe USING(gutschein_id)
                WHERE gutschein_id = " . $row['gutschein_id'] . ";";
                $resultLimit = $this->conn->query($sqlLimit);
                if ($resultDay->num_rows > 0) {
                    $rowDay = $resultDay->fetch_assoc();
                    $rowLimit = $resultLimit->fetch_assoc();
                    if ($rowDay['anz'] == 1 && $rowLimit['anz'] < $row['limitierung']) {
                        $content = $content . "<a onclick = 'onReedemCupon(" . $row['gutschein_id'] . ");' value='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "' class='btn btn-primary btnGet'>Einlösen</a>
                            </div>
                            </div>
                        </div>";
                    } else {
                        $content = $content . "<a onclick = 'onNotReedemCupon();' value='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "' class='btn btn-primary btnGet'>Einlösen</a>
                        </div>
                        </div>
                    </div>";
                    }
                }
            }
        }
        return $content;
    }

    /*public function getCuponImage($messe_id){
        $sql = "SELECT * 
        FROM gutschein 
        INNER JOIN kategorie ON gutschein.kategorie_id = kategorie.kategorie_id
        WHERE gutschein.messe_id = " . $messe_id . "
        ORDER BY gutschein.kategorie_id;";
        
        $result = $this->conn->query($sql);
        $content = '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sqlStringfuerDate = "SELECT MAX(tag) max, MIN(tag) min 
                FROM gutschein_tag
                WHERE gutschein_id = " . $row['gutschein_id'] . ";";
                $beginnDate = "";
                $endDate = "";
                $big = 0;
                $small = 0;
                $erg = $this->conn->query($sqlStringfuerDate);
                if($erg->num_rows > 0)
                {
                    while ($row2 = $erg->fetch_assoc())
                    {
                        $big = (int) $row2['max'];
                        $small = (int) $row2['min'];
                    }
                }
                $sqlStringfuerDate = "SELECT *
                FROM messe
                WHERE messe_id = " .$row['messe_id']. "";
                $erg = $this->conn->query($sqlStringfuerDate);
                if($erg->num_rows > 0) {
                    while ($row2 = $erg->fetch_assoc())
                    {
                        $beginnDate = $row2['beginn_datum'];
                    }
                }
                $kleineDate = strtotime($beginnDate) + $small*24*60*60;
                $bigDate = strtotime($beginnDate) + $big*24*60*60;
        
                $timestamp1 = strtotime($kleineDate);
                $timestamp2 = strtotime($bigDate);
                $zu_pruefen_timestamp = strtotime(date('m-d-Y'));
                $disable = 0;
                $link = "";

                if ($zu_pruefen_timestamp >= $timestamp1 && $zu_pruefen_timestamp <= $timestamp2) 
                {
                    $disable = 1;
                }
                if($disable == 0)
                {
                    $link = "<a onclick = ''  id='".$row["gutschein_id"]."' value='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "' class='btn btn-primary btnGet'>Einlösen</a>";
                } else{
                    $link = "<a onclick = 'onButton();'  id='".$row["gutschein_id"]."' value='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "' class='btn btn-primary btnGet'>Einlösen</a>";
                }
                    $content = $content . "<div class='col-lg-3 d-flex cupon justify-content-center' value=" . $row['kategorie_id'] . ">
                    <div class='card'>
                    <div class='img-div'>
                    <img class='card-img-bottom cupon-img' src='" . $row['image'] . "' alt='" . $row['titel'] . ": " . $row['beschreibung'] . "'></img>
                    </div>
                    <div class='card-body'>
                    <h4 class='card-title'>" . $row['titel'] . "</h4>
                    <p class='card-text'>" . $row['beschreibung'] . "<br><b>Standnummer: <br>" . $row['stand_number'] . "</b><br>
                    " . date('d.m.Y', $kleineDate) . " - " . date('d.m.Y', $bigDate) . "
                    </p>
                    ".$link."
                    </div>
                    </div>
                  </div>";
                  $content = $content;
        }
    }
        return $content;
    }*/

    //-----------------------ADMIN PAGE--------------------------------------------------------------------
    public function getCuponTable($messeId)
    {
        $sql = "SELECT DISTINCT gutschein_id, titel, image, kategorie.bezeichnung katbez, gutschein.kategorie_id cat, beschreibung, limitierung, stand_number, weblink1, weblink2 FROM gutschein 
                INNER JOIN kategorie, messe
                WHERE gutschein.kategorie_id = kategorie.kategorie_id AND gutschein.messe_id = " . $messeId . " 
                ORDER BY gutschein.kategorie_id;";
        $result = $this->conn->query($sql);
        $content = '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sql = "SELECT tag FROM gutschein_tag WHERE gutschein_id = " . $row['gutschein_id'] . ";";
                $result2 = $this->conn->query($sql);
                $days = '';
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $days = $days . $row2["tag"];
                    }
                }
                if ($row['limitierung'] != NULL
                
                
                
                
                
                ) {
                    $limit = $row['limitierung'];
                } else {
                    $limit = "/";
                }
                $content = $content . "<tr id = 'tr" . $row['gutschein_id'] . "'days='" . $days . "'>
                <td value='" . explode('/', $row['image'])[1] . "'><img src=" . $row['image'] . "></img></td>
                <td cat = '" . $row['cat'] . "'>" . $row['katbez'] . "</td>
                <td con = '" . $row['beschreibung'] . "'>" . $row['titel'] . "</td>
               
                <td>" . $row['stand_number'] . "</td>
                <td web1='" . $row['weblink1'] . "' web2='" . $row['weblink2'] . "'>" . $limit . "</td>
               
                <td value='" . $row['gutschein_id'] . "'><button onclick='updateCupon(" . $row['gutschein_id'] . "); switchHTMLButtons(true);'  class='justify-content-center form-label btn btn-light'>📝</button></td>
            </tr>";
            }
        }
        return $content;
    }

    public function insertCoupon($file, $title, $category, $content, $fair, $number, $limitierung, $weblink1, $weblink2)
    {
        $nextId = 0;
        if (empty($limitierung) || str_contains($limitierung, '/') || $limitierung == 0) {
            $sql = "INSERT INTO gutschein (image, kategorie_id, titel, beschreibung, messe_id, stand_number, weblink1, weblink2) VALUES ('" . strtolower($file) . "', " . $category . ", '" . $title . "','" . $content . "','" . $fair . "','" . $number . "','" . $weblink1 . "','" . $weblink2 . "');";
        } else {
            $sql = "INSERT INTO gutschein (image, kategorie_id, titel, beschreibung, messe_id, stand_number, limitierung, weblink1, weblink2) VALUES ('" . strtolower($file) . "', " . $category . ", '" . $title . "','" . $content . "','" . $fair . "','" . $number . "','" . $limitierung . "','" . $weblink1 . "','" . $weblink2 . "');";
        }
        if ($this->conn->query($sql) === TRUE) {
            
            $nextId = $this->conn->insert_id;
            for ($i = 0; $i < 7; $i++) {
                if (isset($_POST["box" . $i])) {
                    $sql = "INSERT INTO gutschein_tag (gutschein_id, tag) VALUES (" . $nextId . ", " . $i . ");";
                    $this->conn->query($sql);
                }
            }
        }
        else {
        echo "SQL error KW"; }
    }

    public function updateCoupon($id, $file, $title, $category, $content, $fair, $number, $limitierung, $weblink1, $weblink2)
    {
        if (empty($limitierung) || str_contains($limitierung, '/') || $limitierung == 0) {
            $sql = "UPDATE gutschein
            SET image = ?,
            kategorie_id = ?, 
            titel = ?,
            beschreibung = ?,
            messe_id = ?, 
            stand_number = ?,
            limitierung = NULL,
            weblink1 = ?,
            weblink2 = ? 
            WHERE gutschein_id = ?;";

            $stmt = mysqli_stmt_init($this->conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL error";
            } else {
                mysqli_stmt_bind_param($stmt, "sississsi", $file, $category, $title, $content, $fair, $number, $weblink1, $weblink2, $id);
                mysqli_stmt_execute($stmt);
            }
        } else {
            $sql = "UPDATE gutschein
            SET image = ?,
            kategorie_id = ?, 
            titel = ?,
            beschreibung = ?,
            messe_id = ?, 
            stand_number = ?,
            limitierung = ?,
            weblink1 = ?,
            weblink2 = ? 
            WHERE gutschein_id = ?;";

            $stmt = mysqli_stmt_init($this->conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL error";
            } else {
                mysqli_stmt_bind_param($stmt, "sissisissi", $file, $category, $title, $content, $fair, $number, $limitierung, $weblink1, $weblink2, $id);
                mysqli_stmt_execute($stmt);
            }
        }


        $sql = "DELETE FROM gutschein_tag WHERE gutschein_id = ?";

        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL error";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
        }

        for ($i = 0; $i < 7; $i++) {
            if (isset($_POST["box" . $i])) {
                $sql = "INSERT INTO gutschein_tag (gutschein_id, tag) VALUES (" . $id . ", " . $i . ");";
                $this->conn->query($sql);
            }
        }
    }

    public function deleteCupon($id)
    {
        $sql = "DELETE FROM gutschein_tag WHERE gutschein_id = ?";

        $stmt = mysqli_stmt_init($this->conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL error";
        } else {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
        }


        $sql = "DELETE FROM gutschein WHERE gutschein_id ='" . $id . "';";
        $this->conn->query($sql);
    }

    //-----------------------DROPDOWN ADMIN PAGE--------------------------------------------------------------------
    public function getCategoryOptions($messe_id)
    {
        $sql = "SELECT * FROM kategorie WHERE messe_id = " . $messe_id . ";";
        $result = $this->conn->query($sql);
        $content = '';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $content = $content . "<option value='" . $row['kategorie_id'] . "'>" . $row['bezeichnung'] . "</option>";
            }
        }
        return $content;
    }

    public function getFairOptions($fair = 0)
    {
        $sql = "SELECT messe_id, bezeichnung, DATEDIFF(end_datum, SYSDATE()) dif FROM messe ORDER BY beginn_datum;";

        $result = $this->conn->query($sql);
        $content = '';
        $sel = true;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($fair == 0) {
                    if ($row['dif'] >= 0 && $sel) {
                        $content = $content . "<option selected value='" . $row['messe_id'] . "'>" . $row['bezeichnung'] . "</option>";
                        $sel = false;
                        $this->nextFair = $row['messe_id'];
                    } else {
                        $content = $content . "<option value='" . $row['messe_id'] . "'>" . $row['bezeichnung'] . "</option>";
                    }
                } else {
                    if ($row['messe_id'] == $fair) {
                        $content = $content . "<option selected value='" . $row['messe_id'] . "'>" . $row['bezeichnung'] . "</option>";
                    } else {
                        $content = $content . "<option value='" . $row['messe_id'] . "'>" . $row['bezeichnung'] . "</option>";
                    }
                }
            }
        }
        return $content;
    }

    public function getDaysCheckbox($fair)
    {
        $interval = 0;
        $weekday = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
        $content = '';
        do {
            $sql = "SELECT DATE_FORMAT(DATE_ADD(beginn_datum, INTERVAL " . $interval . " DAY), '%w') day,  DATE_FORMAT(DATE_ADD(beginn_datum, INTERVAL " . $interval . " DAY), '%d.%m.') date
                FROM messe 
                WHERE messe_id = " . $fair . " AND DATE_ADD(beginn_datum, INTERVAL " . $interval . " DAY) <= end_datum";
            $result = $this->conn->query($sql);
            $rowNum = $result->num_rows;

            if ($rowNum > 0) {
                while ($row = $result->fetch_assoc()) {
                    $content = $content . '<div class="form-check">
                <input name="box' . $interval . '" onclick="checkCheckbox()" class="form-check-input boxes" type="checkbox" id="' . $interval . '" checked>
                <label for="' . $interval . '" class="form-check-label">' . $weekday[$row['day']] . " " . $row["date"] . '</label>
            </div>';
                }
            }
            $interval++;
        } while ($rowNum != 0);
        return $content;
    }
}
