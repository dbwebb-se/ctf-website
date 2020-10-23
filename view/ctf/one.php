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

<p>Level = <?= $ctf->level ?></p>

<p class="tag">Tagged as:
<?php foreach ($tags as $tag) : ?>
    <?= $tag->name ?>
<?php endforeach; ?>
</p>

<?= $ctf->text ?>

Start here: <a href="<?= $ctf->target ?>"><?= $ctf->target ?></a>

<h2>Hints</h2>

</article>
