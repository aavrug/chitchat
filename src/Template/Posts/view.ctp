<!-- File: src/Template/Posts/view.ctp -->
<?php
use Cake\View\Helper\SessionHelper;
?>
<?php echo $this->Html->link('Back', ['action' => 'index']) ?>
<?php echo $this->element('check_login'); ?>
<br/>
<?php $img_path = DS.'webroot'.DS.'images'.DS.$post->image; ?>
<img src="<?php echo empty($post->image)?'':$img_path; ?>">
<h2><?php echo $post->title; ?></h2>
<p><?php echo $post->body; ?></p>
<p><small><?php echo $post->created->format('d M Y'); ?></small></p>


<h3>Comments:</h3>
<?php foreach ($comments as $comment) : ?>
	<p><?php echo $comment->body; ?></p>		
<?php endforeach; ?>


<?php echo $this->element('CommentManager.comment',['ccomment' => $ccomment]); ?>


<?php
	// echo $this->Form->create($ccomment, ['url' => ['plugin' => 'CommentManager', 'controller' => 'Comments', 'action' => 'add', $post->id]]);
	// echo $this->Form->input('body', ['type' => 'textarea', 'rows' => '5', 'cols' => '5', 'class' => 'comment-field']);
	// echo $this->Form->input('email', ['class' => 'comment-field']);
	// echo $this->Form->button('Save');
	// echo $this->Form->end();
?>