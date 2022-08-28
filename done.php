<?php

session_start();
session_regenerate_id(true);

foreach (glob("./lib/*.php") as $file)
{
    if (file_exists($file))
    {
        require_once($file);
    }
}

$form = new FormObject(filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS), []);
$errormessages = DoneErrorMessages(new FormDone($form));

if (count($errormessages) < 1)
{
    header("Location: thankyou.php");
    exit();
}

require_once("./_head.php");

?>

<div class="content">

    <div class="message error">
        <p>入力した内容に問題がありました。以下をご確認下さい。</p>
        <ul>

            <?php foreach ($errormessages as $value) : ?>

                <li>- <?= $value; ?></li>

            <?php endforeach; ?>

        </ul>
    </div>

</div>

<?php

require_once("./_foot.php");

?>