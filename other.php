<?php
include ("top.php");

$startDate = "";
$endDate = "";

// At first, include all
$query = "SELECT Advisement.AdvisorID, Advisement.Date, Advisors.FirstName, Advisors.LastName, COUNT(Advisement.AdvisorID)
            FROM `Advisement`    
      INNER JOIN Advisors ON Advisors.ID = Advisement.AdvisorID" .
         " WHERE Advisement.Date BETWEEN '" . JAMBOREE_2022 . "' AND '" . YEAR_END_2022 . "' " .
       "GROUP BY Advisement.AdvisorID
        ORDER BY COUNT(Advisement.AdvisorID) DESC";

if ($thisDatabaseReader->querySecurityOk($query, 1, 2, 4 )) {
    $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
    $advisorRecords = $thisDatabaseReader->select($query, '');
}

$query = "SELECT Advisement.RefereeID, Advisement.Date, AVG(Advisement.Score), Referees.FirstName, Referees.LastName, COUNT(Advisement.RefereeID)
            FROM `Advisement`
      INNER JOIN Referees ON Referees.ID = Advisement.RefereeID" .
         " WHERE Advisement.Date BETWEEN '" . YEAR_START_2022 . "' AND '" . YEAR_END_2022 . "' " .
       "GROUP BY Advisement.RefereeID
        ORDER BY AVG(Advisement.Score) DESC";

if ($thisDatabaseReader->querySecurityOk($query, 1, 2, 4, 0, 0)) {
    $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
    $refRecords = $thisDatabaseReader->select($query, '');
}

