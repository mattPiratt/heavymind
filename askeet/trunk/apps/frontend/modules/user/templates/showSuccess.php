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
