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

$csrf_token = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION["csrf_token"] = $csrf_token;

require_once("./_head.php");

?>

<div class="content">

    <?php if (GENERAL_SETTING["enabled"]) : ?>

        <form action="check.php" method="post" enctype="multipart/form-data">
            <ul>

                <li id="q1">
                    <label for="">Question 1</label>
                    <input type="text" name="input[answer1]" required>
                </li>

                <li id="q2">
                    <label for="">Question 2</label>
                    <select name="input[answer2]" required>
                        <option value="">選択して下さい</option>

                        <?php foreach (FORM_SETTING["select"] as $value) : ?>

                            <option value="<?= $value; ?>"><?= $value; ?></option>

                        <?php endforeach; ?>

                    </select>
                </li>

                <li id="q3">
                    <label>Question 3</label>

                    <?php foreach (FORM_SETTING["radiolist"] as $index => $value) : ?>

                        <input type="radio" name="input[answer3]" id="q3_<?= $index; ?>" value="<?= $value; ?>" required>
                        <label for="q3_<?= $index; ?>"><?= $value; ?></label><br>

                    <?php endforeach; ?>

                </li>

                <li id="q4">
                    <label>Question 4</label>
                    <p class="note">※複数選択可</p>

                    <?php foreach (FORM_SETTING["checklist"] as $key => $value) : ?>

                        <input type="checkbox" name="checklist[q4][]" id="q4_<?= $key; ?>" value="<?= $value; ?>" data-bitvalue="<?= 2 ** $key; ?>">
                        <label for="q4_<?= $key; ?>"><?= $value; ?></label><br>

                    <?php endforeach; ?>

                    <input type="hidden" name="input[answer4]">
                    <div class="feedback">
                        <input type="checkbox" required>
                        <p>いずれか一つの選択が必須。</p>
                    </div>
                </li>

                <li id="q5">
                    <label for="">Question 5</label>
                    <p class="note">※添付可能なファイル形式 = <?= implode(", ", FORM_SETTING["filetype"]); ?></p>
                    <input type="file" name="file[answer5]" accept=".<?= implode(",.", FORM_SETTING["filetype"]); ?>" required>
                    <div class="feedback">
                        <input type="checkbox" checked required>
                        <p>選択不可能なファイル形式。</p>
                    </div>
                </li>

                <li id="q6">
                    <label for="">Question 6</label>
                    <p class="note">※<?= FORM_SETTING["textarea_maxlength"]; ?>文字まで。改行は削除されます。</p>
                    <textarea name="input[answer6]" rows="3" maxlength="<?= FORM_SETTING["textarea_maxlength"]; ?>"></textarea>
                </li>

                <li>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
                    <button type="submit">確認</button>
                </li>

            </ul>
        </form>

    <?php else : ?>

        <div class="message error">
            <p>現在受付停止中です。</p>
        </div>

    <?php endif; ?>

</div>

<?php

require_once("./_foot.php");

?>