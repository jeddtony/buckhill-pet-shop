<?php

namespace Tests\Unit;

use App\Uuid\CustomUuid;
use Tests\TestCase;

class CustomUuidTest extends TestCase
{

    /**
     * Can generate a UUID.
     *
     * @return void
     */
    public function testCanGenerateUuid(){
        $uuid = CustomUuid::generateUuid('Payment');
        $this->assertTrue(!empty($uuid));
        $this->assertTrue(strlen($uuid) == 36);
    }

}
