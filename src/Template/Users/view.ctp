<!-- File: src/Template/Users/view.ctp -->
<?php echo $this->Html->link('Back', ['controller' => 'Posts', 'action' => 'index'], ['class' => 'back']) ?>
<?php echo $this->element('check_login'); ?>

<?php $img_path = DS.'webroot'.DS.'images'.DS.$user->profile_image; ?>
<img src="<?php echo empty($user->profile_image)?'':$img_path; ?>">
<p><strong>Full Name:</strong> <?php echo $user->first_name.' '.$user->last_name; ?></p>
<p><strong>Username:</strong> <?php echo $user->username; ?></p>
<p><strong>Email:</strong> <?php echo $user->email; ?></p>
<p><strong>Url:</strong> <?php echo $user->url; ?></p>
<p><strong>Dob:</strong> <?php echo $user->date_of_birth->format('d M Y'); ?></p>
<p><strong>Created:</strong> <?php echo $user->created->format('d M Y'); ?></p>
<?php echo $this->Form->postLink('Delete', ['action' => 'delete', $user->id], ['confirm' => 'Are you sure?']); ?>