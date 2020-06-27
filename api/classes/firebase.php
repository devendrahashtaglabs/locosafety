<?php
// define('FIREBASE_API_KEY', 'AAAAs0y9Lck:APA91bEBemLwBfWzM1SBfiswlfsDem8LBKvIc8C5O1uMvC58FMmgZyZ82fD2rf2Oi-cNJBo-U-uqpR0QUvPs1XUgpp6pgQWB9Lt5X8Z0hyoLAeIM7sTx5VkwpjOtkL7A_OqyrQn1T6jZ');
  // define('FIREBASE_API_KEY', 'AAAAhYXzG-k:APA91bFdZj_a5WvKM_QodVaoIHDA1mo1Z3Cn_v66Zd4XljR00e6d4J_Widp5np_dj8JxI-s1zSNpnRY2Wae890WNKwGk6M87MoL37M-fqqAPFi9yiRFdUdoMZNIoWTlrRrYUmK1LhKy9');
   // define('FIREBASE_API_KEY', 'AAAA4pPEbZE:APA91bGu8ZHpWQYF072fhlBalWn65AuuAAjRcIBjvBtKWOb33axT4QjfhTMPkH07SvGeF0mvpDXeD_on5PmXDIcRY4WYDSQfK3CXrrt0DuEt0XNLpQ8Yhs0WVzRrAcAVTCn7hyNQqglH');
    define('FIREBASE_API_KEY', 'AAAAdK3H1Us:APA91bGRCQXbIxztT0zUVD1mkOkJO8NcL3wOVrkXHoW5Z_CZSFKAbqCuznniu83H80iXDp8T9sUdHn7hg3SNPGP3cQdXMj-g1PchQ3KaCADyEIiq4ugW5BTtr-HtoDAqmMFSCHvCYysI');
    /**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class Firebase {
 
    // sending push message to single user by firebase reg id
    public function send($to, $message) {
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // Sending message to a topic by topic name
    public function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
 
    // sending push message to multiple users by firebase registration ids
    public function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
            'notification' => $message,
        );
 
        return $this->sendPushNotification($fields);
    }
 
    // function makes curl request to firebase servers
    private function sendPushNotification($fields) {
         
        //require_once __DIR__ . '/config.php';
 
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
 
        return $result;
    }
}
?>