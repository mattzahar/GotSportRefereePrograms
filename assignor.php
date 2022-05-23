<?php
include ("top.php");
// Check if the user passed authentication
if ($_SESSION['loggedIn'] == false) {
    // Redirect to the authentication page
    header('Location: /authenticate.php');
}

$u12Needed = false;
$file = "";

if (isset($_GET["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Sanitize (clean) data
    //$PIN = htmlentities($_GET["pin"], ENT_QUOTES, "UTF-8");

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    $errorMsg = "";

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Process Form - Passed Validation
    //
    if ($errorMsg == "") {
    } else {
    }
}
?>
<article style="align-content: center; text-align: center; width: 50%">
    <h1><strong>Assignor Resources</strong></h1>
    <body>
        <h2><strong>Helpful Files:</strong></h2>
        <h3>2022</h3>
        <a href="files/2022%20Licensed%20VT%20Referee_Master%20List_as%20of%204.9.22_V1.xlsx" target="_blank">2022 CERTIFIED REFEREE LIST</a>
        <br>
        <a href="files/2022_VT_Referee_Master_Email_List.txt" target="_blank">2022 EMAIL LIST</a>
        <h3>2021</h3>
        <a href="files/2021 Licensed VT Referee_Master List_as of 4.26.21.xlsx" target="_blank">2021 CERTIFIED REFEREE LIST</a>
        <br>
        <a href="files/UPDATED_ref_email_list.txt" target="_blank">2021 EMAIL LIST</a>
    </body>
    <!--
    <section>
        <h2>The form below doesn't work right now.</h2>
        <h2><strong>GotSport Open Game / Mentor Reports</strong></h2>
        <form action = "<?php //print PHP_SELF; ?>"
              onsubmit = "return checkBeforeSubmit()"
              id = "ratingForm"
              method = "get"
              class = "form_container form"
              style="padding: 5% 10%;">
            <script type="text/javascript">
                var wasSubmitted = false;
                function checkBeforeSubmit(){
                    if(!wasSubmitted) {
                        wasSubmitted = true;
                        return wasSubmitted;
                    }
                    return false;
                }
            </script>
            <fieldset class="reporttypes">
                <section class="col-25">
                    <h3>Pick the Reports you want to generate</h3>
                    <div>
                        <input class="form-checkbox" type="checkbox" id="openGames" name="openGames">
                        <label for="openGames">Open Games</label>
                    </div>

                    <div>
                        <input class="form-checkbox" type="checkbox" id="openGamesDetailed" name="openGamesDetailed">
                        <label for="openGamesDetailed">Open Games Detailed</label>
                    </div>

                    <div>
                        <input class="form-checkbox" type="checkbox" id="advisor" name="advisor">
                        <label for="advisor">Advisor</label>
                    </div>
                </section>
            </fieldset>
            <fieldset>
                <h3>Include ARs for U12 Games?</h3>
                <input class="form-radio" type="radio" id="yes" name="u12Needed" value="true" <?php if($u12Needed === true) echo 'checked'; ?>/>
                <label class="form-label" for="yes">Yes</label>
                <input class="form-radio" type="radio" id="no" name="u12Needed" value="false" <?php if($u12Needed === false) echo 'checked'; ?>/>
                <label class="form-label" for="no">No</label>
            </fieldset>
            <fieldset>
                <h3>Attach the gotSport .csv File</h3>
                <div>
                    <label for="file">Choose file to upload</label>
                    <input type="file" id="file" name="file" accept=".csv"/>
                </div>
            </fieldset>
            <hr>
            <-- Start Submit button ->
            <fieldset style="margin-top: 5%; text-align: center;">
                <input
                        class="btn btn-primary"
                        onclick="this.value='Submitting, please wait...';"
                        id="btnSubmit"
                        name="btnSubmit"
                        type="submit"
                        value="Submit Report"/>
            </fieldset>
            <-- ends submit button ->
        </form>
    </section>
    -->
</article>
<?php
include ("footer.php");
?>
