<?php

class Pages extends CI_Controller {

    public function index($page = 'null') {// Index page is default.. pulls what ever page that is defined in views/pages
        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) { // if the page does not exist, go to home               
            $page = 'main';
        }
        if ($page == 'logout') {
            $this->session->sess_destroy(); // logout destorys session
        }

        $this->load->model('model_messages'); // load message model
        $this->load->model('model_points'); // load points model

        $data['points'] = $this->model_points->get_all_points();  // gets current point totals 
        $data['points_view'] = $this->load->view('templates/points_view', $data, TRUE); // gets the points table view
        $data['update'] = $this->model_messages->get_message();     // gets the message

        
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function validate() { // this is used for admin login (validates username and password)
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|md5');

        if ($this->form_validation->run()) { // if it passes validation
            $this->load->model('model_users');  // load the users model
            $this->model_users->log_in($this->input->post('user_name'), $this->input->post('password')) ? $this->admin() : $this->index('login');    // try to login , if it works go to admin if not redirect to login page
        } else {
            $this->index('login'); // go to login if validation fails             
        }
    }

    public function update_main_message() { // process new message admin page
        $this->is_active(); // check session 

        $this->load->model('model_messages'); // load the message model    
        $data['message'] = $this->input->post('message');  // get the message from the post
        $data['message_id'] = $this->model_messages->set_message($data['message']);  // set the message, get the new id
        $data['update'] = "Message (" . $data['message_id'] . ") changed to: <p>" . $data['message'] . "</p>";   // message changed message      


        $this->load->view('templates/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('templates/footer', $data);
    }

    public function admin($action = 'home') {

        if ($this->session->active) {
            $this->load->database();
            if (!file_exists(APPPATH . '/views/admin/' . $action . '.php')) {
                $action = 'home';
            }

            $data['update'] = ' ';

            if ($action == "update_message") {
                $this->load->model('model_messages');
                $data['last_message'] = $this->model_messages->get_message();
            }

            if ($action == "new_event") {

                $this->load->model('model_players');
                $data['players'] = $this->model_players->get_players();
                asort($data['players']);
                $data['players']['0'] = "Add New Player";
            }


            $this->load->view('templates/header', $data);
            $this->load->view('admin/' . $action, $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->index('login');
        }
    }

    public function create_new_event() {
        $this->is_active();
        $this->load->model('model_events');
        $this->load->model('model_players');
        $this->load->model('model_points');

        $event['name'] = $this->input->post('Event_name');
        $event['date'] = $this->input->post('Event_date');
        $event['notes'] = $this->input->post('Event_notes');
        $event_id = $this->model_events->set_event($event);

        for ($x = 1; $x <= 10; $x++) {
            $val = $this->input->post("players_" . $x);
            if ($val == 0) {
                $name = "name_" . $x;
                $val = $this->model_players->create_player($this->input->post($name));
            }
            $this->model_points->create_point_award($event_id, $val, $x, 11 - $x);
        }

        for ($s = 1; $s <= 3; $s++) {
            $active_side = $this->input->post('side_' . $s);
            if (isset($active_side)) {
                $player_id = $this->input->post("players_s" . $s);
                if ($player_id == 0) {
                    $name = "name_s" . $s;
                    $player_id = $this->model_players->create_player($this->input->post($name));
                }
                $this->model_points->create_point_award($event_id, $player_id, '*', 3);
                echo $s;
            }
        }



        $data['update'] = "Event #" . $event_id;

        $this->load->view('templates/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('templates/footer', $data);
    }

    public function player($id = '0') {

        $this->load->model('model_messages');
        $this->load->model('model_players');

        $data['update'] = $this->model_messages->get_message();
        $data['player_info'] = $this->model_players->get_player($id);
        $data['points_view'] = $this->load->view('templates/player_view', $data, TRUE);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('templates/footer', $data);
    }

    private function is_active() {
        date_default_timezone_set('America/Denver');
        if (!$this->session->active) {
            echo "<h1>inactive session</h1>";
            echo '<a href="' . site_url() . '">Main Page</a></br></br>';
            echo '<a href="' . site_url('pages/index/login') . '">Login Page</a>';
            exit;
        }
    }
    
    private function set_player_points($event_id){
        for ($x = 1; $x <= 10; $x++) {
            $val = $this->input->post("players_" . $x);
            if ($val == 0) {
                $name = "name_" . $x;
                $val = $this->model_players->create_player($this->input->post($name));
            }
            $this->model_points->create_point_award($event_id, $val, $x, 11 - $x);
        }
    }
    
    private function set_side_points($event_id){
          for ($s = 1; $s <= 3; $s++) {
            $active_side = $this->input->post('side_' . $s);
            if (isset($active_side)) {
                $player_id = $this->input->post("players_s" . $s);
                if ($player_id == 0) {
                    $name = "name_s" . $s;
                    $player_id = $this->model_players->create_player($this->input->post($name));
                }
                $this->model_points->create_point_award($event_id, $player_id, '*', 3);
                echo $s;
            }
        }
    }
    
    private function create_player($post_id){
        return $this->model_players->create_player($this->input->post($post_id));
    }
    

}
