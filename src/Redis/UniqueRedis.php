<?php

namespace LHyperfTools\Redis;
use Exception;
use Hyperf\Redis\Redis;

class UniqueRedis extends Redis
{
    /**
     * @param string $key
     * @param int $length
     * @param int $toBase
     * @return string
     * @throws Exception
     */
    public function generate(string $key, int $length, int $toBase = 36): string
    {
        if ($toBase > 36 || $toBase < 2){
            throw new Exception("进制不能大于36并且不能小于2");
        }
        $incr = base_convert($this->incr($key), 10, $toBase);
        $strLen = mb_strlen($key) + mb_strlen($incr);
        if ($strLen > $length) {
            throw new Exception("长度不够生成唯一主健");
        }
        return strtoupper(get_class()) . ":" . $key . str_pad(strtoupper($incr), $length - mb_strlen($key), '0', STR_PAD_LEFT);
    }
}