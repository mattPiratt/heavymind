<?php echo $subscriber ?>

<h2>Interests</h2>

<ul>
<?php foreach ($interests as $interest): $question = $interest->getQuestion() ?>
  <li><?php echo link_to($question->getTitle(), $question->getId()) ?></li>
<?php endforeach ?>
</ul>

<h2>Contributions</h2>

<ul>
<?php foreach ($answers as $answer): $question = $answer->getQuestion() ?>
  <li>
    <?php echo link_to($question->getTitle(), $question->getId()) ?><br />
    <?php echo $answer->getBody() ?>
  </li>
<?php endforeach ?>
</ul>

<h2>Questions</h2>

<ul>
<?php foreach ($questions as $question): ?>
  <li><?php echo link_to($question->getTitle(), $question->getId()) ?></li>
<?php endforeach ?>
</ul>
<br/>
<br/>

<?php if ($subscriber->getHasPaypal()): ?>
<p>If you appreciated this user's contributions, you can grant him a small donation.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick">
  <input type="hidden" name="business" value="<?php echo $subscriber->getEmail() ?>">
  <input type="hidden" name="item_name" value="askeet">
  <input type="hidden" name="return" value="http://www.askeet.com">
  <input type="hidden" name="no_shipping" value="1">
  <input type="hidden" name="no_note" value="1">
  <input type="hidden" name="tax" value="0">
  <input type="hidden" name="bn" value="PP-DonationsBF">
  <input type="image" src="http://images.paypal.com/images/x-click-but04.gif" border="0" name="submit" alt="Donate to this user">
</form>
<?php endif ?>
