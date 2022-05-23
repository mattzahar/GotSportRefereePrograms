<?php
include ("top.php");

$reportID = $_GET["reportID"];

if ($reportID == "") {
    print '<br><br>';
    print '<h2 style="align-content: center; text-align: center">REPORT NOT FOUND</h2>';
}

$query = "SELECT  Advisement.*, Referees.FirstName, Referees.LastName, Advisors.FirstName, Advisors.LastName,
                  Referees.Email, Advisors.Email
            FROM `Advisement`
      INNER JOIN Advisors ON Advisors.ID = Advisement.AdvisorID
      INNER JOIN Referees ON Referees.ID = Advisement.RefereeID
           WHERE Advisement.ID = ?";

if ($thisDatabaseReader->querySecurityOk($query)) {
    $query = $thisDatabaseReader->sanitizeQuery($query);
    $reportArray = $thisDatabaseReader->select($query, array($reportID));
}

foreach ($reportArray as $report) {
    ?>

    <article style="padding: 5% 10%;">
        <main>
            <caption><h3><strong>Report Information</strong></h3></caption>
            <table class="table table-striped table-light" style="table-layout: fixed">
                <tr>
                    <th scope="col">Referee</th>
                    <th scope="col">Advisor</th>
                </tr>
                <?php
                $refName = $report[26] . ' ' . $report[27];
                $advisName = $report['FirstName'] . ' ' . $report['LastName'];
                print '<tr><td>' . $refName . '</td>';
                print '<td>' . $advisName . '</td></tr>' . PHP_EOL;
                print '<tr><td><a href="mailto:' . $report[30] . '">' . $report[30] . '</a></td>';
                print '<td><a href="mailto:' . $report['Email'] . '">' . $report['Email'] . '</a></td></tr>'. PHP_EOL;
                ?>
            </table>
            <br>
            <caption><strong>Game Information</strong></caption>
            <table class="table table-striped table-light" style="table-layout: fixed">
                <?php
                print '<tr><td>Game Date: ' . $report['Date'] . '</td>';
                print '<td>Game Time: ' . $report['Time'] . '</td></tr>' . PHP_EOL;
                print '<tr><td>Location: ' . $report['Location'] . '</td>';
                print '<td>Age/Gender: U' . $report['Age'] . ' ' . $report['Gender'] . '</td></tr>' . PHP_EOL;
                print '<tr><td>Home Team: ' . $report['HomeTeam'] . '</td>';
                print '<td>Away Team: ' . $report['VisitingTeam'] . '</td></tr>' . PHP_EOL;
                ?>
            </table>
            <br>
            <caption><strong>Performance Comments</strong></caption>
            <table id="wider" class="table table-light">
                <tr><td><strong>Things Done Well</strong></td></tr>
                <?php
                $clnOutput = "";
                $clnOutput = str_ireplace("&amp;#39;", "'", $report['Good']);
                $clnOutput = str_ireplace("&amp;#34;", '"', $clnOutput);
                print '<tr><td style="text-align: left">' . $clnOutput . '</td></tr>';
                ?>
                <tr><td><strong>Things To Work On</strong></td></tr>
                <?php
                $clnOutput = "";
                $clnOutput = str_ireplace("&amp;#39;", "'", $report['Bad']);
                $clnOutput = str_ireplace("&amp;#34;", '"', $clnOutput);
                print '<tr><td style="text-align: left">' . $clnOutput . '</td></tr>';
                ?>
                <tr><td><strong>Comments to Bill / Assignors / SRC</strong></td></tr>
                <?php
                $clnOutput = "";
                $clnOutput = str_ireplace("&amp;#39;", "'", $report['Comments']);
                $clnOutput = str_ireplace("&amp;#34;", '"', $clnOutput);
                print '<tr><td style="text-align: left">' . $clnOutput . '</td></tr>';
                ?>
            </table>
            <br>
            <caption><strong>Referee Performance</strong></caption>
            <table class="table table-striped table-light">
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Rating</th>
                </tr>
                <?php
                print '<tr>';
                print '<td>Uniform/Appearance</td>';
                print '<td>' . $report['Appearance'];
                print ' (';
                for ($i = 0; $i < $report['Appearance']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Confidence</td>';
                print '<td>' . $report['Confidence'];
                print ' (';
                for ($i = 0; $i < $report['Confidence']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Positioning</td>';
                print '<td>' . $report['Positioning'];
                print ' (';
                for ($i = 0; $i < $report['Positioning']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Whistle Tones</td>';
                print '<td>' . $report['Whistle'];
                print ' (';
                for ($i = 0; $i < $report['Whistle']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Mechanics</td>';
                print '<td>' . $report['Mechanics'];
                print ' (';
                for ($i = 0; $i < $report['Mechanics']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>LOTG Knowledge</td>';
                print '<td>' . $report['Knowledge'];
                print ' (';
                for ($i = 0; $i < $report['Knowledge']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Enforcement</td>';
                print '<td>' . $report['Enforcement'];
                print ' (';
                for ($i = 0; $i < $report['Enforcement']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Respected Calls</td>';
                print '<td>' . $report['Respect'];
                print ' (';
                for ($i = 0; $i < $report['Respect']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Substitutions</td>';
                print '<td>' . $report['Subs'];
                print ' (';
                for ($i = 0; $i < $report['Subs']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Technical Area</td>';
                print '<td>' . $report['TechArea'];
                print ' (';
                for ($i = 0; $i < $report['TechArea']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td>Feedback Responsiveness</td>';
                print '<td>' . $report['Feedback'];
                print ' (';
                for ($i = 0; $i < $report['Feedback']; $i++) {
                    print '&#9733';
                }
                print ')';
                print '</td>';
                print '</tr>' . PHP_EOL;
                print '<tr>';
                print '<td><strong>Total Score</strong></td>';
                print '<td>' . $report['Score'];
                print '</td>';
                print '</tr>' . PHP_EOL;
                ?>
            </table>
        </main>
        <?php print '<p>Report Submitted On: ' . $report['FilledOn'] . '</p>'; ?>
    </article>
    <br>
<?php
}
include ("footer.php");
?>
