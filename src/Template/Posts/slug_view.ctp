<!-- File: src/Template/Posts/view.ctp -->

<?php echo $this->Html->link('Back', ['action' => 'index']) ?>
<?php echo $this->element('check_login'); ?>
<br/>
<?php $img_path = DS.'webroot'.DS.'images'.DS.$post->image; ?>
<img src="<?php echo empty($post->image)?'':$img_path; ?>">
<h2><?php echo $post->title; ?></h2>
<p><?php echo $post->body; ?></p>
<p><small><?php echo $post->created->format('d M Y'); ?></small></p>