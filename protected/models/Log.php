<?php

class Log extends LogBase
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Device the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function getData($count, $time)
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $count;
        if ($time)
            $criteria->addCondition("create_time >= '$time'");

        $logs = Log::model()->findAll($criteria);
        $res  = array();
        foreach ($logs as $log) {
            $item  = $log->attributes;
            $item["device_info"] = $log->device->info;
            $res[] = $item;
        }
        return $res;
    }
}