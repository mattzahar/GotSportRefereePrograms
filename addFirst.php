<?php
include ("top.php");

// Get URL
$thisURL = DOMAIN . PHP_SELF;

$referee = -2;
$refereeError = false;

$advisor = -2;
$advisorError = false;

$errorMsg = array();
$reports = array();

if (isset($_GET["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Security
    //
    //    if (securityCheck($thisURL)) {
    //        $msg = '<p class="container">Sorry you cannot access this page. ';
    //        $msg .= 'Security breach detected and reported.</p>';
    //        print($msg);
    //    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Sanitize (clean) data
    $referee = htmlentities($_GET["referee"], ENT_QUOTES, "UTF-8");
    $advisor = htmlentities($_GET["advisor"], ENT_QUOTES, "UTF-8");

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    if ($referee == -2) {
        $errorMsg[] = 'Please Select Referee';
        $refereeError = true;
    } elseif (!verifyNumeric($referee)) {
        $errorMsg[] = 'Invalid Referee';
        $refereeError = true;
    }

    if ($advisor == -2) {
        $errorMsg[] = 'Please Select Advisor';
        $advisorError = true;
    } elseif (!verifyNumeric($advisor)) {
        $errorMsg[] = 'Invalid Advisor';
        $advisorError = true;
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Process Form - Passed Validation
    
    if (empty($errorMsg)) {
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Save/Delete Data
        //
        // This block saves the data to the global variables in top to pass to next form or deletes it

        if (isset($_GET["btnSubmit"])) {
            header('Location: https://vtsrc.com/addSecond.php' . '?refereeID=' . strval($referee) . '&advisorID=' . strval($advisor));
            ob_clean();
            exit();
        }
    }
}

?>

<body>

    <?php
    print '';

    //#########################################################################
    //
    // Error Messages
    //
    if ($errorMsg) {
        print '<section id="errors">' . PHP_EOL;
        print '<h3>Your form has the following mistakes that need to be fixed.</h3>' . PHP_EOL;
        print '<ol>' . PHP_EOL;

        foreach ($errorMsg as $err) {
            print '<li>' . $err . '</li><br>' . PHP_EOL;
        }
        print '</ol>' . PHP_EOL;
        print '</section>' . PHP_EOL;
    }
    ?>
    <article class="container">
        <section>
            <form action = "<?php print PHP_SELF; ?>"
              id="frmOption"
              method = "get"
              style="padding: 5% 10%;"
              class="form"
              >

            <div class="row mb-3 form-group">
                <h4>Add Referee to Report</h4>
                <label class="col-sm-2 col-form-label" for="referee">Referee</label>
                <div class="col-sm-10">
                    <select class="form-select" name="referee">
                        <?php
                        $query = "SELECT `ID`,`LastName`, `FirstName`
                                FROM `Referees`
                            ORDER BY `LastName` ASC";
                        if ($thisDatabaseReader->querySecurityOk($query, 0, 1)) {
                            $query = $thisDatabaseReader->sanitizeQuery($query);
                            $referees = $thisDatabaseReader->select($query, '');
                        }
                        ?>
                        <option value="-2" selected>Select Referee</option>
                        <?php
                        if (!(empty($referees))) {
                            foreach ($referees as $ref) {
                                if ($ref['ID'] == $referee) {
                                    print '<option value="' . $ref['ID'] . '" selected>' . $ref['LastName'] . ', ' . $ref['FirstName'] . '</option>';
                                } else {
                                    print '<option value="' . $ref['ID'] . '">' . $ref['LastName'] . ', ' . $ref['FirstName'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="-1" id="referee" name="referee">
                        <label class="form-check-label" for="referee">
                            Add New Referee (if they do not appear in drop down)
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3 form-group">
                <h4>Add Advisor to Report</h4>
                <label class="col-sm-2 col-form-label" for="advisor">Advisor (you)</label>
                <div class="col-sm-10">
                    <select class="form-select" name="advisor">
                        <?php
                        $query = "SELECT `ID`, `LastName`, `FirstName` 
                                    FROM `Advisors` 
                                ORDER BY `LastName` ASC";
                        if ($thisDatabaseReader->querySecurityOk($query, 0, 1, 0, 0, 0)) {
                            $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
                            $advisors = $thisDatabaseReader->select($query, '');
                        }
                        ?>
                        <option value="-2" selected>Select Advisor (You)</option>
                        <?php
                        if (!(empty($advisors))) {
                            foreach ($advisors as $advis) {
                                if ($advis['ID'] == $advisor) {
                                    print '<option value="' . $advis['ID'] . '" selected>' . $advis['LastName'] . ', ' . $advis['FirstName'] . '</option>';
                                } else {
                                    print '<option value="' . $advis['ID'] . '">' . $advis['LastName'] . ', ' . $advis['FirstName'] . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="-1" id="advisor" name="advisor">
                        <label class="form-check-label" for="advisor">
                            Add New Advisor (if you do not appear in drop down)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Start Submit button -->

            <h4>Continue to Create Report</h4>
            <input
                class="btn btn-primary"
                id="btnSubmit"
                name="btnSubmit"
                type="submit"
                value="Continue">


            <!-- ends submit button -->
            </form>
        </section>
    </article>
    <?php
    //} //end body submit
    ?>
</body>
<?php
include ("footer.php");
?>
