<?php echo $this->element('check_login'); ?>
<table>
	<tr>
		<th>Body</th>
	</tr>
	<?php foreach ($comments as $comment) { ?>
	<tr>
		<td><?php echo $comment->body; ?></td>
	</tr>
	<?php } ?>
</table>