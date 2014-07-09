<?php
App::uses('AppModel', 'Model');
/**
 * Connection Model
 *
 */
class Connection extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    // ----------------------------
    // プライベートメソッド
    // ----------------------------

    // 
    // peer_id からレコードを取得
    // 
	private function _getFromPeerId($peer_id) {
        $result = $this->find('first',
            array(
                'conditions' => array(
                    'peer_id' => $peer_id,
                ),
            )
        );
        if (!$result) {
            return null;
        }
        return $result['Connection'];
	}

    // 
    // peer_id を新規登録する
    // 
	private function _add($data) {
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['status']     = MY_STATUS_NEW;
        $this->save($data);

        // 結果をJsonデータ用に整形
        $result = array(
            'status'    => MY_STATUS_NEW,
        );

        return $result;
	}

    // 
    // 他の待機中の相手を検索する
    // 
	private function _search($data) {

        $_me = $this->_getFromPeerId($data['peer_id']);
        if (!$_me) {
            return false;
        }

        // 先に他の相手からマッチング中に更新された場合
        if ($_me['other_peer_id']) {

            // その相手を取得する
            $result = $this->find('first',
                array(
                    'conditions' => array(
                        'other_peer_id' => $_me['peer_id'],
                    ),
                )
            );
            // 相手が見つからなければ、終了
            if (!$result) {
                return false;
            }
            $_other = $result['Connection'];

            // 自分のステータスをマッチング中に更新
            $this->save(array(
                'id'            => $_me['id'],
                'status'        => MY_STATUS_MATCHING,
            ));

            // 相手をJsonデータ用に整形
            $_other = array(
                'peer_id'   => $_other['peer_id'],
                'name'      => $_other['name'],
                'country'   => $_other['country'],
                'message'   => $_other['message'],
                'status'    => MY_STATUS_MATCHING,
            );
    
            return $_other;
        }

        // 待機中の相手を探す
        $result = $this->find('first',
            array(
                'conditions' => array(
//                    'peer_id !='    => $data['peer_id'],
                    'id >'          => $_me['id'],  //自分より新しいレコード
                    'status'        => MY_STATUS_NEW,
                ),
                'order' => 'rand()',
            )
        );
        // 相手が見つからなければ、終了
        if (!$result) {
            return false;
        }
        $_other = $result['Connection'];

        $_me = $this->_getFromPeerId($data['peer_id']);

        // 相手が見つかったら、自分のステータスをマッチング中に更新
        $this->save(array(
            'id'            => $_me['id'],
            'status'        => MY_STATUS_MATCHING,
            'other_peer_id' => $_other['peer_id'],
        ));
        // 相手のpeer_idに自分をセットしておく
        $this->save(array(
            'id'            => $_other['id'],
            'other_peer_id' => $_me['peer_id'],
        ));

        // 相手をJsonデータ用に整形
        $_other = array(
            'peer_id'   => $_other['peer_id'],
            'name'      => $_other['name'],
            'country'   => $_other['country'],
            'message'   => $_other['message'],
            'status'    => MY_STATUS_MATCHING,
        );

        return $_other;
	}

    // 
    // マッチング中
    // 
	private function _matching($data) {

        // まだ回答前であれば終了
        if (empty($data['answer'])) {
            return true;
        }

        // 回答されていれば、自分のステータスを更新する
        $_me = $this->_getFromPeerId($data['peer_id']);
        if (!$_me) {
            return true;
        }
        // OKの場合
        if ($data['answer'] == 'OK') {
            $this->save(array(
                'id'            => $_me['id'],
                'status'        => MY_STATUS_MATCHING_OK,
            ));
            // 結果をJsonデータ用に整形
            $result = array(
                'status'    => MY_STATUS_MATCHING_OK,
            );

        // NGの場合
        } elseif ($data['answer'] == 'NG') {
            $this->save(array(
                'id'            => $_me['id'],
                'status'        => MY_STATUS_MATCHING_NG,
            ));
            // 結果をJsonデータ用に整形
            $result = array(
                'status'    => MY_STATUS_MATCHING_NG,
            );

        } else {
            return true;
        }

        return $result;
	}

    // 
    // マッチングOK回答後の待機中
    // 
	private function _matchingOpening($data) {

        // 相手の結果を取得する
        $result = $this->find('first',
            array(
                'conditions' => array(
                    'other_peer_id' => $data['peer_id'],
                ),
            )
        );
        // データが見つからない場合（すでに相手がキャンセル済み）
        if (!$result) {
            // 自分のステータスを更新する
            $_me = $this->_getFromPeerId($data['peer_id']);
            $this->save(array(
                'id'            => $_me['id'],
                'other_peer_id' => NULL,
                'status'        => MY_STATUS_NEW,
            ));
            // 結果をJsonデータ用に整形
            $result = array(
                'other_peer_id' => '',
                'status'        => MY_STATUS_NEW,
            );
            return $result;
        }
        $_other = $result['Connection'];

        $_me = $this->_getFromPeerId($data['peer_id']);

        // 相手がOKの場合
        if ($_other['status'] == MY_STATUS_MATCHING_OK
            || $_other['status'] == MY_STATUS_CONNECT
        ) {
            // 自分のステータスを更新する
            $this->save(array(
                'id'            => $_me['id'],
                'status'        => MY_STATUS_CONNECT,
            ));
            // 結果をJsonデータ用に整形
            $result = array(
                'other_peer_id' => $_other['peer_id'],
                'name'          => $_other['name'],
                'country'       => $_other['country'],
                'message'       => $_other['message'],
                'status'        => MY_STATUS_CONNECT,
            );

        // 相手がNGの場合
        } elseif ($_other['status'] == MY_STATUS_MATCHING_NG
                || $_other['status'] == MY_STATUS_NEW
        ) {
            // 自分のステータスを更新する
            $this->save(array(
                'id'            => $_me['id'],
                'other_peer_id' => NULL,
                'status'        => MY_STATUS_NEW,
            ));
            // 結果をJsonデータ用に整形
            $result = array(
                'other_peer_id' => '',
                'status'        => MY_STATUS_NEW,
            );

        // 未回答の場合
        } else {
            return true;
        }

        return $result;
	}

    // 
    // マッチングNG回答後の待機中
    // 
	private function _matchingClosing($data) {

        $_me = $this->_getFromPeerId($data['peer_id']);
        if (!$_me) {
            return false;
        }

        // 自分のステータスを更新する
        $this->save(array(
            'id'            => $_me['id'],
            'other_peer_id' => NULL,
            'status'        => MY_STATUS_NEW,
        ));
        // 結果をJsonデータ用に整形
        $result = array(
            'other_peer_id' => '',
            'status'        => MY_STATUS_NEW,
        );

        return $result;
	}


    // ----------------------------
    // パブリックメソッド
    // ----------------------------

    // 
    // 進行管理
    // 
	public function progress($data) {

        // peer_idから現在ステータスを取得
        $_con = $this->_getFromPeerId($data['peer_id']);

        // peer_idが未登録の場合は新規登録する
        if (!$_con) {
            return $this->_add($data);
        }

        // peer_idが登録されている場合は進行状況を更新する
        switch ($_con['status']) {

            //ステータス：待機
            case MY_STATUS_NEW:
                return $this->_search($data);
                break;
    
            //ステータス：マッチング中
            case MY_STATUS_MATCHING:
                return $this->_matching($data);
                break;
    
            //ステータス：マッチングOK
            case MY_STATUS_MATCHING_OK:
                return $this->_matchingOpening($data);
                break;
    
            //ステータス：マッチングNG
            case MY_STATUS_MATCHING_NG:
                return $this->_matchingClosing($data);
                break;
    
            //ステータス：接続中
            case MY_STATUS_CONNECT:
                //
                //
                break;
    
            //ステータス：終了
            case MY_STATUS_FINISH:
                //
                //
                break;
    
            //その他は不正
            default:
                //
                //
        }        

        return false;
	}

    // 
    // ポップアップクローズ
    // 
	public function close($data) {

        // 自分のステータスを更新する
        $_me = $this->_getFromPeerId($data['peer_id']);
        if (!$_me) {
            return false;
        }
        $this->save(array(
            'id'            => $_me['id'],
            'status'        => MY_STATUS_NEW,
        ));

        return true;
	}

    // 
    // 接続終了
    // 
	public function finish($data) {

        // 自分のステータスを更新する
        $_me = $this->_getFromPeerId($data['peer_id']);
        if (!$_me) {
            return false;
        }
        $this->save(array(
            'id'            => $_me['id'],
            'status'        => MY_STATUS_FINISH,
        ));

        // 相手のステータスを更新する
        $result = $this->find('first',
            array(
                'conditions' => array(
                    'status'        => MY_STATUS_CONNECT,
                    'other_peer_id' => $data['peer_id'],
                ),
            )
        );
        if (!$result) {
            return false;
        }
        $_other = $result['Connection'];
        $this->save(array(
            'id'            => $_other['id'],
            'status'        => MY_STATUS_FINISH,
        ));

        return true;
	}

}
