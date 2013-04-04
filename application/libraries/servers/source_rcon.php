<?php
DEFINE('PACKET_SIZE', '4096');
DEFINE('SERVERDATA_AUTH', 03);
DEFINE('SERVERDATA_EXECCOMMAND', 02);

class Source_rcon
{
	// Private Vars
	private $request_id;
	private $socket;
	private $timeout = .5;

	// Protected Vars
	protected $authenticated = false;

	function connect($ip, $port, $password)
	{
		$this->request_id = 1;

		// Open socket to the server
		$this->socket = fsockopen('tcp://'.$ip, $port, $errno, $errstr, 1);
		socket_set_timeout($this->socket, $this->timeout);

		// Write the auth packet
		$this->write(SERVERDATA_AUTH, $password);

		$this->request_id++;

		// Read the response packet
		$response = $this->read_packet();

		if ($response[1]['response'])
		{
			$response = $this->read_packet();
		}

		if (isset($response[1]['id']) && $response[1]['id'] == -1)
		{
			$this->authenticated = false;
			return false;
		}
		else
		{
			$this->authenticated = true;
			return true;
		}
	}

	function send_command($command)
	{
		if ( ! $this->authenticated)
		{
			return "You must be authenticated with the server before sending commands!";
		}

		// Build the commmand packet
		$this->write(SERVERDATA_EXECCOMMAND, $command);
		$data = pack("V", strlen($data)).$data;

		// Send the packet
		fwrite($this->socket, $data, strlen($data));

		$this->request_id++;

		$response = $this->read();

		dump($response);

		return $response[1]['s1'];
	}

	private function read()
	{
		$packets = $this->read_packet();

		if ( ! $packets)
		{
			return;
		}

		foreach($packets as $pack)
		{
			if (isset($return[$pack['id']]))
			{
				$return[$pack['id']]['S1'] .= $pack['s1'];
				$return[$pack['id']]['s2'] .= $pack['s1'];
			}
			else
			{
				$return[$pack['ID']] = array(
					'response' => $pack['response'],
					's1' => $pack['s1'],
					's2' => $pack['s2'],
				);
			}
		}
		return $return;
	}

	private function read_packet()
	{
		$i = 1;

		$return = array();

		while ($size = fread($this->socket, 4))
		{
			$size = $this->get_long($size);

			if ($size > PACKET_SIZE)
			{
				$packet = "\x00\x00\x00\x00\x00\x00\x00\x00".fread($this->socket, PACKET_SIZE);
			}
			else
			{
				$packet = fread($this->socket, $size);
			}

			$return[$i]['id']       = $this->get_long($packet);
			$return[$i]['reponse']  = $this->get_long($packet);
			$return[$i]['s1']       = $this->get_string($packet);
			$return[$i]['s2']       = $this->get_string($packet);

			$i++;
		}

		return $return;
	}

	private function write($cmd, $s1='', $s2='')
	{
		// Build the auth packet and send it
		$data = pack("VV", $requestId, $cmd).$s1.chr(0).$s2.chr(0);
		$data = pack("V", strlen($data)).$data;
		fwrite($this->socket, $data, strlen($data));
	}

	private function get_byte(&$string)
	{
		$data = substr($string, 0, 1);
		$string = substr($string, 1);
		$data = unpack('Cvalue', $data);

		return $data['value'];
	}

	private function get_short_unsigned(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('nvalue', $data);

		return $data['value'];
	}

	private function get_short_signed(&$string)
	{
		$data = substr($string, 0, 2);
		$string = substr($string, 2);
		$data = unpack('svalue', $data);

		return $data['value'];
	}

	private function get_long(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$data = unpack('Vvalue', $data);

		return $data['value'];
	}

	private function get_float(&$string)
	{
		$data = substr($string, 0, 4);
		$string = substr($string, 4);
		$array = unpack("fvalue", $data);

		return $array['value'];
	}

	private function get_string(&$string)
	{
		$data = "";
		$byte = substr($string, 0, 1);
		$string = substr($string, 1);

		while (ord($byte) != "0"){
			$data .= $byte;
			$byte = substr($string, 0, 1);
			$string = substr($string, 1);
		}

		return $data;
	}

}

?>