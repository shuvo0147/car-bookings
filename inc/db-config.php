<?php 
	/**
	*  Database configuration main class 
	*/
	class DBConfiq
	{
		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $db   = "vehicle_booking";
		protected $conn;

		public function __construct()
		{
			$this->connect();
		}
    
    # connect database 
    public function connect()
    {
    	$this->conn = new mysqli($this->host,$this->user,$this->pass,$this->db);
    	if ( $this->conn->connect_error ) {
    		die('Connection Failed: ' . $this->conn->connect_error);
    	}
    	return $this->conn;
    }
    
    # connection close 
    public function __destruct()
	 	{
	 	  $this->conn->close();
	 	}
  }
?>