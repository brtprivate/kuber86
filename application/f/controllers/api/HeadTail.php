<?php

use phpDocumentor\Reflection\Types\Object_;
use Restserver\Libraries\REST_Controller;

include APPPATH . '/libraries/REST_Controller.php';
include APPPATH . '/libraries/Format.php';
class HeadTail extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $header = $this->input->request_headers('token');

        if (!isset($header['Token'])) {
            $data['message'] = 'Invalid Request';
            $data['code'] = HTTP_UNAUTHORIZED;
            $this->response($data, HTTP_OK);
            exit();
        }

        if ($header['Token'] != getToken()) {
            $data['message'] = 'Invalid Authorization';
            $data['code'] = HTTP_METHOD_NOT_ALLOWED;
            $this->response($data, HTTP_OK);
            exit();
        }

        $this->data = $this->input->post();
        // print_r($this->data['user_id']);
        $this->load->model([
            'HeadTail_model',
            'Users_model'
        ]);
    }

    public function room_post()
    {
        if (empty($this->data['user_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $room_data = $this->HeadTail_model->getRoom();
        if ($room_data) {
            $rooms = array();

            foreach ($room_data as $key => $value) {
                $rooms[$key]['id'] = $value->id;
                $rooms[$key]['min_coin'] = $value->min_coin;
                $rooms[$key]['max_coin'] = $value->max_coin;
                $rooms[$key]['added_date'] = $value->added_date;
                $rooms[$key]['updated_date'] = $value->updated_date;
                $rooms[$key]['isDeleted'] = $value->isDeleted;
                $rooms[$key]['online'] = $this->HeadTail_model->getRoomOnline($value->id);
            }

            $data['message'] = 'Success';
            $data['room_data'] = $rooms;
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Room Starting Soon';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function get_active_game_post()
    {
        $total_bet_dragon = $this->input->post('total_bet_dragon');
        $total_bet_tiger = $this->input->post('total_bet_tiger');
        $total_bet_tie = $this->input->post('total_bet_tie');
        $increment = $this->input->post('increment');
        if (empty($this->data['user_id']) || empty($this->data['token']) || empty($this->data['room_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $room = $this->HeadTail_model->getRoom($this->data['room_id'], $this->data['user_id']);
        if (empty($room)) {
            $data['message'] = 'Invalid Room';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $bot_user = $this->Users_model->AllBotUserList();
        $data['bot_user'] = $bot_user;
        $game_data = $this->HeadTail_model->getActiveGameOnTable($this->data['room_id']);
        if ($game_data) {
            $game_cards = array();
            if ($game_data[0]->status) {
                $game_cards = $this->HeadTail_model->GetGameCards($game_data[0]->id);
            }

            $new_game_data[0]['id'] = $game_data[0]->id;
            $new_game_data[0]['room_id'] = $game_data[0]->room_id;
            $new_game_data[0]['main_card'] = $game_data[0]->main_card;
            $new_game_data[0]['winning'] = $game_data[0]->winning;
            $new_game_data[0]['status'] = $game_data[0]->status;
            $new_game_data[0]['added_date'] = $game_data[0]->added_date;
            $added_datetime_sec = strtotime($game_data[0]->added_date);
            $new_game_data[0]['time_remaining'] = ($added_datetime_sec+DRAGON_TIME_FOR_BET) - time();
            $new_game_data[0]['end_datetime'] = $game_data[0]->end_datetime;
            $new_game_data[0]['updated_date'] = $game_data[0]->updated_date;

            $data['message'] = 'Success';
            $data['game_data'] = $new_game_data;
            $data['game_cards'] = $game_cards;
            // $data['online'] = $this->HeadTail_model->getRoomOnline($this->data['room_id']);
            $data['online_users'] = $this->HeadTail_model->getRoomOnlineUser($this->data['room_id']);
            $data['online'] = rand(300, 350)+count($data['online_users']);
            $data['last_bet'] = $this->HeadTail_model->ViewBet('', $game_data[0]->id, '', '', 1);
            $data['my_dragon_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 0, $this->data['user_id']);
            $data['my_tiger_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 1, $this->data['user_id']);
            $data['my_tie_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 2, $this->data['user_id']);
            $dragon_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 0);
            $tiger_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 1);
            $tie_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 2);
            if ($increment==1) {
                $data['dragon_bet'] = rand($total_bet_dragon, $total_bet_dragon+10000)+$dragon_bet;
                $data['tiger_bet'] = rand($total_bet_tiger, $total_bet_tiger+10000)+$tiger_bet;
                $data['tie_bet'] = rand($total_bet_tie, $total_bet_tie+2000)+$tie_bet;
            } else {
                $data['dragon_bet'] = $total_bet_dragon+$dragon_bet;
                $data['tiger_bet'] = $total_bet_tiger+$tiger_bet;
                $data['tie_bet'] = $total_bet_tie+$tie_bet;
            }

            $data['last_winning'] = $this->HeadTail_model->LastWinningBet($this->data['room_id']);
            $data['profile'] = $user;
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Game Starting Soon';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function get_active_game_socket_post()
    {
        $total_bet_dragon = $this->input->post('total_bet_dragon');
        $total_bet_tiger = $this->input->post('total_bet_tiger');
        $total_bet_tie = $this->input->post('total_bet_tie');
        $increment = $this->input->post('increment');
        // if (empty($this->data['user_id']) || empty($this->data['token']) || empty($this->data['room_id'])) {
        //     $data['message'] = 'Invalid Parameter';
        //     $data['code'] = HTTP_NOT_ACCEPTABLE;
        //     $this->response($data, 200);
        //     exit();
        // }

        // if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
        //     $data['message'] = 'Invalid User';
        //     $data['code'] = HTTP_INVALID;
        //     $this->response($data, HTTP_OK);
        //     exit();
        // }

        // $user = $this->Users_model->UserProfile($this->data['user_id']);
        // if (empty($user)) {
        //     $data['message'] = 'Invalid User';
        //     $data['code'] = HTTP_NOT_ACCEPTABLE;
        //     $this->response($data, 200);
        //     exit();
        // }

        // $room = $this->HeadTail_model->getRoom($this->data['room_id'], $this->data['user_id']);
        // if (empty($room)) {
        //     $data['message'] = 'Invalid Room';
        //     $data['code'] = HTTP_NOT_ACCEPTABLE;
        //     $this->response($data, 200);
        //     exit();
        // }

        $bot_user = $this->Users_model->AllBotUserList();
        $data['bot_user'] = $bot_user;
        $game_data = $this->HeadTail_model->getActiveGameOnTable($this->data['room_id']);
        if ($game_data) {
            $game_cards = array();
            if ($game_data[0]->status) {
                $game_cards = $this->HeadTail_model->GetGameCards($game_data[0]->id);
            }

            $new_game_data[0]['id'] = $game_data[0]->id;
            $new_game_data[0]['room_id'] = $game_data[0]->room_id;
            $new_game_data[0]['main_card'] = $game_data[0]->main_card;
            $new_game_data[0]['winning'] = $game_data[0]->winning;
            $new_game_data[0]['status'] = $game_data[0]->status;
            $new_game_data[0]['added_date'] = $game_data[0]->added_date;
            $added_datetime_sec = strtotime($game_data[0]->added_date);
            $new_game_data[0]['time_remaining'] = ($added_datetime_sec+DRAGON_TIME_FOR_BET) - time();
            $new_game_data[0]['end_datetime'] = $game_data[0]->end_datetime;
            $new_game_data[0]['updated_date'] = $game_data[0]->updated_date;

            $data['message'] = 'Success';
            $data['game_data'] = $new_game_data;
            $data['game_cards'] = $game_cards;
            // $data['online'] = $this->HeadTail_model->getRoomOnline($this->data['room_id']);
            $data['online_users'] = $this->HeadTail_model->getRoomOnlineUser($this->data['room_id']);
            $data['online'] = rand(300, 350)+count($data['online_users']);
            $data['last_bet'] = $this->HeadTail_model->ViewBet('', $game_data[0]->id, '', '', 1);
            $data['my_dragon_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 0, '');
            $data['my_tiger_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 1, '');
            $data['my_tie_bet'] = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 2, '');
            $dragon_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 0);
            $tiger_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 1);
            $tie_bet = $this->HeadTail_model->TotalBetAmount($game_data[0]->id, 2);
            if ($increment==1) {
                $data['dragon_bet'] = rand($total_bet_dragon, $total_bet_dragon+10000)+$dragon_bet;
                $data['tiger_bet'] = rand($total_bet_tiger, $total_bet_tiger+10000)+$tiger_bet;
                $data['tie_bet'] = rand($total_bet_tie, $total_bet_tie+2000)+$tie_bet;
            } else {
                $data['dragon_bet'] = $total_bet_dragon+$dragon_bet;
                $data['tiger_bet'] = $total_bet_tiger+$tiger_bet;
                $data['tie_bet'] = $total_bet_tie+$tie_bet;
            }

            $data['last_winning'] = $this->HeadTail_model->LastWinningBet($this->data['room_id']);
            // $data['profile'] = $user;
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Game Starting Soon';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function leave_room_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['token'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $room = $this->HeadTail_model->getRoom($this->data['room_id'], $this->data['user_id']);
        if (empty($room)) {
            $data['message'] = 'Invalid Room';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $leave_room = $this->HeadTail_model->leave_room($this->data['user_id']);
        if ($leave_room) {
            $data['message'] = 'Success';
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Something wents wrong';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function place_bet_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['game_id']) || ($this->data['bet']=="") || empty($this->data['amount'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        if (!in_array($this->data['bet'], array(DRAGON,TIGER,TIE))) {
            $data['message'] = 'Invalid Bet';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($user[0]->wallet<100) {
            $data['message'] = 'Required Minimum 100 Coins to Play';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($user[0]->wallet<$this->data['amount']) {
            $data['message'] = 'Insufficient Wallet Amount';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $game = $this->HeadTail_model->View($this->data['game_id']);
        if (!$game) {
            $data['message'] = 'Invalid Game Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($game->status) {
            $data['message'] = 'Can\'t Place Bet, Game Has Been Ended';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        // $bet = $this->HeadTail_model->ViewBet($this->data['user_id'], $this->data['game_id'], $this->data['bet']);

        // if ($bet) {
        //     $data['message'] = 'One Bet Already Placed';
        //     $data['code'] = HTTP_NOT_ACCEPTABLE;
        //     $this->response($data, 200);
        //     exit();
        // }

        $bet_data = [
            'head_tail_id' => $this->data['game_id'],
            'user_id' => $this->data['user_id'],
            'bet' => $this->data['bet'],
            'amount' => $this->data['amount'],
            'added_date' => date('Y-m-d H:i:s')

        ];

        $bet_id = $this->HeadTail_model->PlaceBet($bet_data);

        $my_head_bet = $this->HeadTail_model->get_dragon_total_bet($this->data['user_id'],$this->data['game_id']);
        $my_tail_bet = $this->HeadTail_model->get_tiger_total_bet($this->data['user_id'],$this->data['game_id']);
        $my_tie_bet = $this->HeadTail_model->get_tie_total_bet($this->data['user_id'],$this->data['game_id']);


        if ($bet_id) {
            $this->HeadTail_model->MinusWallet($this->data['user_id'], $this->data['amount']);
            log_statement ( $this->data['user_id'], HT,-$this->data['amount'],$bet_id) ;
            $data['message'] = 'Success';
            $data['bet_id'] = $bet_id;
            $user_wallet = $this->Users_model->UserProfile($this->data['user_id']);
            $data['wallet'] = $user_wallet[0]->wallet;
            $data['my_head_bet'] = $this->HeadTail_model->TotalBetAmount($this->data['game_id'], 0, $this->data['user_id']);
            $data['my_tail_bet'] = $this->HeadTail_model->TotalBetAmount($this->data['game_id'], 1, $this->data['user_id']);
            $data['my_tie_bet'] = $this->HeadTail_model->TotalBetAmount($this->data['game_id'], 2, $this->data['user_id']);
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Something Wents Wrong';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function repeat_bet_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['game_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $game = $this->HeadTail_model->View($this->data['game_id']);
        if (!$game) {
            $data['message'] = 'Invalid Game Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($game->status) {
            $data['message'] = 'Can\'t Place Bet, Game Has Been Ended';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $bet = $this->HeadTail_model->ViewBet($this->data['user_id'], $this->data['game_id']);
        if ($bet) {
            $data['message'] = 'One Bet Already Placed';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $last_bet = $this->HeadTail_model->ViewBet($this->data['user_id']);
        if ($user[0]->wallet<$last_bet[0]->amount) {
            $data['message'] = 'Insufficient Wallet Amount';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        // $bet_data = [
        //     'head_tail_id' => $this->data['game_id'],
        //     'user_id' => $this->data['user_id'],
        //     'bet' => $last_bet[0]->bet,
        //     'amount' => $last_bet[0]->amount,
        //     'added_date' => date('Y-m-d H:i:s')

        // ];

        // $bet_id = $this->HeadTail_model->PlaceBet($bet_data);

        // if($bet_id)
        // {
        // $this->HeadTail_model->MinusWallet($this->data['user_id'], $last_bet[0]->amount);
        $data['message'] = 'Success';
        // $data['bet_id'] = $bet_id;
        $data['bet'] = $last_bet[0]->bet;
        $data['amount'] = $last_bet[0]->amount;
        $user_wallet = $this->Users_model->UserProfile($this->data['user_id']);
        $data['wallet'] = $user_wallet[0]->wallet;
        $data['code'] = HTTP_OK;
        $this->response($data, HTTP_OK);
        exit();
        // }
        // else
        // {
        //     $data['message'] = 'Something Wents Wrong';
        //     $data['code'] = HTTP_NOT_ACCEPTABLE;
        //     $this->response($data, 200);
        //     exit();
        // }
    }

    public function double_bet_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['game_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $game = $this->HeadTail_model->View($this->data['game_id']);
        if (!$game) {
            $data['message'] = 'Invalid Game Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($game->status) {
            $data['message'] = 'Can\'t Place Bet, Game Has Been Ended';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $bet = $this->HeadTail_model->ViewBet($this->data['user_id'], $this->data['game_id']);
        if ($bet) {
            $data['message'] = 'One Bet Already Placed';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $last_bet = $this->HeadTail_model->ViewBet($this->data['user_id']);
        $amount = $last_bet[0]->amount*2;
        if ($user[0]->wallet<$amount) {
            $data['message'] = 'Insufficient Wallet Amount';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $bet_data = [
            'head_tail_id' => $this->data['game_id'],
            'user_id' => $this->data['user_id'],
            'bet' => $last_bet[0]->bet,
            'amount' => $amount,
            'added_date' => date('Y-m-d H:i:s')
        ];

        $bet_id = $this->HeadTail_model->PlaceBet($bet_data);

        if ($bet_id) {
            $this->HeadTail_model->MinusWallet($this->data['user_id'], $amount);
            $data['message'] = 'Success';
            $data['bet_id'] = $bet_id;
            $data['bet'] = $last_bet[0]->bet;
            $data['amount'] = $amount;
            $user_wallet = $this->Users_model->UserProfile($this->data['user_id']);
            $data['wallet'] = $user_wallet[0]->wallet;
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Something Wents Wrong';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }

    public function cancel_bet_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['game_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $game = $this->HeadTail_model->View($this->data['game_id']);
        if (!$game) {
            $data['message'] = 'Invalid Game Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $bet = $this->HeadTail_model->ViewBet($this->data['user_id'], $this->data['game_id'], '', '');
        if (!$bet) {
            $data['message'] = 'Invalid Bet';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($game->status) {
            $data['message'] = 'Can\'t Cancel Bet, Game Has Been Ended';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if ($this->HeadTail_model->DeleteBet($bet[0]->id, $this->data['user_id'], $this->data['game_id'])) {
            $this->HeadTail_model->AddWallet($this->data['user_id'], $bet[0]->amount);
            $data['message'] = 'Bet Cancel Successfully';
            $user_wallet = $this->Users_model->UserProfile($this->data['user_id']);
            $data['wallet'] = $user_wallet[0]->wallet;
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            $data['message'] = 'Something Wents Wrong';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }
    public function get_result_post()
    {
        if (empty($this->data['user_id']) || empty($this->data['game_id'])) {
            $data['message'] = 'Invalid Parameter';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        if (!$this->Users_model->TokenConfirm($this->data['user_id'], $this->data['token'])) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_INVALID;
            $this->response($data, HTTP_OK);
            exit();
        }

        $user = $this->Users_model->UserProfile($this->data['user_id']);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $game = $this->HeadTail_model->View($this->data['game_id']);
        if (!$game) {
            $data['message'] = 'Invalid Game Id';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }

        $win_amount = 0;
        $bet_amount = 0;
        $bet = $this->HeadTail_model->ViewBet($this->data['user_id'], $this->data['game_id']);
        if (!$bet) {
            $data['win_amount'] = $win_amount;
            $data['bet_amount'] = $bet_amount;
            $data['diff_amount'] = $win_amount-$bet_amount;
            $data['message'] = 'No Bet';
            $data['code'] = 101;
            $this->response($data, 200);
            exit();
        }

        foreach ($bet as $key => $value) {
            $win_amount += $value->user_amount;
            $bet_amount += $value->amount;
        }

        $data['win_amount'] = $win_amount;
        $data['bet_amount'] = $bet_amount;
        $data['diff_amount'] = $win_amount-$bet_amount;

        if($data['diff_amount']>0){
            $data['message'] = "You Win";
            $data['code'] = 102;
            $this->response($data, 200);
            exit();
        }else{
            $data['message'] = "You Loss";
            $data['code'] = 103;
            $this->response($data, 200);
            exit();
        }
    }


    public function get_total_bet_amount_post()
    {
        $user_id = $this->input->post('user_id');
        $token = $this->input->post('token');
        $game_id = $this->input->post('game_id');
        if((empty($user_id)) || (empty($token)) || (empty($game_id))){
            $data['message'] = 'Invalid parameters';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
        $user = $this->Users_model->UserProfile($user_id);
        if (empty($user)) {
            $data['message'] = 'Invalid User';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }


        $my_head_bet = $this->HeadTail_model->get_dragon_total_bet($this->data['user_id'],$this->data['game_id']);
        $my_tail_bet = $this->HeadTail_model->get_tiger_total_bet($this->data['user_id'],$this->data['game_id']);
        $my_tie_bet = $this->HeadTail_model->get_tie_total_bet($this->data['user_id'],$this->data['game_id']);

        if($my_head_bet || $my_tail_bet || $my_tie_bet){
            $data['message'] = 'Success';
            $data['my_head_bet'] = $my_head_bet ?? '';
            $data['my_tail_bet'] = $my_tail_bet ?? '';
            $data['my_tie_bet'] = $my_tie_bet ?? '';
            $data['code'] = HTTP_OK;
            $this->response($data, HTTP_OK);
            exit();
        } else {
            // $data['message'] = 'No Data';
            $data['my_head_bet'] = $my_head_bet ?? '';
            $data['my_tail_bet'] = $my_tail_bet ?? '';
            $data['my_tie_bet'] = $my_tie_bet ?? '';
            $data['code'] = HTTP_NOT_ACCEPTABLE;
            $this->response($data, 200);
            exit();
        }
    }
}