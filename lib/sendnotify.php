<?php

# 通知処理を管理

interface ISendNotify
{
    /**
     * 通知処理
     * @return bool 送信結果
     */
    public function Notify(): bool;
}

class SendNotify implements ISendNotify
{
    protected object $form;

    public function __construct(object $_form)
    {
        $this->form = $_form;
    }

    public function Notify(): bool
    {
        return (
            ($this->SendAdmin()) &&
            ($this->SendClient()) &&
            (true)
        );
    }

    /**
     * 管理者宛
     */
    private function SendAdmin(): bool
    {
        try
        {
            // 通知処理割愛
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * 申込者宛
     */
    private function SendClient(): bool
    {
        try
        {
            // 通知処理割愛
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}
