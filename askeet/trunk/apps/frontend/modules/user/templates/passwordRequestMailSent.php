<h2>Confirmation - login information sent</h2>
<p>Your login information was sent to</p>
<p><?php echo $request->getParameter('email') ?></p>
<p>You should receive it shortly, so you can proceed to the <?php echo link_to('login page','@login') ?>.</p>
