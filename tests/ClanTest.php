<?php

class ClanTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetListClan()
    {
        $this->get('/api/v1/clans');

        $this->assertResponseOk();
    }
}
