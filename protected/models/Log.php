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
        $criteria->order = "create_time ASC";

        if ($time)
            $criteria->addCondition("create_time > $time");

        $logs = Log::model()->findAll($criteria);
        $res  = array();
        foreach ($logs as $log) {
            $item  = $log->attributes;
            $item["device_id"] = $log->device->info;
            $res[$log->device_id] = $item;
        }

        $return = array();
        foreach ($res as $item)
            $return[] = $item;

        usort($return, array(Log::model(), "cmp"));
        return $return;
    }

    public function cmp($a, $b){
        return $a["create_time"] > $b["create_time"] ? -1 : 1;
    }
}
