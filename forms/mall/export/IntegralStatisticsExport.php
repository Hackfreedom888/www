<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 浙江禾匠信息科技有限公司
 * author: jack_guo
 */

namespace app\forms\mall\export;

use app\core\CsvExport;

class IntegralStatisticsExport extends BaseExport
{

    public function fieldsList()
    {
        return [
            [
                'key' => 'date',
                'value' => '日期',
            ],
            [
                'key' => 'in_integral',
                'value' => '积分收入',
            ],
            [
                'key' => 'out_integral',
                'value' => '积分支出',
            ],

        ];
    }

    public function export($query)
    {
        $list = $query
            ->asArray()
            ->all();
        $this->transform($list);
        $this->getFields();
        $dataList = $this->getDataList();

        $fileName = '积分收支' . date('YmdHis');
        (new CsvExport())->export($dataList, $this->fieldsNameList, $fileName);
    }

    protected function transform($list)
    {
        $newList = [];
        $arr = [];

        $number = 1;
        foreach ($list as $key => $item) {
            $arr['number'] = $number++;
            $item['in_integral'] = intval($item['in_integral']);
            $item['out_integral'] = intval($item['out_integral']);

            $arr = array_merge($arr, $item);

            $newList[] = $arr;
        }
        $this->dataList = $newList;
    }

    protected function getFields()
    {
        $arr = [];
        foreach ($this->fieldsList() as $key => $item) {
            $arr[$key] = $item['key'];
        }
        $this->fieldsKeyList = $arr;
        parent::getFields(); // TODO: Change the autogenerated stub
    }
}