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
<h1>CTF No <?= $ctf->id ?> "<?= $ctf->title ?>"</h1>
<p>By <?= $ctf->author ?>, updated <?= date("Y-m-d", $ctf->updated) ?>.</p>
</header>



<h2>Hint No <?= $hint->id ?></h2>

<?= $hint->content ?>

</article>
