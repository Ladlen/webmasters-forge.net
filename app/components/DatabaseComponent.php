<?php

/**
 * Interface DatabaseOperations
 *
 * Database interface.
 *
 * @author Dolhov Dmitryy <TwilightTowerDU@gmail.com>
 */
interface DatabaseComponent
{
    public function selectQuery($sql);

    public function query($sql);

    /**
     *
     *
     * @param $string
     * @return mixed
     */
    public function escapeString($string);
}
