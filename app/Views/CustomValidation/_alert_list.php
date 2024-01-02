<?php if (!empty($errors)) : ?>
	<div class="text-red-400" role="alert">
		<ul>
			<?php foreach ($errors as $error) : ?>
				<li class="text-red-400"><?= esc($error) ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>