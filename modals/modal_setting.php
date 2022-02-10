<?php
include './config/db.php';

try {
    $sqlDept = "SELECT * FROM dbo.Departments";
    $stmtDept = $conn->prepare($sqlDept);
    $stmtDept->execute();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
$conn = NULL;
?>

<!-- Modal Config -->
<div class="modal" id="configModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="glyphicon glyphicon-cog"></i> Setting</h4>
            </div>
            <div class="modal-body">
                <form name="frmConfigModal" id="frmConfigModal" method="POST" action="./">
                    <div class="form-group">
                        <h4>Department:</h4>
                        <input type="hidden" name="getDeptName" id="getDeptName" value="">
                        <select name="deptID" id="deptID" class="form-control">
                            <option value="">select</option>
                            <?php
                            while ($dept = $stmtDept->fetch(PDO::FETCH_NUM)) {
                                echo "<option value='$dept[0]'>$dept[3]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <h4>Location:</h4>
                        <input type="hidden" name="getLocaName" id="getLocaName" value="">
                        <select name="locaID" id="locaID" class="form-control">
                            <option value="">select</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <input type="submit" name="setCookie" id="btnSetCookie" class="btn btn-primary" value="Save">
                        <input type="submit" name="deletCookie" class="btn btn-danger" value="Clear Config">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


