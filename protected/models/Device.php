<?php

class Device extends DeviceBase
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

    public static function getDevice($info)
    {
        $device = Device::model()->findByAttributes(array("info"=>$info));
        if ($device)
            return $device;

        $device = new Device();
        $device->info = $info;
        $device->create_time = new CDbExpression("NOW()");
        $device->save();

        return $device;
    }
}