<?php
// models/BookTicket.php

class BookTicket
{
    private $db;

    public function __construct()
    {
        $this->db = dbConnect();
    }
}
