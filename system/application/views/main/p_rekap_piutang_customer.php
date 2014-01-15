<?php
/* 	
	GIOV Solution - Keep IT Simple
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Lesson Report <?php echo $periode; ?> Group By Customer</title>
<link rel='stylesheet' type='text/css' href='../assets/modules/main/css/printstyle.css'/>
</head>
<body onload="window.print();">
<table width=500>
<caption>Laporan Lesson Report <br/><?php echo $periode; ?> <br/>Group By Customer</caption>
<tr>
	<td>Nama</td>
	<td>:</td>
	<td><?=$cust;?></td>
</tr>
</table>
<table summary='Rekap Piutang Customer'>
	
	<thead>
       	<tr>
        	<th rowspan="1" scope='col'>No</th>
            <th rowspan="1" scope='col'>Daily Schedule</th>           
			<th rowspan="1" scope='col'>Time</th>
			<th rowspan="1" scope='col' width=120>Subject</th>
			<th rowspan="1" scope='col' width=120>Teacher Report</th>
		</tr>
    </thead>
	<tbody>
		<?php $i=0; $j=0; $cust=""; 
				$total_tunai=0;
				$total_card=0;
				$total_cek=0;
				$total_transfer=0;
				$total_kuitansi=0;
				$total_piutang=0;
				$total_sisa=0;
		
				foreach($data_print as $print) { ?>
           <tr>
                <td><b><? $j++; echo $j; ?></b></td>
           
			<?php 
				$i=0; 
				/*$total_piutang+=$print->piutang_total;
				$total_sisa+=$print->piutang_sisa;
				$total_tunai+=$print->piutang_tunai;
				$total_card+=$print->piutang_card;
				$total_cek+=$print->piutang_cek;
				$total_transfer+=$print->piutang_transfer;
		*/	
			?>
           
                <td align="Left" class="text"><?php echo $print->dplan_daily_schedule; ?></td>
                <td align="Left" class="text">
					<table class="clear">
						<tr>
							<td>Week 1 Day 1</td>
						</tr>
						<tr>
							<td>Week 1 Day 2</td>
						</tr>
						<tr>
							<td>Week 2 Day 1</td>
						</tr>
						<tr>
							<td>Week 2 Day 2</td>
						</tr>
						<tr>
							<td>Week 3 Day 1</td>
						</tr>
						<tr>
							<td>Week 3 Day 2</td>
						</tr>
						<tr>
							<td>Week 4 Day 1</td>
						</tr>
						<tr>
							<td>Week 4 Day 2</td>
						</tr>
					</table>
				
				</td>
				<td align="Left" class="text">
					<table class="clear" width=120>
						<tr>
							<td><?php echo $print->dplan_week1_1;?></td>
						<tr>
							<td><?php echo $print->dplan_week1_2;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week2_1;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week2_2;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week3_1;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week3_2;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week4_1;?></td>
						</tr>
						<tr>
							<td><?php echo $print->dplan_week4_2;?></td>
						</tr>
					</table>
				
				</td>
           </tr>
		<?php } ?>
	</tbody>
	<? /*
    <tfoot>
    	<tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row'>Total</th>
            <td colspan='7'><?php echo count($data_print); ?> data</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' colspan="8">Summary</th>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Piutang (Rp)</th>
            <td nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_piutang,0,",",","); ?></td>
            <td colspan='6' class="foot">&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Tunai (Rp)</th>
            <td scope='row' nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_tunai,0,",",","); ?></td>
            <td colspan='6' class="foot">&nbsp;</td>
        </tr>
		<tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Card (Rp)</th>
            <td class="numeric foot" nowrap="nowrap"><?php echo number_format($total_card,0,",",","); ?></td>
             <td colspan='6' class="foot">&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Cek (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_cek,0,",",","); ?></td>
             <td colspan='6' class="foot">&nbsp;</td>
        </tr>

        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Transfer (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_transfer,0,",",","); ?></td>
             <td colspan='6' class="foot" >&nbsp;</td>
        </tr>
        <tr>
        	<td class="foot">&nbsp;</td>
        	<th scope='row' nowrap="nowrap">Total Sisa (Rp)</th>
            <td  nowrap="nowrap" align="right" class="numeric foot"><?php echo number_format($total_sisa,0,",",","); ?></td>
             <td colspan='6' class="foot" >&nbsp;</td>
        </tr>
	</tfoot>
	*/ ?>
</table>
</body>
</html>