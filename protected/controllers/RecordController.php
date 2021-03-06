<?php

class RecordController extends Controller
{
	public function actionFetch()
	{
		$count = Yii::app()->request->getParam("count", "20");
        $time  = Yii::app()->request->getParam("time");

        $logs = Log::getData($count, $time);

        header('Content-type: application/json');
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
        $log->user_input  = Yii::app()->request->getParam("user_input", "DEFAULT USER INPUT");
        $log->user_name   = Yii::app()->request->getParam("user_name", "DEFAULT USERNAME");
        $log->create_time = date("Y-m-d H:i:s");
        
        $device = Device::getDevice(Yii::app()->request->getParam("device_id", "DEFAULT DEVICE"));
        $log->device_id   = $device->id;

        $res = array(
            "result_code" => 1,
            "error" => array(),
        );
        if (!$log->save())
            $res["error"] = $device->errors;

        header('Content-type: application/json');
        echo CJSON::encode($res);
	}

    public function actionDelete()
    {
        $device = Device::getDevice(Yii::app()->request->getParam("device_id", "DEFAULT DEVICE"));
        $logs   = Log::model()->findAllByAttributes(array("device_id"=>$device->id));
        if ($logs){
            /** @var Log $log */
            $log    = $logs[count($logs) -1 ];
            $log->return_time = date("Y-m-d H:i:s");
            $log->save();
        }

        $res = array(
            "result_code" => 1,
            "error" => array(),
        );

        header('Content-type: application/json');
        echo CJSON::encode($res);
    }
}