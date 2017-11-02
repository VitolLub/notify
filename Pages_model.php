<?php
class Pages_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function get_keys($id){
        $messages = $this->db->query('
			SELECT `user_key`
			FROM `user_keys`
			WHERE `user_id` = '.$id);
        if($messages->num_rows()== 0) {
            return NULL;
        }
        return $messages->row();
    }
    public function addkeys($key,$uid){
        $subscript = $this->db->query('
			SELECT `user_key`
			FROM `user_keys` WHERE `user_id` = '.$uid.'');

        if($subscript->num_rows()== 0) {
            $this->db->query('INSERT INTO user_keys (user_id,user_key)
              VALUES ('.$uid.',"'.$key.'")');
            return NULL;
        }
        else{
            $this->db->query('UPDATE user_keys
                SET user_key="'.$key.'"
                WHERE user_id='.$uid );
            return true;
        }
    }
    public function user_balance($uid){
        $this->db->query('INSERT INTO user_balance (user_id,user_balance)
              VALUES ('.$uid.',"15")');
    }
    public function get_user_balance($uid){
        $subscript = $this->db->query('SELECT *
			FROM `user_balance` WHERE `user_id` = '.$uid.'');
        return $subscript->row();
    }
    public function user_name($uid){
        $subscript = $this->db->query('SELECT *
			FROM `users` WHERE `id` = '.$uid.'');
        return $subscript->row();
    }
    public function get_sms_price(){
        $subscript = $this->db->query('SELECT *
			FROM `sms_price`');
        return $subscript->row();
    }
    public function last_id(){
        $this->db->select_max('id');
        $result= $this->db->get('users')->row_array();
        //echo $result['id'];
        return $result['id'];
    }
    public function addtoarhive($phone,$date,$uid,$ref2,$chanel,$region,$uname){
        print_r($region[0]);
        $date2 = $date;
        $date3=date("Y-m-d",strtotime($date2));
        $this->db->query('INSERT INTO phone (phone,user_id,u_date,ref,chanel,region,uname)
              VALUES ("'.$phone.'",'.$uid.',"'.$date3.'","'.$ref2.'",'.$chanel.',"'.$region.'","'.$uname.'")');
    }
    public function minu_balance($uid){
        $subscript = $this->db->query('SELECT *
			FROM `user_balance` WHERE `user_id` = '.$uid.'')->row();
        $cre = intval($subscript->user_balance)-1;
        $this->db->query('UPDATE user_balance
                SET user_balance="'.$cre.'"
                WHERE user_id='.$uid );
    }
    public function payment($uid,$date,$amount){
        //echo $date;
        $this->db->query('INSERT INTO payment (user_id,pay_date,amount)
              VALUES ("'.$uid.'","'.$date.'","'.$amount.'")');
    }
    public function update_balance($uid,$credit){
        $subscript = $this->db->query('SELECT *
			FROM user_balance WHERE `user_id` = '.$uid)->row();
        $cre = intval($subscript->user_balance)+intval($credit);
        $this->db->query('UPDATE user_balance
                SET user_balance="'.$cre.'"
                WHERE user_id='.$uid );
    }
    public function get_archive($uid,$yesterday,$findate){
        $yesterday2 = $yesterday;
        $yesterday3=date("Y-m-d",strtotime($yesterday2));
        $findate2 = $findate;
        $findate3=date("Y-m-d",strtotime($findate2));

        $subscript = $this->db->query('SELECT `phone`
			FROM `phone` WHERE `user_id`='.$uid.' AND `u_date`>="'.$yesterday3.'" AND `u_date`<="'.$findate3.'"');
        return $subscript->result_array();
    }
    public function add_turbosms($data,$uid){
        $subscript = $this->db->query('
			SELECT *
			FROM `self_name` WHERE `user_id` = '.$uid.'');
        if($subscript->num_rows()== 0) {
            $this->db->query('INSERT INTO self_name (user_id,s_name,u_pass,bal)
              VALUES ('.$uid.',"'.$data['alpha_name'].'","'.$data['pass'].'","0")');
            return NULL;
        }
        else{
            $this->db->query('UPDATE self_name
                SET s_name="'.$data['alpha_name'].'",u_pass="'.$data['pass'].'"
                WHERE user_id='.$uid );
            return true;
        }
    }
    public function get_turbosms($uid){
        $messages = $this->db->query('
			SELECT *
			FROM `self_name`
			WHERE `user_id` = '.$uid);
        if($messages->num_rows()== 0) {
            return NULL;
        }
        return $messages->row();
    }
    public function get_getawey($uid){
        $messages = $this->db->query('
			SELECT *
			FROM `self_name`
			WHERE `user_id` = '.$uid);
        if($messages->num_rows()== 0) {
            return NULL;
        }
        return $messages->row();
    }
    public function save_sms_bal($bal,$uid){
        $this->db->query('UPDATE self_name
                SET bal="'.$bal.'"
                WHERE user_id='.$uid );
    }
    public function get_turbo_sms($uid){
        $messages = $this->db->query('
			SELECT `bal`
			FROM `self_name`
			WHERE `user_id` = '.$uid);
        if($messages->num_rows()== 0) {
            return NULL;
        }
        return $messages->row();
    }
    public function get_archive_data($uid){
        $messages = $this->db->query('
			SELECT `u_date`
			FROM `phone`
			WHERE `user_id`='.$uid.' ORDER BY id DESC')->result();
        $stack = array();
        for($i=0;$i<count($messages);$i++){
            if(in_array($messages[$i]->u_date, $stack, TRUE))
            {
                echo "";
            }
            else{
                array_push($stack, $messages[$i]->u_date);
            }

        }

        if($messages== 0) {
            return NULL;
        }
        return $stack;
    }
    public function get_archive_ttn($uid,$date){
        $messages = $this->db->query('
			SELECT *
			FROM `sended_users`
			WHERE `uid`='.$uid.' AND `u_date`="'.$date.'"')->result();
        if($messages== 0) {
            return NULL;
        }
        return $messages;
    }
    public function get_archive_ttn3($uid,$date){
        $messages = $this->db->query('
			SELECT `ref`
			FROM `phone`
			WHERE `user_id`='.$uid.' AND `u_date`="'.$date.'"')->result();
        if($messages== 0) {
            return NULL;
        }
        return $messages;
    }
    public function get_archive_ttn2($ttn,$date){
        $messages = $this->db->query('
			SELECT `ref`
			FROM `phone`
			WHERE `ref`='.$ttn.' AND `u_date`="'.$date.'"')->result();
        if($messages== 0) {
            return NULL;
        }
        return $messages; 
    }
    public function save_settings($uid,$u_name,$u_surname,$phone_number,$email){
        $settings = $this->db->query('UPDATE users
                SET first_name="'.$u_name.'", `last_name`="'.$u_surname.'",`phone`="'.$phone_number.'",`email`="'.$email.'",`username`="'.$email.'" 
                WHERE id='.$uid );
        if($settings){
            return TRUE;
        }
    }
    public function get_settings($uid){
        $messages = $this->db->query('
			SELECT `first_name`,`last_name`,`phone`,`email`
			FROM `users`
			WHERE `id`='.$uid)->result();
        if($messages== 0) {
            return NULL;
        }
        return $messages;
    }
    public function auto_sending($uid,$a){
        if(intval($a)==1){
            $this->db->where('user_id', $uid);
            $this->db->delete('sms_auto_send');
        }
        else{
            $this->db->query('INSERT INTO sms_auto_send (user_id)
              VALUES ("'.$uid.'")');
        }
    }
    public function get_auto_sending($uid)
    {
        $messages = $this->db->query('
			SELECT `user_id`
			FROM `sms_auto_send`
			WHERE `user_id`='.$uid)->result();
        if($messages== 0) {
            return NULL;
        }
        return $messages;
    }
    public function save_templates($uid,$template){

        $messages = $this->db->query('
			SELECT *
			FROM `sms_template`
			WHERE `user_id`='.$uid)->result();
        if(count($messages)==0) {
            $this->db->query('INSERT INTO sms_template (user_id,message)
              VALUES ("'.$uid.'","'.$template.'")');
        }
        else{
            $this->db->query('UPDATE sms_template
                SET message="'.$template.'"
                WHERE user_id='.$uid );
        }

    }
    public function get_sms_template($uid){
        $messages = $this->db->query('
			SELECT `message`
			FROM `sms_template`
			WHERE `user_id`='.$uid)->result();
        if($messages== 0)
        {
            return NULL;
        }
        return $messages;
    }

    public function get_sms_auto_send(){
        $messages = $this->db->query('
			SELECT `user_id`
			FROM `sms_auto_send`
			')->result();
        if($messages== 0)
        {
            return NULL;
        }
        return $messages;
    }
    public function of_getawey($uid){
        $this->db->where('user_id', $uid );
        $this->db->delete('self_name');
    }
    public function get_analitics($uid,$yesterday){
        $messages = $this->db->query('
			SELECT COUNT(`u_date`) as total,`u_date`
			FROM `phone`
			WHERE `user_id`='.$uid.' AND `u_date`="'.$yesterday.'"')->result();
      
        if($messages== 0)
        {
            return NULL;
        }
        return $messages;
    }
    public function selected($uid,$phone,$ref,$u_name){
        $messages = $this->db->query('
			SELECT `user_id`,`phone`
			FROM `selected`
			WHERE `user_id`='.$uid.' AND `phone`="'.$phone.'"');
        if($messages->num_rows()== 0)
        {
            $this->db->query('INSERT INTO selected (user_id,phone,ref,u_name)
              VALUES ('.$uid.',"'.$phone.'","'.$ref.'","'.$u_name.'")');
        }


    }
    public function get_selected($uid){
        $messages = $this->db->query('
			SELECT *
			FROM `selected`
			WHERE `user_id`='.$uid)->result();
        return $messages;
    }
    public function add_to_selected($uid,$phone){
        $this->db->query('INSERT INTO selected (user_id,phone,ref,u_name)
              VALUES ('.$uid.',"'.$phone.'","","")');
    }
    public function remove_star($ref){
        $this->db->where('ref', $ref );
        $this->db->delete('selected');
    }
    public function get_analitics_data($uid,$lastdate,$firstdate){
        $subscript = $this->db->query('
			SELECT `phone`,`u_date`,`chanel`
			FROM `phone` WHERE `user_id`='.$uid.' AND `u_date`>="'.$firstdate.'" AND `u_date`<="'.$lastdate.'"')->result();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function admin_get_analitics($findate,$yesterday){
        $subscript = $this->db->query('
			SELECT COUNT(`phone`) as total,`u_date`,`chanel`
			FROM `phone` WHERE `u_date`>="'.$findate.'" AND `u_date`<="'.$yesterday.'"')->result();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function save_to_sended($uid,$ref){
        $this->db->query('INSERT INTO sended_users (users,uid)
              VALUES ('.$ref.',"'.$uid.'")');
    }
    public function save_to_notsended($uid,$ref,$region,$uname){
        $date=date("Y-m-d");
        $this->db->query('INSERT INTO notsended (users,uid,region,uname,u_date)
              VALUES ("'.$ref.'","'.$uid.'","'.$region.'","'.$uname.'","'.$date.'")');
    }

    public function get_to_sended($uid,$firstdate=false,$lastdate=false){
        $subscript = $this->db->query('
        SELECT *
        FROM `sended_users` WHERE `uid`='.$uid)->result_array();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function get_to_notsended($uid,$firstdate=false,$lastdate=false){
        $subscript = $this->db->query('
			SELECT *
			FROM `notsended` WHERE `uid`='.$uid.' AND `u_date`>="'.$firstdate.'" AND `u_date`<="'.$lastdate.'"')->result_array();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function get_sending_type($uid){
        $subscript = $this->db->query('
			SELECT *
			FROM `sending_type` WHERE `uid`='.$uid)->result_array();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function save_sending_type($uid,$a){
        echo $a;
        if($a==0){
            $this->db->query('INSERT INTO sending_type (uid)
              VALUES ("'.$uid.'")');
        }
        else{
            $this->db->where('uid', $uid);
            $this->db->delete('sending_type');
        }
    }
    public function save_to_sended2($uid,$ref,$uname,$phone,$price){
        $date=date("Y-m-d");
        $this->db->query('INSERT INTO sended_users (uid,users,region,uname,u_date,cost,phone)
              VALUES ("'.$uid.'","'.$ref.'","","'.$uname.'","'.$date.'","'.$price.'","'.$phone.'")');
        $this->db->where('users', $ref);
        $this->db->where('uid', $uid);
        $this->db->delete('notsended');
    }
    public function get_to_sended2($uid,$firstdate=false,$lastdate=false){
        $subscript = $this->db->query('
        SELECT *
        FROM `sended_users` WHERE `uid`='.$uid.' AND `u_date`>="'.$firstdate.'" AND `u_date`<="'.$lastdate.'"')->result();
        if($subscript== 0)
        {
            return NULL;
        }
        return $subscript;
    }
    public function get_to_sended_date($uid){
        $subscript = $this->db->query('
        SELECT *
        FROM `sended_users` WHERE `uid`='.$uid.' ORDER BY id DESC')->result();
        $stack = array();
        for($i=0;$i<count($subscript);$i++){
            if(in_array($subscript[$i]->u_date, $stack, TRUE))
            {
                echo "";
            }
            else{
                array_push($stack, $subscript[$i]->u_date);
            }

        }

        if($subscript== 0) {
            return NULL;
        }
        return $stack;
    }
    public function save_in_not_sended($uid,$ref,$region,$uname,$date,$price,$phone){
        //
        $subscript = $this->db->query('
        SELECT `users`
        FROM `notsended` WHERE `uid`='.$uid.' AND `users`='.$ref)->result();
        if(count($subscript)== 0) {
            $subscript2 = $this->db->query('
        SELECT `users`
        FROM `sended_users` WHERE `uid`='.$uid.' AND `users`='.$ref)->result();
            if(count($subscript2)== 0) {
                $this->db->query('INSERT INTO notsended (uid,users,region,uname,u_date,price,phone)
              VALUES ("' . $uid . '","' . $ref . '","' . $region . '","' . $uname . '","' . $date . '","' . $price . '","' . $phone . '")');
            }
        }
        return $subscript;
    }
    public function savetodbb($uu) {
        $this->db->query('INSERT INTO savetodbb (url)
              VALUES ("'.$uu.'")');
    }
    public function get_savetodbb($uu) {
        $subscript = $this->db->query("
        SELECT *
        FROM `savetodbb` WHERE url='".$uu."'")->result();
        return $subscript;

    }

    


}