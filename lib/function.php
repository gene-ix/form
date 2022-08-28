<?php

date_default_timezone_set("Asia/Tokyo");

define("GENERAL_SETTING", parse_ini_file(__DIR__ . "/../_private/setting.ini"));
define("FORM_SETTING", parse_ini_file(__DIR__ . "/../_private/form.ini"));



/**
 * 送信時に問題があったキーを取得し、対応するメッセージ一覧を作成。
 * CSRFエラーの場合は単独でメッセージを出力。
 */
function CheckErrorMessages(IFormCheck $client)
{
    return $client->CsrfCheck() ? array_column($client->Validation(), 1) : ["不正な遷移"];
}

/**
 * 完了時に問題があったキーを取得し、対応するメッセージ一覧を作成。
 * CSRFエラーの場合は単独でメッセージを出力。
 */
function DoneErrorMessages(IFormDone $client)
{
    return $client->CsrfCheck() ? array_column($client->DoneProcessResult(), 1) : ["不正な遷移"];
}