if (isset($_GET["btnSubmit"])) {
    $conditions = 2;
    $symbols = 0;
    $quotes = 0;
    $query = "      SELECT Advisement.AdvisorID, Advisement.Date, Advisors.FirstName, Advisors.LastName, COUNT(Advisement.AdvisorID)
                      FROM `Advisement`
                INNER JOIN Advisors ON Advisors.ID = Advisement.AdvisorID";

    if ($_GET["year"] != "" or $_GET["season"] != "") {
        $symbols = 0;
        $conditions = 2;
        $quotes = 4;
        switch ($_GET["year"]) {
            case "all":
                switch ($_GET["season"]) {
                    case "spring":
                    case "jamboree":
                    case "tournaments":
                    case "fall":
                    case "all":
                        $startDate = JAMBOREE_2021;
                        $endDate = YEAR_END_2025;
                        break;
                }
                break;
            case "2021":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = JAMBOREE_2021;
                        $endDate = YEAR_END_2021;
                        break;
                    case "jamboree":
                        $startDate = YEAR_START_2021;
                        $endDate = JAMBOREE_2021;
                        break;
                    case "spring":
                        $startDate = JAMBOREE_2021;
                        $endDate = VSL_SPRING_2021;
                        break;
                    case "tournaments":
                        $startDate = VSL_SPRING_2021;
                        $endDate = TOURNAMENTS_2021;
                        break;
                    case "fall":
                        $startDate = TOURNAMENTS_2021;
                        $endDate = YEAR_END_2021;
                        break;
                }
                break;
            case "2022":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = JAMBOREE_2022;
                        $endDate = YEAR_END_2022;
                        break;
                    case "jamboree":
                        $startDate = YEAR_START_2022;
                        $endDate = JAMBOREE_2022;
                        break;
                    case "spring":
                        $startDate = JAMBOREE_2022;
                        $endDate = VSL_SPRING_2022;
                        break;
                    case "tournaments":
                        $startDate = VSL_SPRING_2022;
                        $endDate = TOURNAMENTS_2022;
                        break;
                    case "fall":
                        $startDate = TOURNAMENTS_2022;
                        $endDate = YEAR_END_2022;
                        break;
                }
                break;
            case "2023":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = JAMBOREE_2023;
                        $endDate = YEAR_END_2023;
                        break;
                    case "jamboree":
                        $startDate = YEAR_START_2023;
                        $endDate = JAMBOREE_2023;
                        break;
                    case "spring":
                        $startDate = JAMBOREE_2023;
                        $endDate = VSL_SPRING_2023;
                        break;
                    case "tournaments":
                        $startDate = VSL_SPRING_2023;
                        $endDate = TOURNAMENTS_2023;
                        break;
                    case "fall":
                        $startDate = TOURNAMENTS_2023;
                        $endDate = YEAR_END_2023;
                        break;
                }
                break;
            case "2024":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = JAMBOREE_2024;
                        $endDate = YEAR_END_2024;
                        break;
                    case "jamboree":
                        $startDate = YEAR_START_2024;
                        $endDate = JAMBOREE_2024;
                        break;
                    case "spring":
                        $startDate = JAMBOREE_2024;
                        $endDate = VSL_SPRING_2024;
                        break;
                    case "tournaments":
                        $startDate = VSL_SPRING_2024;
                        $endDate = TOURNAMENTS_2024;
                        break;
                    case "fall":
                        $startDate = TOURNAMENTS_2024;
                        $endDate = YEAR_END_2024;
                        break;
                }
                break;
            case "2025":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = JAMBOREE_2025;
                        $endDate = YEAR_END_2025;
                        break;
                    case "jamboree":
                        $startDate = YEAR_START_2025;
                        $endDate = JAMBOREE_2025;
                        break;
                    case "spring":
                        $startDate = JAMBOREE_2025;
                        $endDate = VSL_SPRING_2025;
                        break;
                    case "tournaments":
                        $startDate = VSL_SPRING_2025;
                        $endDate = TOURNAMENTS_2025;
                        break;
                    case "fall":
                        $startDate = TOURNAMENTS_2025;
                        $endDate = YEAR_END_2025;
                        break;
                }
                break;
        }
        $query .= "  WHERE Advisement.Date BETWEEN '" . $startDate . "' AND '" . $endDate . "' ";
    }
    $query .="    GROUP BY Advisement.AdvisorID
                  ORDER BY COUNT(Advisement.AdvisorID) DESC";
    if ($thisDatabaseReader->querySecurityOk($query, 1, $conditions, $quotes, $symbols, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
        $advisorRecords = $thisDatabaseReader->select($query, '');
    }

    $symbols = 0;
    $conditions = 2;
    $quotes = 4;
    // Correct start date for jamboree
    if ($_GET["season"] == "all") {
        switch ($_GET["year"]) {
            case "all":
                $startDate = YEAR_START_2021;
                $endDate = YEAR_END_2025;
                break;
            case "2021":
                $startDate = YEAR_START_2021;
                $endDate = YEAR_END_2021;
                break;
            case "2022":
                $startDate = YEAR_START_2022;
                $endDate = YEAR_END_2022;
                break;
            case "2023":
                $startDate = YEAR_START_2023;
                $endDate = YEAR_END_2023;
                break;
            case "2024":
                $startDate = YEAR_START_2024;
                $endDate = YEAR_END_2024;
                break;
            case "2025":
                $startDate = YEAR_START_2025;
                $endDate = YEAR_END_2025;
                break;
       }
    }
    $query = "   SELECT Advisement.RefereeID, Advisement.Date, AVG(Advisement.Score), Referees.FirstName, Referees.LastName, COUNT(Advisement.RefereeID)
                   FROM `Advisement`
             INNER JOIN Referees ON Referees.ID = Advisement.RefereeID";
    $query .= "   WHERE Advisement.Date BETWEEN '" . $startDate . "' AND '" . $endDate . "' ";
    $query .= "GROUP BY Advisement.RefereeID
                  ORDER BY AVG(Advisement.Score) DESC";

    if ($thisDatabaseReader->querySecurityOk($query, 1, $conditions, $quotes, $symbols, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
        $refRecords = $thisDatabaseReader->select($query, '');
    }
}
?>
<article id="main" class="container">
    <section>
        <?php
        include ("seasonYearFilter.php");
        ?>
    <br>
    <?php
    if ($_GET["season"] != "jamboree") {
    ?>
    <caption><strong>Advisor Information</strong></caption>
    <table class="table table-striped table-light" style="margin-top: 15px;">
        <tr>
            <th class="w-33" scope="col">Advisor</th>
            <th class="w-33" scope="col"># Games</th>
            <th class="w-33" scope="col">Payment Due</th>
        </tr>
        <?php
        $totalPayment = 0;
        $totalGames = 0;
        $numAdvisors = 0;
        foreach ($advisorRecords as $advisor) {
            print '<tr>';
            print '<td>' . $advisor['LastName'] . ', ' . $advisor['FirstName'] . '</td>';
            print '<td>' . $advisor['COUNT(Advisement.AdvisorID)'] . '</td>';
            $totalGames = $totalGames + $advisor['COUNT(Advisement.AdvisorID)'];
            $payment = $advisor['COUNT(Advisement.AdvisorID)'] * ADVISOR_PAY;
            $totalPayment = $totalPayment + $payment;
            ++$numAdvisors;
            $formattedPay = "$" . number_format($payment, 2, '.', ',');
            print '<td>' . $formattedPay . '</td>';
            print '</tr>' . PHP_EOL;
        }
        print '<tr>';
        print '<td><strong>Totals (' . $numAdvisors . ' Advisors)</strong></td>';
        print '<td><strong>' . $totalGames . '</strong></td>';
        $formattedPay = "$" . number_format($totalPayment, 2, '.', ',');
        print '<td><strong>' . $formattedPay . '</strong></td>';
        print '</tr>' . PHP_EOL;
        print '</table>';
        // Putting 'or empty($_GET)' is basically making that season/year the default
        if ($_GET["season"] == "jamboree" or $_GET["season"] == "all" or empty($_GET)) {
            jamboreeDisplay();
        } // if not all or jamboree
    } // if not all
    if ($_GET["season"] == "jamboree") {
        jamboreeDisplay();
    }
    ?>
    <br>
    <caption><strong>Referee Information</strong></caption>
    <table class="table table-striped table-light" style="margin-top: 15px;">
        <tr>
            <th class="w-33" scope="col">Referee</th>
            <th class="w-33" scope="col"># Games</th>
            <th class="w-33" scope="col">Average Score</th>
        </tr>
        <?php
        $totalGames = 0;
        $totalScore = 0;
        $numReferees = 0;
        $avgScore = 0;
        foreach ($refRecords as $ref) {
            if ($ref['COUNT(Advisement.RefereeID)'] > 0) {
                print '<tr>';
                print '<td>' . $ref['LastName'] . ', ' . $ref['FirstName'] . '</td>';
                print '<td>' . $ref['COUNT(Advisement.RefereeID)'] . '</td>';
                $avgScore = round($ref['AVG(Advisement.Score)'], 1 , PHP_ROUND_HALF_UP);
                print '<td>' . $avgScore . '</td>';
                print '</tr>' . PHP_EOL;
                $totalGames += $ref['COUNT(Advisement.RefereeID)'];
                $totalScore += $ref['AVG(Advisement.Score)'];
                $numReferees += 1;
            }
        }
        if ($numReferees != 0) {
            $avgScore = round((float)$totalScore / (float)$numReferees, 1, PHP_ROUND_HALF_UP);
        } else {
            $avgScore = 0.0;
        }
        print '<tr>';
        print '<td><strong>Totals</strong></td>';
        print '<td><strong>' . $totalGames . '</strong></td>';
        print '<td><strong>' . $avgScore . '</strong></td>';
        print '</tr>' . PHP_EOL;

        function jamboreeDisplay(): void {
            if ($_GET["year"] == "2021") {
                include("jamboree/jamboree_2021.html");
            }
            else if ($_GET["year"] == "2022" or empty($_GET)) { // or empty($_GET) is for current year
                include("jamboree/jamboree_2022.html");
            }
            else if ($_GET["year"] == "2023") {
                include("jamboree/jamboree_2023.html");
            }
            else if ($_GET["year"] == "2024") {
                include("jamboree/jamboree_2024.html");
            }
            else if ($_GET["year"] == "2025") {
                include("jamboree/jamboree_2025.html");
            }
            else {
                include("jamboree/jamboree_2021.html");
                include("jamboree/jamboree_2022.html");
                //include("jamboree/jamboree_2023.html");
                //include("jamboree/jamboree_2024.html");
                //include("jamboree/jamboree_2025.html");
            }
        }

        ?>
    </table>
    <?php print '<p style="text-align: center; border: 1px solid black; padding: 1em; width: 50%; position: center; margin-left: auto;
                     margin-right: auto;">Number of Referees Advised: ' . $numReferees . '</p>'; ?>
    </section>
</article>


<?php
include ("footer.php");
?>
