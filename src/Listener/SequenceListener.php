<?php
/**
 * Created by PhpStorm.
 * User: dederobert
 * Date: 21/05/19
 * Time: 18:09
 */

namespace PPHI\Listener;

interface SequenceListener
{
    public function onException(\Exception $e);

    public function onComplete();
}
