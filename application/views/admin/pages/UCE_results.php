<style>
p{
	font-family:Bell MT;
	padding-left:130px;
	font-size:18px;
	color:#4169E1;
	position: relative;
	margin-left:100px;
}
span.right{
	
	font-weight:bold;
	color:#4169E1;
	float:right;
	position: relative;
	top:-5px;
	right: 50px;
}
span{
	text-align: center;
	}
	
h1{
	padding-left:300px;
	font-family:Algerian;
	font-size:40px;
	position: relative;
	margin-top:-100px;
	position: relative;
	left: 50px;
}

.logo {
	position: relative;
		top:-40px;
	}
</style>
 
<?php 
	$entry = ['', 'UCE', 'UACE'];

	$title = [
		'',
		'UGANDA CERTIFICATE OF EDUCATION',
		'UGANDA ADVANCED CERTIFICATE OF EDUCATION'
	];
?>

<table width='100%'>
<caption>
	<span class="right"> <?php echo $results['student']['academic_year'] . '&nbsp;' . $entry[$results['student']['entry'] ];  ?></span>
	<span><img src="<?php echo base_url()?>/images/logo.png" alt="" class="logo" /></span>
	<h1><?php echo $entry[$results['student']['entry']]; ?> PASS SLIP</h1>
	<br/>
	<p class="text-align: center;">EXAMINATION FOR <?php echo $title[$results['student']['entry']]; ?></p>
</caption>
	<!--<tr>
		<td colspan='3'> <p><center>EXAMINATION FOR THE UGANDA CERTIFICATE OF EDUCATION</center></p>  </td>
	</tr>//-->
	
	<tr>
		<td width="50"></td>
		<td style="font-weight:bold;"> <?php echo $results['student']['name']; ?></td>
		<td> (AGE 18) </td>
		<td> <?php echo $results['student']['stud_reg_no']; ?></td>
	</tr>
	
	<tr>
		<td width="50"></td>
		<td colspan="2"><?php echo $results['school']['name']; ?></td>
		<td> ENTRY CODE 5</td>
	</tr>
	<tr height="25px">
	</tr>
	<?php foreach ($results['subject'] as $key => $value) { ?>
		<tr>
			<td width="50"> </td>
			<td><?php echo $value['subject']; ?> </td>
			<td><?php echo $value['aggregate']; ?></td>
		</tr>
	<?php
	}?>
	</br>
	</br>
	<tr>
		<td width="50"> </td>
		<td style="font-weight:bold"> Grade Aggreagate</td>
		<td style="font-weight:bold"> <?php echo $results['finalGrade']; ?> </td>
	</tr>
</table> 
<br/>
<input class="btn btn-warning" type="Button" Value="EXPORT PASS-SLIP"/>