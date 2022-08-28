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

require_once("./_head.php");

?>

<div class="content">

    <div class="message ">
        <p>お申し込みありがとうございました。</p>
    </div>

</div>

<?php

require_once("./_foot.php");

?>