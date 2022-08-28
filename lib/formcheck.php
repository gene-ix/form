<?php

# 確認処理（入力→確認）を管理

interface IFormCheck
{
    /**
     * CSRFチェック
     * @return bool CSRF検証結果
     */
    public function CsrfCheck(): bool;

    /**
     * 入力値の問題を検証
     * @return array 検証エラー一覧
     */
    public function Validation(): array;
}

class FormCheck implements IFormCheck
{
    protected object $form;

    public function __construct(object $_form)
    {
        $this->form = $_form;
    }

    public function CsrfCheck(): bool
    {
        return ($this->form->postdata["csrf_token"] == $_SESSION["csrf_token"]);
    }

    public function Validation(): array
    {
        return array_filter($this->form->validatelist, function ($e)
        {
            return ($e[0] === true);
        });
    }
}
