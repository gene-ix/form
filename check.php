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

$form = new FormObject(filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS), $_FILES);
$errormessages = CheckErrorMessages(new FormCheck($form));

$filepath = $_FILES["file"]["tmp_name"]["answer5"];
$filecontent = file_exists($filepath) ? file_get_contents($filepath) : false;
$_SESSION["filedata"] = $filecontent;
$base64 = base64_encode($filecontent);
$mime = $_FILES["file"]["type"]["answer5"];
$imagedata = "data:{$mime};base64,{$base64}";
$fileid = sprintf("%s_%05d.%s", date("YmdHis"), rand(0, 99999), pathinfo($_FILES["file"]["name"]["answer5"], PATHINFO_EXTENSION));

require_once("./_head.php");

?>

<div class="content">

    <?php if (count($errormessages) < 1) : ?>

        <dl class="checktable">
            <dt>Question 1</dt>
            <dd><?= $form->postdata["input"]["answer1"]; ?></dd>

            <dt>Question 2</dt>
            <dd><?= $form->postdata["input"]["answer2"]; ?></dd>

            <dt>Question 3</dt>
            <dd><?= $form->postdata["input"]["answer3"]; ?></dd>

            <dt>Question 4</dt>
            <dd><?= implode("<br>", $form->postdata["checklist"]["q4"] ?? []); ?></dd>

            <dt>Question 5</dt>
            <dd>
                <img src="<?= $imagedata; ?>" alt="">
            </dd>

            <dt>Question 6</dt>
            <dd><?= $form->postdata["input"]["answer6"]; ?></dd>

        </dl>

        <form action="done.php" method="post">

            <?php foreach($form->postdata["input"] as $key => $value): ?>
            
                <input type="hidden" name="input[<?= $key; ?>]" value="<?= $value; ?>">
            
            <?php endforeach; ?>

            <input type="hidden" name="fileid" value="<?= $fileid; ?>">
            <input type="hidden" name="csrf_token" value="<?= $form->postdata["csrf_token"]; ?>">
            <button type="submit">送信</button>
        </form>

    <?php else : ?>

        <div class="message error">
            <p>入力した内容に問題がありました。以下をご確認下さい。</p>
            <ul>

                <?php foreach($errormessages as $value): ?>

                    <li>- <?= $value; ?></li>

                <?php endforeach; ?>

            </ul>
        </div>

    <?php endif; ?>

    <p class="historyback" onclick="window.history.back()">&lt;&lt;&nbsp;戻る</p>

</div>

<?php

require_once("./_foot.php");

?>