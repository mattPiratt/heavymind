<?php
// auto-generated by sfPropelCrud
// date: 2008/02/06 21:35:59
?>
<?php use_helper('Object') ?>

<?php echo form_tag('question/update') ?>

<?php echo object_input_hidden_tag($question, 'getId') ?>

<table>
<tbody>
<tr>
  <th>User:</th>
  <td><?php echo object_select_tag($question, 'getUserId', array (
  'related_class' => 'User',
  'include_blank' => true,
)) ?></td>
</tr>
<tr>
  <th>Title:</th>
  <td><?php echo object_textarea_tag($question, 'getTitle', array (
  'size' => '30x3',
)) ?></td>
</tr>
<tr>
  <th>Body:</th>
  <td><?php echo object_textarea_tag($question, 'getBody', array (
  'size' => '30x3',
)) ?></td>
</tr>
</tbody>
</table>
<hr />
<?php echo submit_tag('save') ?>
<?php if ($question->getId()): ?>
  &nbsp;<?php echo link_to('delete', 'question/delete?id='.$question->getId(), 'post=true&confirm=Are you sure?') ?>
  &nbsp;<?php echo link_to('cancel', 'question/show?id='.$question->getId()) ?>
<?php else: ?>
  &nbsp;<?php echo link_to('cancel', 'question/list') ?>
<?php endif; ?>
</form>