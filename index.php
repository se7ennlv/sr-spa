<?php
include './config/db.php';
include './config/db2.php';

if (!empty($_POST['setCookie'])) {
    setcookie("deptID", $_POST["deptID"], time() + (86400 * 360));
    setcookie("locaID", $_POST["locaID"], time() + (86400 * 360));

    setcookie("getDeptName", $_POST["getDeptName"], time() + (86400 * 360));
    setcookie("getLocaName", $_POST["getLocaName"], time() + (86400 * 360));

    $_COOKIE['deptID'] = $_POST["deptID"];
    $_COOKIE['locaID'] = $_POST["locaID"];

    $_COOKIE['getDeptName'] = $_POST["getDeptName"];
    $_COOKIE['getLocaName'] = $_POST["getLocaName"];
}

if (!empty($_POST['deletCookie'])) {
    setcookie("deptID", "");
    setcookie("locaID", "");

    setcookie("getDeptName", "");
    setcookie("getLocaName", "");

    $_COOKIE['deptID'] = "";
    $_COOKIE['locaID'] = "";

    $_COOKIE['getDeptName'] = "";
    $_COOKIE['getLocaName'] = "";
}

try {
    if (isset($_COOKIE["deptID"])) {
        $deptID = $_COOKIE["deptID"];
    }

    $sqlQ = "SELECT QuesID, DeptID, QuesEnName +' / '+ QuesThName AS Question FROM Questions WHERE DeptID = '{$deptID}' ";
    $stmtQ = $conn->prepare($sqlQ);
    $stmtQ->execute();

    $sqlEmp = "SELECT HREMP_EMPCODE, HREMP_FNAME +' '+HREMP_LNAME AS [EmpName] FROM HREMP WHERE HREMP_STATUS = 1 AND HREMP_ORG = 20";
    $stmtEmp = $conn2->prepare($sqlEmp);
    $stmtEmp->execute();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1200;url=http://172.16.98.171/srspa/" />
    <title>SR SPA</title>

    <?php include 'head.php'; ?>

    <script>
        document.addEventListener('touchmove', function(event) {
            event.preventDefault();
        }, {
            passive: false
        });
    </script>

<body id="body" oncontextmenu="return false;">
    <?php include 'header.php'; ?>

    <div class="container" style="margin-top: 55px;">
        <div class="row">
            <div class="table-responsive">
                <form name="FrmSpaSurvey" id="FrmSpaSurvey" method="POST" action="#">
                    <table class="table table-responsive table-hover table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-center text-nowrap"><i class="glyphicon glyphicon-grain"></i> <label for="">Would you mind to evaluation for your spa service</label> <i class="glyphicon glyphicon-grain"></i></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <span id="DocNo" class="hidden"></span>
                                        <select name="EmpName" id="EmpName" class="form-control" required>
                                            <option value="">Therapist name / ชื่อพนักงานนวด</option>
                                            <?php
                                            while ($emp = $stmtEmp->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?= $emp['EmpName']; ?>"><?= $emp['HREMP_EMPCODE']; ?> - <?= $emp['EmpName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                                <td class="text-center"><label>Rating</label></td>
                            </tr>
                            <?php
                            $i = 0;

                            while ($question = $stmtQ->FETCH(PDO::FETCH_ASSOC)) {
                                $i = $i + 1;
                                ?>
                                <tr>
                                    <td style="vertical-align: middle"><?= $question['Question']; ?></td>
                                    <td class="text-center star-rating" style="text-align: center">
                                        <?php
                                        $sqlStar = "SELECT * FROM Rating ORDER BY RateID DESC";
                                        $stmtStar = $conn->prepare($sqlStar);
                                        $stmtStar->execute();

                                        while ($star = $stmtStar->FETCH(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <input id="<?= $star['RateID'] . $i; ?>" type="radio" name="<?= $question['QuesID']; ?>" value="<?= $star['RateStar']; ?>">
                                            <label for="<?= $star['RateID'] . $i; ?>" data-toggle="tooltip" data-placement="left" title="<?= $star['RateDesc']; ?>">
                                                <i class="active fa fa-star fa-2x" aria-hidden="true" style="text-align: center"></i>
                                            </label>

                                        <?php } ?>
                                    </td>
                                </tr>

                            <?php }
                            $conn = NULL; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <textarea name="Comments" id="Comments" cols="30" rows="3" class="form-control" style="resize: vertical" placeholder="Other comment / ข้อเสนอแนะอื่นๆ"></textarea>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-share"></i> Submit / ส่ง</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php include 'modals/modal_setting.php'; ?>

    <?php include 'footer.php'; ?>

</body>

</html>