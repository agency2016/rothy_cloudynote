<?php

class Payment_model extends CI_Model{

    /**
     * Payment model for the user subcription
     * Inserting all the data from braintree into db
     * @param $data
     */
    public function subscription_payment($data){
        $ins_data = array(
            'order_id'                  => $data['order_id'],
            'school_id'                 => $data['order_id'],
            'amount'                    => $data['amount'],
            'customer_id'               => 'dsafdas',
            'transaction_id'            => $data['transaction_id'],
            'credit_card_status'        => $data['status'],
            'credit_card_number'        => $data['creditcardDetails']['last4'],
            'credit_card_holder_name'   => $data['card_holder_name'],
            'credit_card_exp_month'     => $data['creditcardDetails']['expirationMonth'],
            'credit_card_exp_year'      => $data['creditcardDetails']['expirationYear'],
            'credit_card_type'          => $data['creditcardDetails']['cardType'],
            'customer_company'          => $data['customerDetails']['company'],
            'customer_email'            => $data['customerDetails']['email'],
            'customer_fax'              => $data['customerDetails']['fax'],
            'customer_fname'            => $data['customerDetails']['firstName'],
            'customer_lname'            => $data['customerDetails']['lastName'],
            'customer_phone'            => $data['customerDetails']['phone'],
            'customer_web'              => $data['customerDetails']['website'],
            'customer_billing_fname'    => $data['billingDetails']['firstName'],
            'customer_billing_lname'    => $data['billingDetails']['lastName'],
            'customer_billing_company'  => $data['billingDetails']['company'],
            'customer_billing_country'  => $data['billingDetails']['countryName'],
            'customer_billing_country_code_alpha_2' => $data['billingDetails']['countryCodeAlpha2'],
            'customer_billing_country_code_alpha_3' => $data['billingDetails']['countryCodeAlpha3'],
            'customer_billing_locality' => $data['billingDetails']['locality'],
            'customer_billing_postcode' => $data['billingDetails']['postalCode'],
            'customer_billing_region'   => $data['billingDetails']['region'],
            'customer_billing_street_address_1' => $data['billingDetails']['streetAddress'],
            'customer_billing_street_address_2' => $data['billingDetails']['extendedAddress'],
            'created_at'                 => $data['created_at']['date'],
            'updated_at'                 => $data['updated_at']['date']
        );
        /*echo "<pre>"; print_r($data);echo "</pre>";
        echo "<pre>"; print_r($ins_data);echo "</pre>";*/
        $this->db->set($ins_data);
        $this->db->insert('user_transaction');
        if($this->db->affected_rows() == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function count_payment_log(){
        return $this->db->count_all('user_transaction');
    }

    /**
     * Activity log fetcher
     *
     * @return bool
     */
    public function payment_activity_log($limit, $start){
        $this->db->limit($limit, $start);
        $query = $this->db->get('user_transaction');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    /**
     * get package price value with package code
     * @param $pkg_code
     * @return bool | object
     */
    public function get_package_ammount( $pkg_code ) {
        $this->db->select('*');
        $result = $this->db->get_where('package_list', array('package_code' => $pkg_code));
        if( $result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }


    public function get_max_allowed_members_number_by_package_code($pkg_code) {
        $this->db->select( 'package_max_members' );
        $query = $this->db->get_where( 'package_list', array( 'package_code' => $pkg_code ) );
        if( $query->num_rows() == 1 ) {
            return $query->result();
        } else {
            return false;
        }
    }


    /**
     * Create new order from order info
     * @param $order_info
     * @return bool
     */
    public function create_new_order($order_info) {
        $this->db->set('created_at', 'NOW()', false);
        if( $this->db->insert('user_transaction', $order_info) ) {
            return true;
        } else {
            return false;
        }
    }


    public function update_taken_package($taken_packages_id) {
        $this->db->set( 'taken_packages_package_status_id', '1' );
        $this->db->where( 'taken_packages_id', $taken_packages_id );
        $this->db->update( 'taken_packages' );
    }


    public function update_transaction_from_webhook() {

    }


    /**
     * @param $braintree_info
     * @param $order_id
     * @return bool
     */
    public function update_order_info($braintree_info, $order_id, $taken_packages_id) {
        if( $braintree_info['is_settlement'] ) {
            $this->update_taken_package($taken_packages_id);

            $this->db->set( 'transaction_settled', '1' );
            $this->db->set( 'transaction_failure', '0' );
            $this->db->set( 'transaction_moved', '1' );
            $this->db->set( 'transaction_status', $braintree_info['status'] );
            if( $braintree_info['recurring'] ) {
                $this->db->set( 'recurring_transaction_failure', '0' );
            }
        } else {
            $this->db->set( 'transaction_settled', '0' );
            $this->db->set( 'transaction_failure', '0' );
            $this->db->set( 'transaction_moved', '0' );
            $this->db->set( 'transaction_status', $braintree_info['status'] );
        }
        $this->db->set( 'updated_at', 'NOW()', false );
        $this->db->where('order_id', $order_id);
        if( $this->db->update('user_transaction') ) {
            return true;
        } else {
            return false;
        }
    }

    /*public function check_transaction_is_not_moved( $email ) {
        $this->db->select( 'order_id' );
        $query = $this->db->get_where( 'user_transaction', array( 'transaction_moved' => 0, 'customer_identity' => md5( $email ) ) );
        if( $query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }*/

    /**
     * check if there any running package using @param $email
     * @param $email
     * @return bool | object
     *
     */
    public function user_has_running_package($email) {
        $this->db->select( 'tp.taken_packages_id, tp.taken_packages_package_code, pl.package_id, ut.transaction_id, ut.order_id' );
        $this->db->join( 'package_list AS pl', 'pl.package_code = tp.taken_packages_package_code' );
        $this->db->join( 'user_transaction AS ut', 'ut.order_id = tp.taken_packages_transaction_order_id' );
        $this->db->where( array( 'tp.taken_packages_organisation_email_hash' => md5( $email ), 'tp.taken_packages_package_code !=' => 'pk1', 'ut.transaction_settled' => 0, 'ut.transaction_failure' => 0, 'ut.transaction_moved' => 0, 'tp.taken_packages_package_status_id' => 1 ) );
        $this->db->or_where( array( 'tp.taken_packages_package_status_id' => 2 ) );
        $query = $this->db->get( 'taken_packages AS tp' );

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }


    /**
     * Get package id by package code
     * @param $pkg_code
     * @return bool | object
     */
    public function get_package_id_by_code( $pkg_code ) {
        $this->db->select( 'package_id' );
        $query = $this->db->get_where( 'package_list', array( 'package_code'=> $pkg_code ) );

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * check is there any order left for processing
     * @param $email
     * @return bool | object
     */
    public function have_any_order_left_for_processing($email) {
        $this->db->select( 'order_id, transaction_id' );
        $query = $this->db->get_where('user_transaction', array( 'customer_identity' => md5( $email ), 'transaction_failure' => 0, 'transaction_moved' => 0 ) );

        if( $query->num_rows() == 1 ) {
            return $query->result();
        } else {
            return false;
        }
    }


    /**
     * return only package code by call @user_has_running_package ()
     * @param $email
     * @return mixed | package_code
     */
    public function get_package_code_by_email($email) {
        if( ($result = $this->user_has_running_package( $email )) !== false ) {
            return $result[0]->taken_packages_package_code;
        } else {
            return null;
        }
    }

    public function create_basic_package_for_users($user_email) {
        $data = array(
            'taken_packages_id'                             => md5( $user_email.time().unique_id_generator() ),
            'taken_packages_organisation_email_hash'        => md5( $user_email ),
            'taken_packages_package_code'                   => 'pk1',
            'taken_packages_start_date'                     => date('d-m-Y'),
            'taken_packages_end_date'                       => date('Y-m-d', (strtotime('+10 years')-(1*24*60*60))),
            'taken_packages_purchase_date'                  => date('Y-m-d'),
            'taken_packages_package_status_id'              => 2
        );
    }

    public function create_taken_package_for_new_user($user_email, $package_code, $new_order_id, $recurring = false) {
        $this->load->helper('function');
        $end_date = date('Y-m-d', (strtotime('+1 years')-(1*24*60*60)));
        if( $recurring ) {
            $end_date = date('Y-m-d', (strtotime('+1 month')-(1*24*60*60)));
        }

        $data = array(
            array(
                'taken_packages_id'                         => md5($user_email.time().unique_id_generator()),
                'taken_packages_organisation_email_hash'    => md5( $user_email ),
                'taken_packages_package_code'               => 'pk1',
                'taken_packages_start_date'                 => date('Y-m-d'),
                'taken_packages_end_date'                   => date('Y-m-d', (strtotime('+10 years')-(1*24*60*60))),
                'taken_packages_purchase_date'              => date('Y-m-d'),
                'taken_packages_package_status_id'          => 1
            ),

            array(
                'taken_packages_id'                         => md5($user_email.time().unique_id_generator()),
                'taken_packages_organisation_email_hash'    => md5( $user_email ),
                'taken_packages_package_code'               => $package_code,
                'taken_packages_start_date'                 => date('Y-m-d'),
                'taken_packages_end_date'                   => $end_date,
                'taken_packages_purchase_date'              => date('Y-m-d'),
                'taken_packages_package_status_id'          => 2
            )
        );

        $this->db->insert_batch('taken_packages', $data);
    }


    public function create_taken_package_for_existing_user($user_email, $package_code, $recurring = true) {
        $end_date = date('Y-m-d', (strtotime('+1 years')-(1*24*60*60)));
        if( $recurring ) {
            $end_date = date('Y-m-d', (strtotime('+1 month')-(1*24*60*60)));
        }

        $data = array(
            'taken_packages_id'                             => md5( $user_email.time().unique_id_generator() ),
            'taken_packages_organisation_email_hash'        => md5( $user_email ),
            'taken_packages_package_code'                   => $package_code,
            'taken_packages_start_date'                     => date('Y-m-d'),
            'taken_packages_end_date'                       => $end_date,
            'taken_packages_purchase_date'                  => date('Y-m-d'),
            'taken_packages_package_status_id'              => 2
        );

        if( $this->db->insert( $data ) ) {
            return true;
        } else {
            return false;
        }
    }


    //public function update_


    public function get_max_allowed_members($package_code) {
        $this->db->select( 'package_max_members' );
        $query = $this->db->get_where( 'package_list', array( 'package_code' => $package_code ) );
        if( $query->num_rows() == 1 ) {
            $result = $query->result();
            return $result[0]->package_max_members;
        } else {
            return 10;
        }
    }



}