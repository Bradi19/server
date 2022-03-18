<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebSocketServerController extends Controller
{
    private $sockets;
    private $users;
    private $server;

    public function __cunstruct($ip, $port = 0)
    {
        $this->server = socket_create(AF_INET, SOCK_STREAM, 0);
        $this->sockets = array($this->server);
        $this->users = array();
        socket_bind($this->server, $ip, $port);
        socket_listen($this->server, 3);
        echo "[*]Listening: " . $ip . ":" . $port . "\n";
    }
    public function run()
    {
        $write = NULL;
        $except = NULL;
        while (true) {
            $active_sockets = $this->sockets;
            socket_select($active_sockets, $write, $except, NULL);
            foreach ($active_sockets as $socket) {
                if ($socket == $this->server) {
                    $user = socket_accept($this->server);
                    $key = uniqid();
                    $this->sockets[] = $user;
                    $this->users[$key] = array(
                        'socket' => $user,
                        'handshake' => false
                    );
                } else {
                    $buffer = '';
                    $bytes = socket_recv($socket, $buffer, 1024, 0);
                    $key = $this->find_user_by_socket($socket);
                    if (!$this->users[$key]['handshake']) {
                        $this->handshake($key, $buffer);
                    } else {
                        $msg = $this->msg_decode($buffer);
                        echo $msg;
                        $res_msg = $this->msg_encode($msg);
                        socket_write($socket, $res_msg, strlen($res_msg));
                    }
                }
            }
        }
    }
    private function disconnect($socket)
    {
        $key = $this->find_user_by_socket($socket);
        unset($this->users[$key]);
        foreach ($this->sockets as $k => $v) {
            if ($v == $socket) {
                unset($this->sockets[$k]);
            }
        }
        socket_shutdown($socket);
        socket_close($socket);
    }
    private function find_user_by_socket($socket)
    {
        foreach ($this->users as $key => $user) {
            if($user['socket']==$socket){
                return $key;
            }
        }
    }
    private function handshake($k,$buffer){
        // Перехватить значение Sec-WebSocket-Key и зашифровать
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));

        // Возвращаем в соответствии с соглашением информацию о комбинации
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));

        // Отмечаем клиента, который уже пожал руку
        $this->users[$k]['handshake']=true;
        return true;
    }
    private function msg_encode( $buffer ){
        $len = strlen($buffer);
        if ($len <= 125) {
            return "\x81" . chr($len) . $buffer;
        } else if ($len <= 65535) {
            return "\x81" . chr(126) . pack("n", $len) . $buffer;
        } else {
            return "\x81" . char(127) . pack("xxxxN", $len) . $buffer;
        }
    }
    private function msg_decode( $buffer )
    {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;
        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        }
        else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        }
        else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }
}
