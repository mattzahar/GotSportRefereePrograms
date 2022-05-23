<?php
include ("top.php");

$startDate = "";
$endDate = "";

$query = "        SELECT Advisement.Date, Advisement.Time, Advisement.Location, Advisement.ID,
                         Referees.FirstName, Referees.LastName, Advisors.FirstName, Advisors.LastName
                    FROM `Advisement`
              INNER JOIN Advisors ON Advisors.ID = Advisement.AdvisorID
              INNER JOIN Referees ON Referees.ID = Advisement.RefereeID
                ORDER BY `Date` DESC, `Time` DESC";
if ($thisDatabaseReader->querySecurityOk($query, 0, 1, 0, 0, 0)) {
    $query = $thisDatabaseReader->sanitizeQuery($query, 0, 0, 0, 0, 0);
    $reports = $thisDatabaseReader->select($query, '');
}
if (isset($_GET["btnSubmit"])) {
    $conditions = 2;
    $symbols = 0;
    $quotes = 0;
    $query = "    SELECT Advisement.Date, Advisement.Time, Advisement.Location, Advisement.ID,
                         Referees.FirstName, Referees.LastName, Advisors.FirstName, Advisors.LastName
                    FROM `Advisement`
              INNER JOIN Advisors ON Advisors.ID = Advisement.AdvisorID
              INNER JOIN Referees ON Referees.ID = Advisement.RefereeID
                ";
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
                        $startDate = YEAR_START_2021;
                        $endDate = YEAR_END_2025;
                        break;
                }
                break;
            case "2021":
                switch ($_GET["season"]) {
                    case "all":
                        $startDate = YEAR_START_2021;
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
                        $startDate = YEAR_START_2022;
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
                        $startDate = YEAR_START_2023;
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
                        $startDate = YEAR_START_2024;
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
                        $startDate = YEAR_START_2025;
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

    $query .= "   ORDER BY `Date` DESC, `Time` DESC";
    if ($thisDatabaseReader->querySecurityOk($query, 1, $conditions, $quotes, $symbols, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
        $reports = $thisDatabaseReader->select($query, '');
    }
}
?>

<article id="main" class="container">
    <section>
        <?php
        include ("seasonYearFilter.php");
        ?>
        <caption><h2><strong>Advisor Reports</strong></h2></caption>
        <p>Results Returned: <?php print sizeof($reports); ?></p>
        <table id="lookup" class="table table-striped table-light lookup">
            <tbody id="lookup" class="lookup">
                <tr>
                    <th scope="col">Referee</th>
                    <th scope="col">Advisor</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Location</th>
                </tr>
                <?php
                foreach ($reports as $report) {
                    print '<tr>';
                    print '<td><a href="../report.php?reportID=' . $report['ID'] . '">' . $report[4] . ' ' .  $report[5] . '</a></td>';
                    print '<td><a href="../report.php?reportID=' . $report['ID'] . '">' . $report['FirstName'] . ' ' .  $report['LastName'] . '</a></td>';
                    print '<td><a href="../report.php?reportID=' . $report['ID'] . '">' . $report['Date'] . '</a></td>';
                    print '<td><a href="../report.php?reportID=' . $report['ID'] . '">' . $report['Time'] . '</a></td>';
                    print '<td><a href="../report.php?reportID=' . $report['ID'] . '">' . $report['Location'] . '</a></td>';
                    print '</tr>' . PHP_EOL;
                }
                ?>
            </tbody>
        </table>
        <script>
            jQuery('#lookup').ddTableFilter();
        </script>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </section>
</article>
<br>
<?php
include ("footer.php");
?>
