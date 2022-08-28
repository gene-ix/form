<?php

# 完了処理（確認→送信）を管理

interface IFormDone
{
    /**
     * CSRFチェック
     * @return bool CSRF検証結果
     */
    public function CsrfCheck(): bool;

    /**
     * 完了処理
     * @return array 処理エラー一覧
     */
    public function DoneProcessResult(): array;
}

class FormDone implements IFormDone
{
    protected object $form;
    protected ISaveEntryData $isave;
    protected ISendNotify $inotify;

    public function __construct(object $_form)
    {
        $this->form = $_form;
        $this->isave = new SaveEntryData($_form);
        $this->inotify = new SendNotify($_form);
    }

    public function CsrfCheck(): bool
    {
        return ($this->form->postdata["csrf_token"] == $_SESSION["csrf_token"]);
    }

    public function DoneProcessResult(): array
    {
        $result = [
            [(!$this->isave->Save()), "保存処理エラー"],
            [(!$this->inotify->Notify()), "通知処理エラー"]
        ];

        return array_filter($result, function ($e)
        {
            return $e[0] === true;
        });
    }
}
