<?php

require __DIR__ . '/../includes/globals.php';

global $c, $db, $domain, $h, $ir, $set, $userid;

echo '<h3>The MonoPaper</h3>';
$news = $db->execute('SELECT content FROM papercontent')->fetchColumn();

echo '
<table width="75%" cellspacing="1" class="table">
		<tr style="text-align: center; font-weight: bold;">
			<td width="34%"><a href="job.php">YOUR JOB</a></td>
			<td width="34%"><a href="gym.php">LOCAL GYM</a></td>
			<td width="34%"><a href="halloffame.php">HALL OF FAME</a></td>
		</tr>
		<tr>
			<td width="34%"><img src="ad_filler.png" alt="Ad" title="Ad" /></td>
			<td colspan="2">' . nl2br(htmlentities($news === false ? '' : $news))
        . '</td>
		</tr>
</table>
   ';
$h->endpage();
