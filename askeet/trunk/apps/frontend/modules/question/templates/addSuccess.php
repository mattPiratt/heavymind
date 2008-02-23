<?php use_helper('Validation') ?>
 
<?php echo form_tag('@add_question') ?>
 
  <fieldset>
 
  <div class="form-row">
    <?php echo form_error('title') ?>
    <label for="title">Question title:</label>
    <?php echo input_tag('title', $sf_params->get('title')) ?>
  </div>
 
  <div class="form-row">
    <?php echo form_error('body') ?>
    <label for="label">Your question in details:</label>
    <?php echo textarea_tag('body', $sf_params->get('body')) ?>
  </div>
 
  </fieldset>
 
  <div class="submit-row">
    <?php echo submit_tag('ask it') ?>
  </div>
</form>