<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/3/13
 * Time: 10:42 AM
 */


//Customizing the Pagination
$config['uri_segment'] = 4;
$config['num_links'] = 5;
$config['use_page_numbers'] = false;
$config['page_query_string'] = false;
$config['per_page'] = 3;

//Adding Enclosing Markup
$config['full_tag_open'] = '<ul>';
$config['full_tag_close'] = '</ul>';

//Customizing the First Link
$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

//Customizing the Last Link
$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

//Customizing the "Next" Link
$config['next_link'] = 'Next';//&gt;
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

//Customizing the "Previous" Link
$config['prev_link'] = 'Prev';//&lt;
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

//Customizing the "Current Page" Link
$config['cur_tag_open'] = '<li class="active"><a>';
$config['cur_tag_close'] = '</li></a>';

//Customizing the "Digit" Link
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

?>