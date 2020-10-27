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

<table>
    <tr>
        <th>Author</th>
        <th>Level</th>
        <th>Time to solve</th>
        <th>Updated</th>
        <th>Tag</th>
    </tr>

    <tr>
        <td><?= $ctf->author ?></td>
        <td><?= $ctf->level ?></td>
        <td class="right"><?= $ctf->tts ?></td>
        <td><?= date("Y-m-d", $ctf->updated) ?></td>
        <td>
            <?php foreach ($tags as $tag) : ?>
                <?= $tag->name ?>
            <?php endforeach; ?>
        </td>
    </tr>
</table>

<?= $ctf->text ?>

Start here: <a href="<?= urlController("target/{$ctf->target}") ?>"><?= $ctf->target ?></a>



<h2>Check the flag</h2>

<form>
    <input type="text" name="flag" placeholder="Enter flag to verify it">
    <input type="submit" value="Verify">
    <output id="flag">MOPED</output>
</form>



<h2>Hints</h2>

<p>Use the hints if you get into trouble and need some help.</p>

<ul>
<?php foreach ($hints as $hint) : ?>
    <li><a href="<?= urlController("hint/{$ctf->id}/{$hint->id}") ?>"><?= $hint->id ?></a></li>
<?php endforeach; ?>
</ul>

</article>
