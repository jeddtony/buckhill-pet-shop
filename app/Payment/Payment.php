<?php

namespace App\Payment;

interface Payment {
    public function validate( array $details);
}