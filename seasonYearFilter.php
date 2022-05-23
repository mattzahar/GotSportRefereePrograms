<form action = "<?php print PHP_SELF; ?>"
      id="seasons"
      method = "get"
      class = "seasons"
      style="text-align: center; position: center;">
    <fieldset class="seasons" style="margin-bottom: 0; padding-bottom: 2px;">
        <h3>Sort by Season</h3>
            <?php
            if (isset($_GET["btnSubmit"])) {
                /* YEAR FILTER */
                print '<label for="year">Year:</label>' . PHP_EOL;
                print '<select name="year" id="year">' . PHP_EOL;
                if ($_GET["year"] == "all") {
                    print '<option value="all" selected>All</option>' . PHP_EOL;
                } else {
                    print '<option value="all">All</option>' . PHP_EOL;
                }
                if ($_GET["year"] == "2021" or $_GET["year"] == "" or $_GET["year"] == null) {
                    print '<option value="2021" selected>2021</option>' . PHP_EOL;
                } else {
                    print '<option value="2021">2021</option>' . PHP_EOL;
                }
                if ($_GET["year"] == "2022") {
                    print '<option value="2022" selected>2022</option>' . PHP_EOL;
                } else {
                    print '<option value="2022">2022</option>' . PHP_EOL;
                }
                if ($_GET["year"] == "2023") {
                    print '<option value="2023" selected>2023</option>' . PHP_EOL;
                } else {
                    print '<option value="2023">2023</option>' . PHP_EOL;
                }
                if ($_GET["year"] == "2024") {
                    print '<option value="2024" selected>2024</option>' . PHP_EOL;
                } else {
                    print '<option value="2024">2024</option>' . PHP_EOL;
                }
                if ($_GET["year"] == "2025") {
                    print '<option value="2025" selected>2025</option>' . PHP_EOL;
                } else {
                    print '<option value="2025">2025</option>' . PHP_EOL;
                }
                print '</select>' . PHP_EOL;
                /* SEASON FILTER */
                print '<label for="season">Season:</label>' . PHP_EOL;
                print '<select name="season" id="season">' . PHP_EOL;
                if ($_GET["season"] == "all" or $_GET["season"] == "" or $_GET["season"] == null) {
                    print '<option value="all" selected>All</option>' . PHP_EOL;
                } else {
                    print '<option value="all">All</option>' . PHP_EOL;
                }
                if ($_GET["season"] == "jamboree") {
                    print '<option value="jamboree" selected>Jamboree</option>' . PHP_EOL;
                } else {
                    print '<option value="jamboree">Jamboree</option>' . PHP_EOL;
                }
                if ($_GET["season"] == "spring") {
                    print '<option value="spring" selected>Spring</option>' . PHP_EOL;
                } else {
                    print '<option value="spring">Spring</option>' . PHP_EOL;
                }
                if ($_GET["season"] == "tournaments") {
                    print '<option value="tournaments" selected>Tournaments</option>' . PHP_EOL;
                } else {
                    print '<option value="tournaments">Tournaments</option>' . PHP_EOL;
                }
                if ($_GET["season"] == "fall") {
                    print '<option value="fall" selected>Fall</option>' . PHP_EOL;
                } else {
                    print '<option value="fall">Fall</option>' . PHP_EOL;
                }
                print '</select>' . PHP_EOL;
            }
            else {
                /* YEAR FILTER */
                print '<label for="year">Year:</label>' . PHP_EOL;
                print '<select name="year" id="year">' . PHP_EOL;
                if ($_SERVER['REQUEST_URI'] == "/lookup.php") {
                    print '<option value="all" selected>All</option>' . PHP_EOL;
                } else {
                    print '<option value="all">All</option>' . PHP_EOL;
                }
                print '<option value="2021">2021</option>' . PHP_EOL;
                if ($_SERVER['REQUEST_URI'] == "/lookup.php") {
                    print '<option value="2022">2022</option>' . PHP_EOL;
                } else {
                    print '<option value="2022" selected>2022</option>' . PHP_EOL;
                }
                print '<option value="2023">2023</option>' . PHP_EOL;
                print '<option value="2024">2024</option>' . PHP_EOL;
                print '<option value="2025">2025</option>' . PHP_EOL;
                print '</select>' . PHP_EOL;
                /* SEASON FILTER */
                print '<label for="season">Season:</label>' . PHP_EOL;
                print '<select name="season" id="season">' . PHP_EOL;
                print '<option value="all" selected>All</option>' . PHP_EOL;
                print '<option value="jamboree">Jamboree</option>' . PHP_EOL;
                print '<option value="spring">Spring</option>' . PHP_EOL;
                print '<option value="tournaments">Tournaments</option>' . PHP_EOL;
                print '<option value="fall">Fall</option>' . PHP_EOL;
                print '</select>' . PHP_EOL;
            }
            //                if (isset($_GET["btnSubmit"])) {
            //                    if ($_GET["season"] == "all") {
            //                        print '<input type="radio" id="all" name="season" value="all" checked/>' . PHP_EOL;
            //                    } else {
            //                        print '<input type="radio" id="all" name="season" value="all"/>' . PHP_EOL;
            //                    }
            //                    print '<label class="form-label" for="all">All</label>';
            //                    if ($_GET["season"] == "jamboree_2021") {
            //                        print '<input type="radio" id="jamboree_2021" name="season" value="jamboree_2021" checked/>' . PHP_EOL;
            //                    } else {
            //                        print '<input type="radio" id="jamboree_2021" name="season" value="jamboree_2021"/>' . PHP_EOL;
            //                    }
            //                    print '<label for="jamboree_2021">Jamboree 2021</label>';
            //                    if ($_GET["season"] == "spring_2021") {
            //                        print '<input type="radio" id="spring_2021" name="season" value="spring_2021" checked/>' . PHP_EOL;
            //                    } else {
            //                        print '<input type="radio" id="spring_2021" name="season" value="spring_2021"/>' . PHP_EOL;
            //                    }
            //                    print '<label class="form-label" for="spring_2021">VSL Spring 2021</label>';
            //                    if ($_GET["season"] == "tournaments_2021") {
            //                        print '<input type="radio" id="tournaments_2021" name="season" value="tournaments_2021" checked/>' . PHP_EOL;
            //                    } else {
            //                        print '<input type="radio" id="tournaments_2021" name="season" value="tournaments_2021"/>' . PHP_EOL;
            //                    }
            //                    print '<label class="form-label" for="tournaments_2021">Tournaments 2021</label>';
            //                    if ($_GET["season"] == "fall_2021") {
            //                        print '<input type="radio" id="fall_2021" name="season" value="fall_2021" checked/>' . PHP_EOL;
            //                    } else {
            //                        print '<input type="radio" id="fall_2021" name="season" value="fall_2021"/>' . PHP_EOL;
            //                    }
            //                    print '<label class="form-label" for="fall_2021">VSL Fall 2021</label>';
            //                } else {
            //                    print '<input type="radio" id="all" name="season" value="all" checked/>';
            //                    print '<label class="form-label" for="all">All</label>';
            //                    print '<input type="radio" id="jamboree_2021" name="season" value="jamboree_2021"/>';
            //                    print '<label for="jamboree_2021">Jamboree 2021</label>';
            //                    print '<input type="radio" id="spring_2021" name="season" value="spring_2021"/>';
            //                    print '<label class="form-label" for="spring_2021">VSL Spring 2021</label>';
            //                    print '<input type="radio" id="tournaments_2021" name="season" value="tournaments_2021"/>';
            //                    print '<label class="form-label" for="tournaments_2021">Tournaments 2021</label>';
            //                    print '<input type="radio" id="fall_2021" name="season" value="fall_2021"/>';
            //                    print '<label class="form-label" for="fall_2021">VSL Fall 2021</label>';
            //                }
            //
            //    if ($_GET["season"] == "jamboree_2021") {
            //        $query .= "  WHERE Advisement.Date BETWEEN '" . START_JAMBOREE_2021 . "' AND '" . JAMBOREE_2021 . "' ";
            //        $symbols = 0;
            //        $conditions = 2;
            //        $quotes = 4;
            //    } else if ($_GET["season"] == "spring_2021") {
            //        $query .= "  WHERE Advisement.Date BETWEEN '" . JAMBOREE_2021 . "' AND '" . VSL_SPRING_2021 . "' ";
            //        $symbols = 0;
            //        $conditions = 2;
            //        $quotes = 4;
            //    } else if ($_GET["season"] == "tournaments_2021") {
            //        $query .= "  WHERE Advisement.Date BETWEEN '" . VSL_SPRING_2021 . "' AND '" . TOURNAMENTS_2021 . "' ";
            //        $symbols = 0;
            //        $conditions = 2;
            //        $quotes = 4;
            //    } else if ($_GET["season"] == "fall_2021") {
            //        $query .= "  WHERE Advisement.Date BETWEEN '" . TOURNAMENTS_2021 . "' AND '" . VSL_FALL_2021 . "' ";
            //        $symbols = 0;
            //        $conditions = 2;
            //        $quotes = 4;
            //    }
            ?>
        <!-- Start Submit button -->
        <input
            class="btn btn-primary"
            id="btnSubmit"
            style="display: inline;"
            name="btnSubmit"
            type="submit"
            value="Filter"/>
        <!-- ends submit button -->
    </fieldset>
</form>
