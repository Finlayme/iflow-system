<?php
/**
 * Created by PhpStorm.
 * User: Hety <Hetystars@gmail.com>
 * Date: 2021/8/2
 * Time: 19:09
 */

namespace app\common\library\cache\driver;

use think\cache\driver\Redis as RedisDriver;

/**
 * Class Redis
 * @method  int append(string $key, string $value)
 * @method int bitCount(string $key, int $start, int $end)
 * @method  array blPop(array $keys, int $timeout)
 * @method  array brPop(array $keys, int $timeout)
 * @method  string brpoplpush(string $srcKey, string $dstKey, int $timeout)
 * @method  string decr(string $key)
 * @method  int decrBy(string $key, int $value)
 * @method  mixed eval(string $script, array $args = [], int $numKeys = 0)
 * @method  mixed evalSha(string $scriptSha, array $args = [], int $numKeys = 0)
 * @method  bool exists(string $key)
 * @method  int geoAdd(string $key, float $longitude, float $latitude, string $member, ...$args)
 * @method  float geoDist(string $key, string $member1, string $member2, string $unit = 'm')
 * @method  array geohash(string $key, string ...$members)
 * @method  array geopos(string $key, string ...$members)
 * @method  int getBit(string $key, int $offset)
 * @method  int getOption(string $name)
 * @method  string getRange(string $key, int $start, int $end)
 * @method  string getSet(string $key, string $value)
 * @method  string hDel(string $key, string $hashKey1, string $hashKey2 = null, string $hashKeyN = null)
 * @method  bool hExists(string $key, string $hashKey)
 * @method  mixed hGet(string $key, string $hashKey)
 * @method  array hGetAll(string $key)
 * @method  int hIncrBy(string $key, string $hashKey, int $value)
 * @method  float hIncrByFloat(string $key, string $field, float $increment)
 * @method  array hKeys(string $key)
 * @method  int hLen(string $key)
 * @method  int hSet(string $key, string $hashKey, string $value)
 * @method  bool hSetNx(string $key, string $hashKey, string $value)
 * @method  array hVals(string $key)
 * @method  int incr(string $key)
 * @method  int incrBy(string $key, int $value)
 * @method  float incrByFloat(string $key, float $increment)
 * @method  array info(string $option = null)
 * @method  string|bool lGet(string $key, int $index)
 * @method  int lInsert(string $key, int $position, string $pivot, string $value)
 * @method  string|bool lPop(string $key)
 * @method  int|bool lPush(string $key, string $value1, string $value2 = null, string $valueN = null)
 * @method  int|bool lPushx(string $key, string $value)
 * @method  bool lSet(string $key, int $index, string $value)
 * @method  int msetnx(array $array)
 * @method  bool persist(string $key)
 * @method  bool pExpire(string $key, int $ttl)
 * @method  bool pExpireAt(string $key, int $timestamp)
 * @method  bool psetex(string $key, int $ttl, $value)
 * @method  int pttl(string $key)
 * @method  string rPop(string $key)
 * @method  int|bool rPush(string $key, string $value1, string $value2 = null, string $valueN = null)
 * @method  int|bool rPushx(string $key, string $value)
 * @method  mixed rawCommand(...$args)
 * @method  bool renameNx(string $srcKey, string $dstKey)
 * @method  bool restore(string $key, int $ttl, string $value)
 * @method  string rpoplpush(string $srcKey, string $dstKey)
 * @method  int sAdd(string $key, string $value1, string $value2 = null, string $valueN = null)
 * @method  int sAddArray(string $key, array $valueArray)
 * @method  array sDiff(string $key1, string $key2, string $keyN = null)
 * @method  int sDiffStore(string $dstKey, string $key1, string $key2, string $keyN = null)
 * @method  array sInter(string $key1, string $key2, string $keyN = null)
 * @method  int|bool sInterStore(string $dstKey, string $key1, string $key2, string $keyN = null)
 * @method  array sMembers(string $key)
 * @method  bool sMove(string $srcKey, string $dstKey, string $member)
 * @method  string|bool sPop(string $key)
 * @method  string|array|bool sRandMember(string $key, int $count = null)
 * @method  array sUnion(string $key1, string $key2, string $keyN = null)
 * @method  int sUnionStore(string $dstKey, string $key1, string $key2, string $keyN = null)
 * @method  mixed script(string|array $nodeParams, string $command, string $script)
 * @method  int setBit(string $key, int $offset, bool $value)
 * @method  string setRange(string $key, int $offset, $value)
 * @method  int setex(string $key, int $ttl, $value)
 * @method  bool setnx(string $key, $value)
 * @method  array sort(string $key, array $option = null)
 * @method  int strlen(string $key)
 * @method  int ttl(string $key)
 * @method  int type(string $key)
 * @method  void unwatch()
 * @method  void watch(string $key)
 * @method  int zCard(string $key)
 * @method  int zCount(string $key, int $start, int $end)
 * @method  float zIncrBy(string $key, float $value, string $member)
 * @method  int zLexCount(string $key, int $min, int $max)
 * @method  array zPopMin(string $key, int $count)
 * @method  array zPopMax(string $key, int $count)
 * @method  array zRange(string $key, int $start, int $end, bool $withscores = null)
 * @method  array zRangeByLex(string $key, int $min, int $max, int $offset = null, int $limit = null)
 * @method  array zRangeByScore(string $key, string $start, string $end, array $options = [])
 * @method  int zRank(string $key, string $member)
 * @method  array zRemRangeByLex(string $key, int $min, int $max)
 * @method  array zRevRange(string $key, int $start, int $end, bool $withscore = null)
 * @method  array zRevRangeByLex(string $key, int $min, int $max, int $offset = null, int $limit = null)
 * @method  array zRevRangeByScore(string $key, string $start, string $end, array $options = [])
 * @method  int zRevRank(string $key, string $member)
 * @method  float zScore(string $key, mixed $member)
 * @method  bool expire(string $key, int $ttl)
 * @method  int lLen(string $key)
 * @method  string|bool lIndex(string $key, int $index)
 * @method  array lRange(string $key, int $start, int $end)
 * @method  int|bool lRem(string $key, string $value, int $count)
 * @method  array|bool lTrim(string $key, int $start, int $stop)
 * @method  bool rename(string $srcKey, string $dstKey)
 * @method  int sCard(string $key)
 * @method  bool sIsMember(string $key, string $value)
 * @method  int sRem(string $key, string $member1, string $member2 = null, string $memberN = null)
 * @method  int zRem(string $key, string $member1, string $member2 = null, string $memberN = null)
 * @method  int zRemRangeByRank(string $key, int $start, int $end)
 * @method  int zRemRangeByScore(string $key, float|string $start, float|string $end)
 * @method  int zInterStore(string $Output, array $ZSetKeys, array $Weights = null, string $aggregateFunction = 'SUM')
 * @method  int zUnionStore(string $Output, array $ZSetKeys, array $Weights = null, string $aggregateFunction = 'SUM')
 * @method  array hMGet(string $key, array $keys)
 * @method  bool hMSet(string $key, array $keyValues)
 * @method  int zAdd(string $key, array $scoreValues)
 * @method  array pipeline(callable $callback)
 * @method  array transaction(callable $callback)
 * @method  mixed call(callable $callback)
 * @method  void psubscribe(array $patterns, string|array $callback)
 * @method  void subscribe(array $channels, string|array $callback)
 * @method  array geoRadius(string $key, float $longitude, float $latitude, float $radius, string $radiusUnit, array $options)
 * @method  bool expireAt(string $key, int $timestamp)
 * @method  integer xAck(string $stream_key, string $group, array $id_list)
 * @method  string xAdd(string $stream_key, string $id, array $message, int $max_len, bool $approximate)
 * @method  string xClaim(string $stream_key, string $group, string $consumer, string $min_idle_time, array $id_list, array $options)
 * @method  string xDel(string $stream_key, array $id_list)
 * @method  mixed xGroup(...$args)
 * @method  mixed xInfo(...$args)
 * @method  integer xLen(string $stream_key)
 * @method  array xPending(string $stream_key, string $group, string $start, string $end, int $count, string $consumer)
 * @method  array xRange(string $stream_key, string $start, string $end, int $count)
 * @method  array xRevRange(string $stream_key, string $end, string $start, int $count)
 * @method  array xRead(array|string $stream_keys, int $count, int $block)
 * @method  array xReadGroup(string $group, string $consumer, array|string $stream_keys, int $count, int $block)
 * @method  integer xTrim(string $stream_key, int $max_len, bool $approximate)
 * @package app\common\library\cache\driver
 */
class Redis extends RedisDriver
{

    /**
     * @var \Redis;
     */
    protected $handler = null;

    /**
     * @TODO考虑到多key的情况，暂不统一处理key
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->handler->$name(...$arguments);
    }

}