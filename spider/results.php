
<table align="center" cellpadding="5" cellspacing="1" border="1" width="90%">
	<tr>
		<td ><b>URL:</b></font></td><td><a href="<?=$res['url']?>" target="new"><?=$res['url']?></a></td>
	</tr>
	<tr>
		<td ><b>Title:</b></font></td><td><?=$res['meta_tags']['title']?></td>
	</tr>
	<tr>
		<td ><b>Description:</b></font></td><td><?=$res['meta_tags']['description']?></td>
	</tr>
	<tr>
		<td ><b>Keywords:</b></font></td><td><?=$res['meta_tags']['keywords']?></td>
	</tr>
	<tr>
		<td ><b>Size:</b></font></td><td><?=$res['size']?></td>
	</tr>
	<tr>
		<td ><b>Text:</b></font></td><td><?=$res['text']?></td>
	</tr>
	<tr>
		<td ><b>Number of words:</b></font></td><td><?=$res['no_words']?></td>
	</tr>
	<tr>
		<td ><b>Number of distinct words:</b></font></td><td ><?=$res['no_distinct_words']?></td>
	</tr>
	<tr>
		<td valign="top"><b>Keywords</b></font></td><td>
		<table align="left">
		<tr>
			<td valign="top">
			<!-- here goes results for 1 word -->
		<table >
			<tr>

				<td align="center" bgcolor="#DEDEDE"><b>Word</b></font></td>
				<td align="center" bgcolor="#DEDEDE"><b>Count</td>
				<td align="center" bgcolor="#DEDEDE"><b>Density</td>
			</tr>
		
		<?
			$nr_total=count($res['keywords']['1']);
			$x=1;$i=0;
			foreach($res['keywords']['1'] as $k=>$t)
			{
				$density=$t*100/$res['no_words'];
				echo '<tr>';
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$k</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$t</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							";
								printf("%.2f",$density); 
							echo "%</td></tr>";
				$i++;
			}
		?>
		</table>
		
			</td>
			<td valign="top">
			<!-- here goes results for 2 word phrases -->
		<table >
			<tr>

				<td align="center" bgcolor="#DEDEDE"><b>Word</b></font></td>
				<td align="center" bgcolor="#DEDEDE"><b>Count</td>
				<td align="center" bgcolor="#DEDEDE"><b>Density</td>
			</tr>
		
		<?
			$nr_total=count($res['keywords']['2']);
			$x=1;$i=0;
			foreach($res['keywords']['2'] as $k=>$t)
			{
				$density=$t*100/$res['no_words'];
				echo '<tr>';
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$k</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$t</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							";
								printf("%.2f",$density); 
							echo "%</td></tr>";
				$i++;
			}
		?>
		</table>
		
			</td>
			<td valign="top">
			<!-- here goes results for 3 word phrases-->
		<table >
			<tr>

				<td align="center" bgcolor="#DEDEDE"><b>Word</b></font></td>
				<td align="center" bgcolor="#DEDEDE"><b>Count</td>
				<td align="center" bgcolor="#DEDEDE"><b>Density</td>
			</tr>
		
		<?
			$nr_total=count($res['keywords']['3']);
			$x=1;$i=0;
			foreach($res['keywords']['3'] as $k=>$t)
			{
				$density=$t*100/$res['no_words'];
				echo '<tr>';
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$k</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							$t</td>";
							echo "<td align=center bgcolor=\"";if($i/2!=floor($i/2)) echo "#FFFFFF"; else echo "#F6F6FF";echo "\">
							";
								printf("%.2f",$density); 
							echo "%</td></tr>";
				$i++;
			}
		?>
		</table>
		
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td valign="top"><b>Links:</b></font></td><td >
		<?
		foreach($res['links'] as $key=>$link)
		{
			echo '
				<br><a href="'.$link.'" target="new">'.$link.'</a>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td valign="top" >
		<b>HTML:</b>
		</td><td><pre><textarea cols="90" rows="50"  ><? echo htmlentities($res['html']);?></textarea></pre></td>
	</tr>
		
</table>











