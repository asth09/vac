<?php
    // Not embedded. Do not check here.
    echo 'hello';
?>
<html>
<head>
<title><?= $title ?></title>
<script><?= $script; ?></script>
</head>
<body>
    <?php
        echo $body;
    ?>
    hello
    <?php
    echo $moreBody;
    ?>
    <?php  echo 'hi'; ?>
    <?php  echo 'hi';   ?>
    <?= 'hi;' ?>
    <?= 'hi'; echo 'hi;'; ?>
    <?php  echo 'hi'; echo 'hi;';   ?>

    <?php
    ?>
    <?php ?>

    <?php

        echo $moreBody;

    ?>
    <?php

    echo $moreBody;

        ?>

    <?php
    echo $moreBody; ?>
    <?= $moreBody;
    ?>

            <?php
        echo 'hi';
            ?>

    <?php
echo 'hi';
    ?>
</body>
</html>
<?php
function test()
{
    foreach ($root->section as $section) {
        ?>
        <table>
            <?php if ($foo) {
            ?>
            <tr>
            </tr>
            <?php }
            ?>
        <?php
        foreach ($bar as $bar) {
            echo $bar;
        }
    }

    foreach ($root->section as $section) {
        ?>
        <table>
            <?php
            if ($foo) {
            ?>
            <tr>
            </tr>
            <?php
}
            ?>
        <?php
        foreach ($bar as $bar) {
            echo $bar;
        }
    }
}

echo 'goodbye';

function foo()
{

    ?><a onClick="Javascript: set_hidden_field('<?= $link_offset - $num_per_page; ?>'); set_hidden_field('process_form', '0'); submit_form(); return false;"><?php

}

?>

            <strong><?php
            echo 'foo';
            ?></strong>

?>

</html>

<?php if ($foo) { ?>
<?php } ?>

<?= 'oops'; // Something. ?>
<?= 'oops'; // Something.      ?>
<?= 'oops'; // Something.?>

<?php /* translators: My sites label */ ?>
<?php /* translators: My sites label */?>
<?php /* translators: My sites label */      ?>

<?= 'oops'; // phpcs:ignore Standard.Category.Sniff -- reason. ?>
