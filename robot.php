<?php
header('Content-type:text/html;charset=utf-8');
class Robot {
    var $username;
    var $message;
    var $responseMsg;
    private function configure_info() {
        $params = array('info'=> $this->message,'dtype'=>'xml','userid'=>$this->username,'key'=>'fbd8f906450fddf3477a6d484995d09d');
        $param_string = http_build_query($params);
        return $param_string;
    }
    public function set_user_name($name) {
        $this->username = $name;
    }
    public function sendMsg($content) {
        $this->message = $content;
        $robbor_url = "http://op.juhe.cn/robot/index";
        $params = $this->configure_info();
        $this->responseMsg = $this->robbot_request($robbor_url,$params);
        return $this->parse_message($this->responseMsg);
    }
    private function parse_message($message) {
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$message,$array);
        $index = $array[4];
        $content = $index['value'];
        echo $content;
        xml_parser_free($parser);
        return $content;
    }
    private  function robbot_request($url,$params) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,60);
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch,CURLOPT_URL,$url.'?'.$params);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}
/*

$rob = new Robot();
$rob->set_user_name('Victor');

$re = $rob->sendMsg('武汉的天气');
echo $re;
*/

/**
 * Created by PhpStorm.
 * User: VicChan
 * Date: 16/3/6
 * Time: 下午7:12
 */

?>