<?php

class RecordController extends Controller
{
	public function actionFetch()
	{
		$count = Yii::app()->request->getParam("count", "20");
        $time  = Yii::app()->request->getParam("time");

        $logs = Log::getData($count, $time);
        echo CJSON::encode(array(
            "records" => $logs,
            "result_code" => 1,
            "error" => array(),
        ));
	}

	public function actionRegister()
	{
        $log = new Log();
        $log->user_div    = Yii::app()->request->getParam("user_div" , "DEFAULT DIVISION");
        $log->user_name   = Yii::app()->request->getParam("user_name", "DEFAULT USERNAME");
        $log->create_time = new CDbExpression("NOW()");

        $device = Device::getDevice(Yii::app()->request->getParam("device_info", "DEFAULT DEVICE"));
        $log->device_id   = $device->id;

        $res = array(
            "result_code" => 1,
            "error" => array(),
        );
        if (!$log->save())
            $res["error"] = $log->errors;

        echo CJSON::encode($res);
	}
}