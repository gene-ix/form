<?php

# フォームごとに異なる情報を管理
# バリデーション条件（対応メッセージ）や、通知メールの内容なども管理。

class FormObject
{
    public array $postdata;
    public array $filedata;
    public array $validatelist;
    public string $mailbody;

    public function __construct($_postdata, $_filedata)
    {
        $this->postdata = $_postdata;
        $this->filedata = $_filedata;

        $this->validatelist = [
            [(!$this->postdata["input"]["answer1"]), "項目1が未入力。"],
            [(!$this->postdata["input"]["answer2"]), "項目2が未選択。"],
            [(!$this->postdata["input"]["answer3"]), "項目3が未選択。"],
            [($this->postdata["input"]["answer4"] == 0), "項目4が未選択。"],

            [($this->filedata["file"]["error"]["answer5"] != 0), "ファイルが不正"],
            [!file_exists($this->filedata["file"]["tmp_name"]["answer5"]), "ファイル未選択"],
            [!$this->MimeCheck(), "ファイル形式が不正"],
        ];

        $this->mailbody = $this->MailBody();
    }

    /**
     * 送信ファイルの形式が設定値に含まれているかどうかを確認
     */
    private function MimeCheck(): bool
    {
        $mimelist = array_map(function ($e)
        {
            return "image/{$e}";
        }, FORM_SETTING["filetype"]);

        return in_array($this->filedata["file"]["type"]["answer5"], $mimelist);
    }

    /**
     * 申込通知メールの本文
     */
    private function MailBody(): string
    {
        $answer1 = $this->postdata["input"]["answer1"] ?? "";
        $answer2 = $this->postdata["input"]["answer2"] ?? "";
        $answer3 = $this->postdata["input"]["answer3"] ?? "";
        $answer4 = implode(", ", $this->postdata["checklist"]["q4"] ?? []);
        $answer5 = $this->postdata["input"]["answer5"] ?? "";

        return <<< EOF
        Q1 : {$answer1}
        Q2 : {$answer2}
        Q3 : {$answer3}
        Q4 : {$answer4}
        Q5 : {$answer5}
        EOF;
    }
}
