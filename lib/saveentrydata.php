<?php

# 保存処理を管理

interface ISaveEntryData
{
    /**
     * 送信データを保存
     * @return bool 保存処理結果
     */
    public function Save(): bool;
}

class SaveEntryData implements ISaveEntryData
{
    protected object $form;

    public function __construct(object $_form)
    {
        $this->form = $_form;
    }

    public function Save(): bool
    {
        return (
            ($this->SaveCsv()) &&
            ($this->SaveImage()) &&
            (true)
        );
    }

    /**
     * CSVで保存
     */
    private function SaveCsv(): bool
    {
        try
        {
            $csvrow = array_map(function ($e)
            {
                return str_replace(["\r\n", "\r", "\n"], "", $e);
            }, $this->form->postdata["input"]);

            $file = new SplFileObject($_SERVER["DOCUMENT_ROOT"] . GENERAL_SETTING["csv_dir"] . date("Ym") . ".csv", "a");
            return $file->fputcsv($csvrow);
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * 画像を保存
     */
    private function SaveImage(): bool
    {
        return file_put_contents($_SERVER["DOCUMENT_ROOT"] . GENERAL_SETTING["img_dir"] . $this->form->postdata["fileid"], $_SESSION["filedata"]);
    }
}
