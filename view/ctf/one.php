<?php

namespace Anax\View;

/**
 * Render details on one ctf.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare incoming variables
$class = $class ?? null;



?><article class="$class">

<?php if (empty($ctf)) : ?>
<p>No such CTF exists in the database.</p>
<?php endif; ?>

<header>
<h1>CTF No <?= $ctf->id ?></h1>
<p>By <?= $ctf->author ?>, updated <?= date("Y-m-d", $ctf->updated) ?>.</p>
</header>

<p>Level: <?= $ctf->level ?></p>

<p>Estimated time to solve: <?= $ctf->tts ?> minutes.</p>

<p class="tag">Tags:
<?php foreach ($tags as $tag) : ?>
    <?= $tag->name ?>
<?php endforeach; ?>
</p>

<?= $ctf->text ?>

Start here: <a href="<?= urlController("target/{$ctf->target}") ?>"><?= $ctf->target ?></a>



<h2>Hints</h2>

<p>Use the hints if you get into trouble and need some help.</p>

<ul>
<?php foreach ($hints as $hint) : ?>
    <li><a href="<?= urlController("hint/{$ctf->id}/{$hint->id}") ?>"><?= $hint->id ?></a></li>
<?php endforeach; ?>
</ul>

</article>
