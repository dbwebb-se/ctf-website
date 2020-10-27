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

<header>
<h1>List of CTFs</h1>

<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Author</th>
        <th>Level</th>
        <th>Time to solve</th>
        <th>Updated</th>
    </tr>

    <?php foreach ($ctfs as $ctf) : ?>
        <tr>
            <td><?= $ctf->id ?></td>
            <td><a href="<?= urlController("id/{$ctf->id}") ?>"><?= $ctf->title ?></a></td>
            <td><?= $ctf->author ?></td>
            <td><?= $ctf->level ?></td>
            <td class="right"><?= $ctf->tts ?></td>
            <td><?= date("Y-m-d", $ctf->updated) ?></td>
        </tr>
    <?php endforeach; ?>

</table>



</article>
