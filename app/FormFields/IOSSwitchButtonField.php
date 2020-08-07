<?php


namespace App\FormFields;
use TCG\Voyager\FormFields\AbstractHandler as AbstractHandler;

class IOSSwitchButtonField extends AbstractHandler
{
    protected $codename = 'ios_switch_button';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.ios_switch_button', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
